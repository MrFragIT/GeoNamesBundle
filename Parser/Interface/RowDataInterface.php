<?php

namespace MrFragIT\GeoNamesBundle\Parser;


interface RowDataInterface
{
    /**
     * Returns an array mapping index to attribute names
     *
     * @return array
     */
    public static function getAttributeNames();
}