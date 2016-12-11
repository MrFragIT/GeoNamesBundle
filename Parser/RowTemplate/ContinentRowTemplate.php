<?php

namespace MrFragIT\GeoNamesBundle\Parser\Template;


use MrFragIT\GeoNamesBundle\Parser\AbstractGeoNamesRow;
use MrFragIT\GeoNamesBundle\Parser\RowDataInterface;

/**
 * Class ContinentRowTemplate
 * @package MrFragIT\GeoNamesBundle\Parser\Template
 */
class ContinentRowTemplate extends AbstractGeoNamesRow implements RowDataInterface
{
    public static function getAttributeNames()
    {
        return [
            'geonameId', 'code','name'
        ];
    }
}