<?php

namespace MrFragIT\GeoNamesBundle\Parser\Template;


use MrFragIT\GeoNamesBundle\Parser\AbstractGeoNamesRow;


/**
 * Class ContinentRowTemplate
 * @package MrFragIT\GeoNamesBundle\Parser\Template
 */
class ContinentRowTemplate extends AbstractGeoNamesRow
{
    public static function getAttributeNames()
    {
        return [
            'geonameId',
            'code',
            'name'
        ];
    }
}