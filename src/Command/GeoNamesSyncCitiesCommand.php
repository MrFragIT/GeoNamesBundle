<?php

namespace GeoNames\Command;


use Doctrine\Common\Collections\ArrayCollection;
use GeoNames\Common\ProgressBarTrait;
use GeoNames\Common\WriteLnTrait;
use GeoNames\FileImporter\GeoNamesAllCountriesFileImporter;
use GeoNames\FileReader\GeoNamesFileReader;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputOption;

class GeoNamesSyncCitiesCommand extends AbstractGeoNamesCommand
{
    use WriteLnTrait;
    use ProgressBarTrait;

    const BASE_GEONAMES_URL = 'http://download.geonames.org/export/dump/';
    const CITIES_1000_FILE  = 'cities1000.zip';
    const CITIES_5000_FILE  = 'cities5000.zip';
    const CITIES_15000_FILE = 'cities15000.zip';
    const ALL_COUNTRIES     = 'allCountries.zip';
    const DEFAULT_SUBSET    = 'allCountries';
    const FEATURE_CLASS = 'P';

    private $downloadList;

    /**
     * GeoNamesSyncCitiesCommand constructor.
     */
    public function __construct()
    {
        $this->downloadList = new ArrayCollection();
        return parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('geonames:sync:cities')
            ->setDescription('Imports cities from Geonames')
            ->addOption('continents',null, InputOption::VALUE_OPTIONAL, "Comma separated list of continent codes. You must import all the countries before using this option.",null)
            ->addOption('countries',null, InputOption::VALUE_OPTIONAL, "Comma separated list of country iso(2) codes.",null)
            ->addOption('subset',null, InputOption::VALUE_OPTIONAL, "One of cities1000, cities5000, cities 15000",null)
            ->setDefaultOptions()
        ;
    }

    /**
     *
     */
    protected function import()
    {
        $this->output->writeln("\r\n<info>Importing countries</info>\r\n");

        // Populate download list
        if ($this->input->getOption('subset')) $this->addSubset();
        if ($this->input->getOption('continents')) $this->addContinents();
        if ($this->input->getOption('countries')) $this->addCountries();
        if (!$this->downloadList->count()) $this->addSubset(self::DEFAULT_SUBSET);

        $this->writeln(sprintf("\r\n<comment>Download list contains %d items</comment>\r\n", $this->downloadList->count()));

        $syncTs = time();
        $importer = null;

        // Parse every single item in the list
        while ($url = $this->downloadList->current()) {
            $importer = (new GeoNamesAllCountriesFileImporter(
                new GeoNamesFileReader($url, $this->output),
                $this->getEntityManager(),
                $this->output
            ))->setFeatureClass(self::FEATURE_CLASS)
                ->setSyncTs($syncTs)
                ->parse();

            $this->downloadList->next();
        }

        // If many files have been imported, entities will be deleted with the same logic
        if ($importer instanceof GeoNamesAllCountriesFileImporter) {
            $importer->deleteOldEntities();
        }
    }

    /**
     *
     */
    protected function addContinents(): void
    {
        $continents = explode(',', strtoupper($this->input->getOption('continents')));
        foreach($continents as $continent) {
            $countries = $this->getContainer()->get('doctrine')->getManager()->getRepository('GeoNamesBundle:Country')->findByContinentCode($continent);
            if (! $countries) {
                throw new Exception(sprintf("Unable to find any country in continent %s, did you forget to import them?", $continent));
            }
            array_map(function($item){
                $this->addCountry($item->getIso());
            }, $countries);
        }
    }

    /**
     *
     */
    protected function addCountries(): void
    {
        $countries = explode(',', strtoupper($this->input->getOption('countries')));
        foreach($countries as $country) {
            $this->addCountry($country);
        }
    }

    /**
     * @param null $sub
     */
    protected function addSubset($sub = null): void
    {
        $sub = $sub ?: $this->input->getOption('subset');

        if ($this->downloadList->count()) {
            throw new Exception("You can't import a subsets together with continents or countries");
        }

        switch($sub) {
            case 'cities1000':
                $this->downloadList->add(self::BASE_GEONAMES_URL . self::CITIES_1000_FILE);
                break;
            case 'cities5000':
                $this->downloadList->add(self::BASE_GEONAMES_URL . self::CITIES_5000_FILE);
                break;
            case 'cities15000':
                $this->downloadList->add(self::BASE_GEONAMES_URL . self::CITIES_15000_FILE);
                break;
            case 'allCountries':
                $this->downloadList->add(self::BASE_GEONAMES_URL . self::ALL_COUNTRIES);
                break;
            default:
                throw new Exception("Invalid subset");
        }
    }

    /**
     * @param $ccode
     */
    protected function addCountry($ccode): void
    {
        if (!$this->downloadList->containsKey($ccode))
            $this->downloadList->add(self::BASE_GEONAMES_URL . $ccode . '.zip');
    }
}