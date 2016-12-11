<?php

namespace MrFragIT\GeoNamesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="MrFragIT\GeoNamesBundle\Repository\CityRepository")
 */
class City extends AbstractGeoNamesEntity implements GeoNamesEntityInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false, unique=false)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="asciiname", type="string", length=200, nullable=false, unique=false)
     */
    protected $asciiname;

    /**
     * @var string
     *
     * @ORM\Column(name="alternatenames", type="string", length=10000, nullable=true, unique=false)
     */
    protected $alternateNames;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="decimal", precision=10, scale=7, nullable=true, unique=false)
     */
    protected $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="decimal", precision=10, scale=7, nullable=true, unique=false)
     */
    protected $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="feature_class", type="string", length=1, nullable=false, unique=false)
     */
    protected $featureClass;

    /**
     * @var string
     *
     * @ORM\Column(name="feature_code", type="string", length=10, nullable=false, unique=false)
     */
    protected $featureCode;

    /**
     * @var string
     *
     * @ORM\Column(name="country_code", type="string", length=2, nullable=false, unique=false)
     */
    protected $countryCode;

    /**
     * @var string
     *
     * @ORM\Column(name="cc2", type="string", length=200, nullable=true, unique=false)
     */
    protected $cc2;

    /**
     * @var string
     *
     * @ORM\Column(name="admin1_code", type="string", length=20, nullable=true, unique=false)
     */
    protected $admin1_code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin2_code", type="string", length=80, nullable=true, unique=false)
     */
    protected $admin2_code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin3_code", type="string", length=20, nullable=true, unique=false)
     */
    protected $admin3_code;

    /**
     * @var string
     *
     * @ORM\Column(name="admin4_code", type="string", length=20, nullable=true, unique=false)
     */
    protected $admin4_code;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="bigint", nullable=true, unique=false)
     */
    protected $population;

    /**
     * @var int
     *
     * @ORM\Column(name="elevation", type="integer", nullable=true, unique=false)
     */
    protected $elevation;

    /**
     * @var int
     *
     * @ORM\Column(name="dem", type="integer", nullable=true, unique=false)
     */
    protected $dem;

    /**
     * @var string
     *
     * @ORM\Column(name="time_zone", type="string", length=40, nullable=true, unique=false)
     */
    protected $timeZone;

    /**
     * @var string
     *
     * @ORM\Column(name="modification_date", type="string", length=10, nullable=true, unique=false)
     */
    protected $modificationDate;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return City
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAsciiname()
    {
        return $this->asciiname;
    }

    /**
     * @param string $asciiname
     * @return City
     */
    public function setAsciiname($asciiname)
    {
        $this->asciiname = $asciiname;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlternateNames()
    {
        return $this->alternateNames;
    }

    /**
     * @param string $alternateNames
     * @return City
     */
    public function setAlternateNames($alternateNames)
    {
        $this->alternateNames = $alternateNames;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeatureClass()
    {
        return $this->featureClass;
    }

    /**
     * @param string $featureClass
     * @return City
     */
    public function setFeatureClass($featureClass)
    {
        $this->featureClass = $featureClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getFeatureCode()
    {
        return $this->featureCode;
    }

    /**
     * @param string $featureCode
     * @return City
     */
    public function setFeatureCode($featureCode)
    {
        $this->featureCode = $featureCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     * @return City
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCc2()
    {
        return $this->cc2;
    }

    /**
     * @param string $cc2
     * @return City
     */
    public function setCc2($cc2)
    {
        $this->cc2 = $cc2;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdmin1Code()
    {
        return $this->admin1_code;
    }

    /**
     * @param string $admin1_code
     * @return City
     */
    public function setAdmin1Code($admin1_code)
    {
        $this->admin1_code = $admin1_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdmin2Code()
    {
        return $this->admin2_code;
    }

    /**
     * @param string $admin2_code
     * @return City
     */
    public function setAdmin2Code($admin2_code)
    {
        $this->admin2_code = $admin2_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdmin3Code()
    {
        return $this->admin3_code;
    }

    /**
     * @param string $admin3_code
     * @return City
     */
    public function setAdmin3Code($admin3_code)
    {
        $this->admin3_code = $admin3_code;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdmin4Code()
    {
        return $this->admin4_code;
    }

    /**
     * @param string $admin4_code
     * @return City
     */
    public function setAdmin4Code($admin4_code)
    {
        $this->admin4_code = $admin4_code;
        return $this;
    }

    /**
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param int $population
     * @return City
     */
    public function setPopulation($population)
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return int
     */
    public function getElevation()
    {
        return $this->elevation;
    }

    /**
     * @param int $elevation
     * @return City
     */
    public function setElevation($elevation)
    {
        $this->elevation = $elevation;
        return $this;
    }

    /**
     * @return int
     */
    public function getDem()
    {
        return $this->dem;
    }

    /**
     * @param int $dem
     * @return City
     */
    public function setDem($dem)
    {
        $this->dem = $dem;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * @param string $timeZone
     * @return City
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
        return $this;
    }

    /**
     * @return string
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * @param string $modificationDate
     * @return City
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return City
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }
}

