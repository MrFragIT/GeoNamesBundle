<?php

namespace MrFragIT\GeoNamesBundle\Row;


use Doctrine\Common\Collections\ArrayCollection;


/**
 * Class AbstractGeoNamesRow
 * @package MrFragIT\GeoNamesBundle\Row
 */
abstract class AbstractGeoNamesRow extends ArrayCollection implements GeoNamesRowDataInterface
{
    /**
     * AbstractGeoNamesRow constructor.
     * @param string $raw
     * @throws \Exception
     */
    public function __construct(string $raw)
    {
        $attributes = static::getAttributeNames();

        // split $raw with tabs
        $exploded = explode("\t", $raw);

        if (count($exploded) !== count($attributes)) {
            var_dump($exploded); var_dump($attributes);
            throw new \Exception("Exploded row and attributes are not matching");
        }

        $data = [];

        for ($i = 0; $i < count($attributes); $i++) {
            $data[$attributes[$i]] = trim($exploded[$i]);
        }

        // Initialize array collection
        return parent::__construct($data);
    }
}