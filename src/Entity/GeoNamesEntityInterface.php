<?php

namespace GeoNames\Entity;

/**
 * Class GeoNamesEntityInterface
 * @package GeoNames\Entity
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