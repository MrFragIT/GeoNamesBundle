<?php

namespace GeonamesBundle\Helpers\RowDataTemplates;


use MrFragIT\GeoNamesBundle\Parser\AbstractGeoNamesRow;
use MrFragIT\GeoNamesBundle\Parser\RowDataInterface;

/**
 * Class CountryRowTemplate
 * @package GeonamesBundle\Helpers\RowDataTemplates
 */
class CountryRowTemplate extends AbstractGeoNamesRow  implements RowDataInterface
{
    public static function getAttributeNames()
    {
        return [
            'iso',
            'iso3',
            'isoNumeric',
            'fips',
            'country',
            'capital',
            'area',
            'population',
            'continentCode',
            'tld',
            'currencyCode',
            'currencyName',
            'phone',
            'postalCodeFormat',
            'postalCodeRegex',
            'languages',
            'geonameId',
            'neighbours'
        ];
    }

}