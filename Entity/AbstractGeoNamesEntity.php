<?php

namespace MrFragIT\GeoNamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class AbstractGeoNamesEntity
 *
 * @package MrFragIT\GeoNamesBundle\Entity
 */
abstract class AbstractGeoNamesEntity implements GeoNamesEntityInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="last_sync", type="integer", unique=false)
     */
    protected $lastSync;

    /**
     * @return int
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

    /**
     * @param int $lastSync
     * @return AbstractGeoNamesEntity
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;
        return $this;
    }
}