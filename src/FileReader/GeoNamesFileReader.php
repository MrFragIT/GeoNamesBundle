<?php

namespace GeoNames\FileReader;

use ZipArchive;
use GuzzleHttp\Client as Guzzle;
use GeoNames\Common\WriteLnTrait;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GeoNamesFileReader
 * @package GeoNames\FileReader
 */
class GeoNamesFileReader
{
    use WriteLnTrait;

    const MAX_DOWNLOAD_ATTEMPTS = 6;
    const SLEEP_BEFORE_NEXT_ATTEMPT = 10;

    private $output;
    private $tempFile;
    private $totalRows;
    private $fetchedRows;
    private $fileHandler;

    /**
     * GeoNamesFileReader constructor.
     * @param string $path
     * @param OutputInterface|null $output
     */
    public function __construct(string $path, OutputInterface $output = null)
    {
        $this->output = $output;
        $isUrl = filter_var($path, FILTER_VALIDATE_URL);

        // Download file if needed
        if ($isUrl && strpos($path, '.txt') !== false) {
            $this->tempFile = $this->downloadFromGeonames($path);
        } else if ($isUrl && strpos($path, '.zip') !== false) {
            $this->tempFile = $this->downloadZipFromGeonames($path);
        } else {
            $this->writeln(sprintf('<comment>Using local source file: %s</comment>', $path));
            $this->tempFile = $path;
        }

        // Check file download
        if ($isUrl && !$this->tempFile) {
            throw new Exception("Trying to download an unrecognized file, downloadable files must be in .txt or .zip format.");
        }

        // Set local vars
        $this->fetchedRows = 0;
        $this->totalRows = $this->countFileRows() ?: null;
        $this->fileHandler = fopen($this->tempFile, "r");

        // Log to console
        $this->writeln(sprintf('<comment>File contains %s lines.</comment>', $this->totalRows));
        $this->writeln();

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRow(): ?string
    {
        while ($line = fgets($this->fileHandler)) {
            // Skip comments and empty lines
            if ($line{0} == '#' || !strlen($line)) continue;

            // Update stats
            $this->fetchedRows++;

            return $line;
        }
        return false;
    }

    /**
     * @return int|null
     */
    public function getTotalRows(): ?int
    {
        return $this->totalRows;
    }

    /**
     * @return int
     */
    public function getFetchedRowsCount(): int
    {
        return $this->fetchedRows;
    }

    /**
     * @param string $url
     * @param int $attempt
     * @return null|string
     * @throws \Exception
     */
    private function downloadFromGeonames(string $url, int $attempt = 0): ?string
    {
        $toFile = $this->getTempFile();
        $this->writeln(sprintf('<comment>Downloading %s</comment>', $url));
        $startTime = microtime(true);
        try {
            (new Guzzle())->get($url, ['save_to' => $toFile]);
            $this->writeln(sprintf("<comment>Download took %f seconds.</comment>", microtime(true) - $startTime));
        } catch (\Exception $e) {
            $this->writeln(sprintf(
                "<error>Can't download %s %s</error>",
                $url,
                $attempt < self::MAX_DOWNLOAD_ATTEMPTS ? sprintf('trying again in %d seconds.', self::SLEEP_BEFORE_NEXT_ATTEMPT) : ''));
            $attempt++;
            if ($attempt > self::MAX_DOWNLOAD_ATTEMPTS) {
                throw new \Exception(sprintf("Can't download %s. Aborting", $url));
            }

            sleep(self::SLEEP_BEFORE_NEXT_ATTEMPT);
            return $this->downloadFromGeonames($url, $attempt);
        }
        return $toFile;
    }

    /**
     * @param string $url
     * @return null|string
     */
    private function downloadZipFromGeoNames(string $url): ?string
    {
        $toExtract = str_replace('.zip', '.txt', substr($url, strrpos($url, '/') + 1));
        $toPath = sys_get_temp_dir();
        $zipFile = $this->downloadFromGeonames($url);
        $startTime = microtime(true);

        $this->writeln(sprintf('<comment>Extracting %s</comment>', $zipFile));

        try {
            $zip = new ZipArchive();
            $zip->open($zipFile);
            $zip->extractTo($toPath, [$toExtract]);
        } catch (\Exception $e) {
            $this->writeln(sprintf("<error>Can't extract file %s</error>", $zipFile));
            return null;
        }

        unlink($zipFile);

        $this->writeln(sprintf("<comment>Extraction took %f seconds.</comment>", microtime(true) - $startTime));
        return $toPath . '/' . $toExtract;
    }

    /**
     * @return int
     */
    private function countFileRows(): int
    {
        //return intval(exec("wc -l '$this->tempFile'"));
        return intval(exec("cat '$this->tempFile' | grep -v '^$\\|^\\s*\\#' | wc -l"));
    }

    /**
     * @return string
     */
    private function getTempFile(): string
    {
        return sys_get_temp_dir() . '/' . base64_encode(random_bytes(10));
    }
}