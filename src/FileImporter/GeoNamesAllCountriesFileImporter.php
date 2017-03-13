<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 11/03/17
 * Time: 0.17
 */

namespace GeoNames\FileImporter;


use Doctrine\ORM\EntityManagerInterface;
use GeoNames\Entity\City;
use GeoNames\FileReader\GeoNamesFileReader;
use GeoNames\Row\GeoNamesAllCountriesRow;
use GeoNames\Row\GeoNamesRowDataInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GeoNamesAllCountriesFileImporter extends AbstractGeoNamesFileImporter
{
    private $featureCode;
    private $featureClass;

    public function __construct(GeoNamesFileReader $fileReader, EntityManagerInterface $em, ?OutputInterface $output)
    {
        $this->featureCode = null;
        $this->featureClass = null;
        parent::__construct($fileReader, $em, $output);
    }

    /**
     * @return mixed
     */
    public function getFeatureCode()
    {
        return $this->featureCode;
    }

    /**
     * @param mixed $featureCode
     * @return GeoNamesAllCountriesFileImporter
     */
    public function setFeatureCode($featureCode): GeoNamesAllCountriesFileImporter
    {
        $this->featureCode = $featureCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeatureClass()
    {
        return $this->featureClass;
    }

    /**
     * @param mixed $featureClass
     * @return GeoNamesAllCountriesFileImporter
     */
    public function setFeatureClass($featureClass): GeoNamesAllCountriesFileImporter
    {
        $this->featureClass = $featureClass;
        return $this;
    }

    /**
     * @return string
     */
    protected function getRowObjectFQN(): string
    {
        return GeoNamesAllCountriesRow::class;
    }

    /**
     * @return string
     */
    protected function getEntityFQN(): string
    {
        return City::class;
    }

    /**
     * @param GeoNamesRowDataInterface $line
     * @return bool
     */
    protected function skipLine(GeoNamesRowDataInterface $line): bool
    {
        return ($this->featureCode !== null ? $line['featureCode'] !== $this->featureCode : false) ||
            ($this->featureClass !== null ? $line['featureClass'] !== $this->featureClass : false);
    }
}