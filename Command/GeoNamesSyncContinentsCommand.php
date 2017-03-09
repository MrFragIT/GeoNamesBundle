<?php

namespace MrFragIT\GeoNamesBundle\Command;


use MrFragIT\GeoNamesBundle\FileImporter\GeoNamesContinentFileImporter;
use MrFragIT\GeoNamesBundle\FileReader\GeoNamesFileReader;

/**
 * Class GeoNamesSyncContinentsCommand
 * @package MrFragIT\GeoNamesBundle\Command
 */
class GeoNamesSyncContinentsCommand extends AbstractGeoNamesCommand
{
    const SOURCE_FILE = '@GeoNamesBundle/Resources/geonames/continents.txt';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('geonames:sync:continents')
            ->setDescription('Imports continents table from GeoNames')
            ->setDefaultOptions();
    }

    /**
     * @return string
     */
    protected function getGeoNamesFilePath()
    {
        return $this->getContainer()->get('file_locator')->locate(self::SOURCE_FILE);
    }

    /**
     *
     */
    protected function import()
    {
        $this->output->writeln("\r\n<info>Importing continents</info>\r\n");
        (new GeoNamesContinentFileImporter(
            new GeoNamesFileReader($this->getGeoNamesFilePath(), $this->output),
            $this->getEntityManager(),
            $this->output
        ))->parse()->deleteOldEntities();
    }
}