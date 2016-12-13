<?php

namespace MrFragIT\GeoNamesBundle\Parser;


/**
 * Interface RowDataInterface
 * @package MrFragIT\GeoNamesBundle\Parser
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