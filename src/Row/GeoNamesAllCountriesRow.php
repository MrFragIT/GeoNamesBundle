<?php

namespace GeoNames\Row;

class GeoNamesAllCountriesRow extends AbstractGeoNamesRow implements GeoNamesRowDataInterface
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