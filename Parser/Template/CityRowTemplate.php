<?php

namespace MrFragIT\GeoNamesBundle\Parser\Template;


use MrFragIT\GeoNamesBundle\Parser\AbstractGeoNamesRow;
use MrFragIT\GeoNamesBundle\Parser\GeoNamesRowDataInterface;

/**
 * Class CityRowTemplate
 * @package GeonamesBundle\Helpers\RowDataTemplates
 */
class CityRowTemplate extends AbstractGeoNamesRow  implements GeoNamesRowDataInterface
{
    public static function getAttributeNames() : array
    {
        return [
            'geonameId',
            'name',
            'asciiname',
            'alternatenames',
            'latitude',
            'longitude',
            'featureClass',
            'featureCode',
            'countryCode',
            'cc2',
            'admin1Code',
            'admin2Code',
            'admin3Code',
            'admin4Code',
            'population',
            'elevation',
            'dem',
            'timeZone',
            'modificationDate'
        ];
    }

}