<?php

namespace MrFragIT\GeoNamesBundle\Command;


use MrFragIT\GeoNamesBundle\Entity\Continent;
use MrFragIT\GeoNamesBundle\FileImporter\GeoNamesContinentFileImporter;
use MrFragIT\GeoNamesBundle\FileReader\GeoNamesFileReader;
use MrFragIT\GeoNamesBundle\Parser\Template\ContinentRowTemplate;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


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
            ->setDefaultOptions()
        ;
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
        (new GeoNamesContinentFileImporter(
            new GeoNamesFileReader($this->getGeoNamesFilePath(), $this->output),
            $this->getEntityManager(),
            $this->output
        ))->parse()->deleteOldEntities();
    }
}