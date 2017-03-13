<?php

namespace GeoNames\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 *
 * @ORM\Table(name="country")
 * @ORM\Entity(repositoryClass="GeoNames\Repository\CountryRepository")
 */
class Country extends AbstractGeoNamesEntity implements GeoNamesEntityInterface
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
     * @ORM\Column(name="iso", type="string", length=2, unique=true)
     */
    protected $iso;

    /**
     * @var string
     *
     * @ORM\Column(name="iso3", type="string", length=3, unique=true)
     */
    protected $iso3;

    /**
     * @var string
     *
     * @ORM\Column(name="isoNumeric", type="string", length=3, unique=true)
     */
    protected $isoNumeric;

    /**
     * @var string
     *
     * @ORM\Column(name="fips", type="string", length=2, nullable=true, unique=false))
     */
    protected $fips;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="text", nullable=true, unique=false)
     */
    protected $country;

    /**
     * @var string
     *
     * @ORM\Column(name="capital", type="text", nullable=true, unique=false)
     */
    protected $capital;

    /**
     * @var float
     *
     * @ORM\Column(name="area", type="float", nullable=true, unique=false)
     */
    protected $area;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer", nullable=true, unique=false)
     */
    protected $population;

    /**
     * @var string
     *
     * @ORM\Column(name="continent_code", type="string", length=2, nullable=true, unique=false)
     */
    protected $continentCode;

    /**
     * @var string
     *
     * @ORM\Column(name="tld", type="string", length=3, nullable=true, unique=false)
     */
    protected $tld;

    /**
     * @var string
     *
     * @ORM\Column(name="currencyCode", type="string", length=3, nullable=true, unique=false)
     */
    protected $currencyCode;

    /**
     * @var string
     *
     * @ORM\Column(name="currencyName", type="string", length=255, nullable=true, unique=false)
     */
    protected $currencyName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true, unique=false)
     */
    protected $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCodeFormat", type="text", nullable=true, unique=false)
     */
    protected $postalCodeFormat;

    /**
     * @var string
     *
     * @ORM\Column(name="postalCodeRegex", type="text", nullable=true, unique=false)
     */
    protected $postalCodeRegex;

    /**
     * @var string
     *
     * @ORM\Column(name="languages", type="text", nullable=true, unique=false)
     */
    protected $languages;

    /**
     * @var string
     *
     * @ORM\Column(name="neighbours", type="text", nullable=true, unique=false)
     */
    protected $neighbours;

    /**
     * @var string
     *
     * @ORM\Column(name="equivalent_fips", type="string", length=2, nullable=true, unique=false))
     */
    protected $equivalentFipsCode;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_sync", type="integer", unique=false)
     */
    protected $lastSync;

    /**
     * @ORM\ManyToOne(targetEntity="Continent", inversedBy="countries")
     */
    protected $continent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Country
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     * @return Country
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
        return $this;
    }

    /**
     * @return string
     */
    public function getIso3()
    {
        return $this->iso3;
    }

    /**
     * @param string $iso3
     * @return Country
     */
    public function setIso3($iso3)
    {
        $this->iso3 = $iso3;
        return $this;
    }

    /**
     * @return string
     */
    public function getIsoNumeric()
    {
        return $this->isoNumeric;
    }

    /**
     * @param string $isoNumeric
     * @return Country
     */
    public function setIsoNumeric($isoNumeric)
    {
        $this->isoNumeric = $isoNumeric;
        return $this;
    }

    /**
     * @return string
     */
    public function getFips()
    {
        return $this->fips;
    }

    /**
     * @param string $fips
     * @return Country
     */
    public function setFips($fips)
    {
        $this->fips = $fips;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return Country
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getCapital()
    {
        return $this->capital;
    }

    /**
     * @param string $capital
     * @return Country
     */
    public function setCapital($capital)
    {
        $this->capital = $capital;
        return $this;
    }

    /**
     * @return float
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param float $area
     * @return Country
     */
    public function setArea($area)
    {
        $this->area = $area;
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
     * @return Country
     */
    public function setPopulation($population)
    {
        $this->population = $population;
        return $this;
    }

    /**
     * @return string
     */
    public function getContinentCode()
    {
        return $this->continentCode;
    }

    /**
     * @param string $continentCode
     * @return Country
     */
    public function setContinentCode($continentCode)
    {
        $this->continentCode = $continentCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getTld()
    {
        return $this->tld;
    }

    /**
     * @param string $tld
     * @return Country
     */
    public function setTld($tld)
    {
        $this->tld = $tld;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyCode()
    {
        return $this->currencyCode;
    }

    /**
     * @param string $currencyCode
     * @return Country
     */
    public function setCurrencyCode($currencyCode)
    {
        $this->currencyCode = $currencyCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrencyName()
    {
        return $this->currencyName;
    }

    /**
     * @param string $currencyName
     * @return Country
     */
    public function setCurrencyName($currencyName)
    {
        $this->currencyName = $currencyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Country
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCodeFormat()
    {
        return $this->postalCodeFormat;
    }

    /**
     * @param string $postalCodeFormat
     * @return Country
     */
    public function setPostalCodeFormat($postalCodeFormat)
    {
        $this->postalCodeFormat = $postalCodeFormat;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCodeRegex()
    {
        return $this->postalCodeRegex;
    }

    /**
     * @param string $postalCodeRegex
     * @return Country
     */
    public function setPostalCodeRegex($postalCodeRegex)
    {
        $this->postalCodeRegex = $postalCodeRegex;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param string $languages
     * @return Country
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
        return $this;
    }

    /**
     * @return string
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }

    /**
     * @param string $neighbours
     * @return Country
     */
    public function setNeighbours($neighbours)
    {
        $this->neighbours = $neighbours;
        return $this;
    }

    /**
     * @return string
     */
    public function getEquivalentFipsCode()
    {
        return $this->equivalentFipsCode;
    }

    /**
     * @param string $equivalentFipsCode
     * @return Country
     */
    public function setEquivalentFipsCode($equivalentFipsCode)
    {
        $this->equivalentFipsCode = $equivalentFipsCode;
        return $this;
    }

    /**
     * @return int
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

    /**
     * @param int $lastSync
     * @return Country
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param mixed $continent
     * @return Country
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
        return $this;
    }
}

