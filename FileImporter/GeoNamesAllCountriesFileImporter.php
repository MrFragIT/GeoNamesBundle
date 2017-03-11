<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 11/03/17
 * Time: 0.17
 */

namespace MrFragIT\GeoNamesBundle\FileImporter;


use Doctrine\ORM\EntityManagerInterface;
use MrFragIT\GeoNamesBundle\Entity\City;
use MrFragIT\GeoNamesBundle\FileReader\GeoNamesFileReader;
use MrFragIT\GeoNamesBundle\Row\GeoNamesAllCountriesRow;
use MrFragIT\GeoNamesBundle\Row\GeoNamesRowDataInterface;
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