<?php

namespace MrFragIT\GeoNamesBundle\Command;


trait GeoNamesZipDownload
{
    public function downloadFromGeonames($url, $fromFile)
    {
        $tmpFile = sys_get_temp_dir() . 'geonames.tmp.zip';

        @unlink($tmpFile);

        $this->output->writeln(sprintf('<info>Downloading %s</info>', $url));
        try {
            (new Guzzle())->get($url, ['save_to' => $tmpFile]);
        }catch(\Exception $e) {
            $this->output->writeln(sprintf("<error>Can't download %s</error>", $url));
            return null;
        }

        $this->output->writeln(sprintf('<info>Extracting %s</info>', $tmpFile));
        try {
            $zip = new \ZipArchive();
            $zip->open($tmpFile);
            $zip->extractTo(sys_get_temp_dir(), [$fromFile]);
        }catch(\Exception $e) {
            $this->output->writeln(sprintf("<error>Can't extract file %s</error>", $fromFile));
            return null;
        }

        return sys_get_temp_dir() . $fromFile;
    }
}

