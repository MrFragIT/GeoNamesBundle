<?php

namespace MrFragIT\GeoNamesBundle\FileReader;

use GuzzleHttp\Client as Guzzle;
use MrFragIT\GeoNamesBundle\Common\WriteLnTrait;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GeoNamesFileReader
 * @package MrFragIT\GeoNamesBundle\FileReader
 */
class GeoNamesFileReader
{

    use WriteLnTrait;

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
            $this->tempFile = $this->downloadTxtFromGeonames($path);
        } else if ($isUrl && strpos($path, '.zip') !== false) {
            $this->tempFile = $this->downloadZipFromGeonames($path);
        } else {
            $this->tempFile = $path;
        }

        // Check file download
        if ($isUrl && !$this->tempFile) {
            throw new Exception("Trying to download an unrecognized file, downloadable files must be in .txt or .zip format.");
        }

        $this->fetchedRows = 0;
        $this->totalRows = $this->countFileRows();
        $this->fileHandler = fopen($this->tempFile, "r");
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
        }
        return $line;
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
     * @return null|string
     */
    private function downloadTxtFromGeonames(string $url): ?string
    {
        $toFile = $this->getTempFile();
        $this->writeln(sprintf('<info>Downloading %s</info>', $url));
        try {
            (new Guzzle())->get($url, ['save_to' => $toFile]);
        } catch (\Exception $e) {
            $this->writeln(sprintf("<error>Can't download %s</error>", $url));
            return null;
        }
        return $toFile;
    }

    /**
     * @param string $url
     * @return null|string
     */
    private function downloadZipFromGeonames(string $url): ?string
    {
        $toExtract = str_replace(substr($url, strrpos($url, '/')), '.zip', '.txt');
        $toFile = $this->getTempFile();
        $this->downloadTxtFromGeonames($url);
        $this->writeln(sprintf('<info>Extracting %s</info>', $this->tempFile));
        try {
            $zip = new \ZipArchive();
            $zip->open($this->tempFile);
            $zip->extractTo($toFile, [$toExtract]);
        } catch (\Exception $e) {
            $this->writeln(sprintf("<error>Can't extract file %s</error>", $this->tempFile));
            return null;
        }

        unlink($this->tempFile);
        return $toFile;
    }

    /**
     * @return int
     */
    private function countFileRows(): int
    {
        return intval(exec("wc -l '$this->tempFile'"));
    }

    /**
     * @return string
     */
    private function getTempFile(): string
    {
        return sys_get_temp_dir() . '/' . base64_encode(random_bytes(10));
    }
}