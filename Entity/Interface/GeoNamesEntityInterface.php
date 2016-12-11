<?php

namespace MrFragIT\GeoNamesBundle\Entity;

/**
 * Class GeoNamesEntityInterface
 * @package MrFragIT\GeoNamesBundle\Entity
 */
interface GeoNamesEntityInterface
{
    /**
     * @return int
     */
    public function getLastSync();

    /**
     * @param int $lastSync
     * @return GeonamesEntityInterface
     */
    public function setLastSync($lastSync);
}