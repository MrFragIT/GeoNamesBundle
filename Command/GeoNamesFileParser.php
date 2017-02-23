<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 23/02/17
 * Time: 23.50
 */

namespace MrFragIT\GeoNamesBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use GuzzleHttp\Client as Guzzle;

/**
 * Class GeoNamesFileParser
 *
 * This class is in charge of downloading a file from geonames into a tempfile
 * then, by calling parse() the temfile will be ridden and persisted into DB
 *
 * @package MrFragIT\GeoNamesBundle\Command
 */
class GeoNamesFileParser
{
    private $input;
    private $output;
    private $tempFile;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $tempFile = null;
    }

    public function downloadTxtFromGeonames($url)
    {
        $toFile = $this->getTempFile();
        $this->output->writeln(sprintf('<info>Downloading %s</info>', $url));
        try {
            (new Guzzle())->get($url, ['save_to' => $toFile]);
        } catch (\Exception $e) {
            $this->output->writeln(sprintf("<error>Can't download %s</error>", $url));
            return null;
        }
        $this->tempFile = $toFile;
        return $this;
    }

    public function downloadZipFromGeonames($url)
    {
        $toExtract = str_replace(substr($url, strrpos($url, '/')), '.zip', '.txt');
        $toFile = $this->getTempFile();
        $this->downloadTxtFromGeonames($url);
        $this->output->writeln(sprintf('<info>Extracting %s</info>', $this->tempFile));
        try {
            $zip = new \ZipArchive();
            $zip->open($this->tempFile);
            $zip->extractTo($toFile, [$toExtract]);
        } catch (\Exception $e) {
            $this->output->writeln(sprintf("<error>Can't extract file %s</error>", $this->tempFile));
            return null;
        }

        unlink($this->tempFile);
        $this->tempFile = $toFile;
        return $this;
    }


    public function parse()
    {
        // TODO implement me
    }

    private function getTempFile()
    {
        return sys_get_temp_dir() . '/' . base64_encode(random_bytes(10));
    }
}