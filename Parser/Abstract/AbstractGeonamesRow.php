<?php

namespace MrFragIT\GeoNamesBundle\Parser;


use Doctrine\Common\Collections\ArrayCollection;
use GeoNamesBundle\Helpers\Interfaces\RowDataInterface;

abstract class AbstractGeoNamesRow extends ArrayCollection implements RowDataInterface
{
    /**
     * AbstractGeoNamesRow constructor.
     * @param array $raw
     * @throws \Exception
     */
    public function __construct($raw)
    {
        $attributes = static::getAttributeNames();

        // split $raw with tabs
        $exploded = explode("\t", $raw);

        if (count($exploded) !== count($attributes)) {
            var_dump($exploded); var_dump($attributes);
            throw new \Exception("Exploded row and attributes are not matching");
        }

        $data = [];

        for($i=0; $i<count($attributes); $i++)
        {
            $attrName = $attributes[$i];
            $data[$attrName] = trim($exploded[$i]);
        }

        // Initialize array collection
        return parent::__construct($data);
    }
}