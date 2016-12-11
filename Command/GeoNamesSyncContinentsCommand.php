<?php

namespace MrFragIT\GeoNamesBundle\Command;


use MrFragIT\GeoNamesBundle\Entity\Continent;

class GeoNamesSyncContinentsCommand extends AbstractGeoNamesCommand
{
    const SOURCE_FILE    = '@GeoNamesBundle/Resources/geonames/continents.txt';

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('geonames:sync:continents')
            ->setDescription('Imports continents table from Geonames')
            ->setDefaultOptions()
        ;
    }

    /**
     * @return string
     */
    protected function getGeonamesFilePath()
    {
        return $this->getContainer()->get('kernel')->locateResource(self::SOURCE_FILE);
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