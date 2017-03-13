<?php

namespace GeoNames\Command;

use GeoNames\FileImporter\GeoNamesCountryFileImporter;
use GeoNames\FileReader\GeoNamesFileReader;

class GeoNamesSyncCountriesCommand extends AbstractGeoNamesCommand
{
    const SOURCE_URL    = 'http://download.geonames.org/export/dump/countryInfo.txt';

    /**
     *
     */
    protected function configure() : void
    {
        $this
            ->setName('geonames:sync:countries')
            ->setDescription('Imports countries table from GeoNames')
            ->setDefaultOptions()
        ;
    }

    /**
     *
     */
    protected function import()
    {
        $this->output->writeln("\r\n<info>Importing countries</info>\r\n");
        (new GeoNamesCountryFileImporter(
            new GeoNamesFileReader(self::SOURCE_URL, $this->output),
            $this->getEntityManager(),
            $this->output
        ))->parse()->deleteOldEntities();
    }
}
