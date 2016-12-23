<?php

namespace MrFragIT\GeoNamesBundle\Command;


use GuzzleHttp\Client as Guzzle;


/**
 * Class GeoNamesTxtDownload
 * @package MrFragIT\GeoNamesBundle\Command
 */
trait GeoNamesTxtDownload
{
    public function downloadFromGeonames($url, $toFile)
    {
        $this->output->writeln(sprintf('<info>Downloading %s</info>', $url));
        try {
            (new Guzzle())->get($url, ['save_to' => $toFile]);
        }catch(\Exception $e) {
            $this->output->writeln(sprintf("<error>Can't download %s</error>", $url));
            return null;
        }
        return $toFile;
    }
}