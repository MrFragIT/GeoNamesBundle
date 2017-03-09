<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 09/03/17
 * Time: 23.55
 */

namespace MrFragIT\GeoNamesBundle\FileImporter;


use MrFragIT\GeoNamesBundle\Entity\Country;
use MrFragIT\GeoNamesBundle\Row\GeoNamesCountryRow;

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