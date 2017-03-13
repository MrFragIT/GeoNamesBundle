<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 09/03/17
 * Time: 23.55
 */

namespace GeoNames\FileImporter;


use GeoNames\Entity\Country;
use GeoNames\Row\GeoNamesCountryRow;

class GeoNamesCountryFileImporter extends AbstractGeoNamesFileImporter
{
    protected function getRowObjectFQN(): string
    {
        return GeoNamesCountryRow::class;
    }

    protected function getEntityFQN(): string
    {
        return Country::class;
    }

}