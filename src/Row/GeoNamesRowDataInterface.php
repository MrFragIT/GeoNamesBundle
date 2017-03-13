<?php

namespace GeoNames\Row;

/**
 * Interface GeoNamesRowDataInterface
 * @package GeoNames\Row
 */
interface GeoNamesRowDataInterface
{
    /**
     * Returns an array mapping index to attribute names
     *
     * @return array
     */
    public static function getAttributeNames();
}