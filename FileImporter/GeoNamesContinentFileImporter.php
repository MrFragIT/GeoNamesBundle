<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 02/03/17
 * Time: 0.16
 */

namespace MrFragIT\GeoNamesBundle\FileImporter;

use MrFragIT\GeoNamesBundle\Entity\Continent;
use MrFragIT\GeoNamesBundle\Row\GeoNamesContinentRow;

class GeoNamesContinentFileImporter extends AbstractGeoNamesFileImporter
{
    protected function getRowObjectFQN(): string
    {
        return GeoNamesContinentRow::class;
    }

    protected function getEntityFQN(): string
    {
        return Continent::class;
    }
}