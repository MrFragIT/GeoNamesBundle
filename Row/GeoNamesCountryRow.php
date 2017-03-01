<?php

namespace MrFragIT\GeoNamesBundle\Row;

/**
 * Class CountryRowTemplate
 * @package GeonamesBundle\Helpers\RowDataTemplates
 */
class GeoNamesCountryRow extends AbstractGeoNamesRow implements GeoNamesRowDataInterface
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
            'neighbours',
            'equivalentFipsCode'
        ];
    }

}