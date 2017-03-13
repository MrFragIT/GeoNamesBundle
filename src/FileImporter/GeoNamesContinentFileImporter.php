<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 02/03/17
 * Time: 0.16
 */

namespace GeoNames\FileImporter;

use GeoNames\Entity\Continent;
use GeoNames\Row\GeoNamesContinentRow;

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