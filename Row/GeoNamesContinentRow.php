<?php

namespace MrFragIT\GeoNamesBundle\Row;

/**
 * Class GeoNamesContinentRow
 * @package MrFragIT\GeoNamesBundle\Row
 */
class GeoNamesContinentRow extends AbstractGeoNamesRow
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