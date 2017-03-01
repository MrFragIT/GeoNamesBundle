<?php

namespace MrFragIT\GeoNamesBundle\Row;

/**
 * Interface GeoNamesRowDataInterface
 * @package MrFragIT\GeoNamesBundle\Row
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