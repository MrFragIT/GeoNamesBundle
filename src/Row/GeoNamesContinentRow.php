<?php

namespace GeoNames\Row;

/**
 * Class GeoNamesContinentRow
 * @package GeoNames\Row
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