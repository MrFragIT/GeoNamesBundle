<?php

namespace MrFragIT\GeoNamesBundle\Command;


use MrFragIT\GeoNamesBundle\Entity\Continent;
use MrFragIT\GeoNamesBundle\Parser\Template\ContinentRowTemplate;


/**
 * Class GeoNamesSyncContinentsCommand
 * @package MrFragIT\GeoNamesBundle\Command
 */
class GeoNamesSyncContinentsCommand extends AbstractGeoNamesCommand
{
    const SOURCE_FILE    = '@GeoNamesBundle/Resources/geonames/continents.txt';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('GeoNames:sync:continents')
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
     * @return string
     */
    protected function getRowTemplateClassFQN()
    {
        return ContinentRowTemplate::class;
    }

    /**
     * @return string
     */
    protected function getEntityClassFQN()
    {
        return Continent::class;
    }
}