<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 15/12/16
 * Time: 23.17
 */

namespace MrFragIT\GeoNamesBundle\Command;


use Doctrine\Common\Collections\ArrayCollection;
use MrFragIT\GeoNamesBundle\Entity\City;
use MrFragIT\GeoNamesBundle\Parser\Template\CityRowTemplate;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GeoNamesSyncCitiesCommand extends AbstractGeoNamesCommand
{
    use GeoNamesZipDownload;

    const BASE_GEONAMES_URL = 'http://download.geonames.org/export/dump/';
    const CITIES_1000_FILE  = 'cities1000.zip';
    const CITIES_5000_FILE  = 'cities5000.zip';
    const CITIES_15000_FILE = 'cities15000.zip';
    const ALL_COUNTRIES     = 'allCountries.zip';
    const DEFAULT_SUBSET    = 'allCountries';

    private $downloadList;

    public function __construct()
    {
        $this->downloadList = new ArrayCollection();
        return parent::__construct();
    }


    protected function getGeoNamesFilePath()
    {

    }

    protected function getRowTemplateClassFQN()
    {
        return CityRowTemplate::class;
    }

    protected function getEntityClassFQN()
    {
        return City::class;
    }

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input    =   $input;
        $this->output   =   $output;

        if ($input->getOption('subset'))        $this->addSubset();
        if ($input->getOption('continents'))    $this->addContinents();
        if ($input->getOption('countries'))     $this->addCountries();
        if (!$this->downloadList->count())      $this->addSubset(self::DEFAULT_SUBSET);

        return parent::execute($input, $output);
    }

    protected function addContinents()
    {
        $continents = explode(',', strtoupper($this->input->getOption('continents')));
        foreach($continents as $continent) {
            $countries = $this->getContainer()->get('doctrine')->getManager()->getRepository('GeoNamesBundle:Country')->findByContinentCode($continent);
            if (! $countries) {
                throw new Exception(sprintf("Unable to find any country in continent %s, did you forget to import them?", $continent));
            }
            array_map(function($item){
                $this->addCountry($item->iso);
            }, $countries);
        }
    }

    protected function addCountries()
    {
        $countries = explode(',', strtoupper($this->input->getOption('countries')));
        foreach($countries as $country) {
            $this->addCountry($country);
        }
    }

    protected function addSubset($sub = null)
    {
        $sub = $sub ?: $this->input->getOption('subset');

        if ($this->downloadList->count()) {
            throw new Exception("You can't import a subsets together with continents or countries");
        }

        switch($sub) {
            case 'cities1000':
                $this->downloadList->add([self::BASE_GEONAMES_URL . self::CITIES_1000_FILE, 'cities1000.txt']);
                break;
            case 'cities5000':
                $this->downloadList->add([self::BASE_GEONAMES_URL . self::CITIES_5000_FILE, 'cities5000.txt']);
                break;
            case 'cities15000':
                $this->downloadList->add([self::BASE_GEONAMES_URL . self::CITIES_15000_FILE, 'cities15000.txt']);
                break;
            case 'allCountries':
                $this->downloadList->add([self::BASE_GEONAMES_URL . self::ALL_COUNTRIES, 'allCountries.txt']);
                break;
            default:
                throw new Exception("Invalid subset");
        }
    }

    protected function addCountry($ccode)
    {
        if (!$this->downloadList->containsKey($ccode))
            $this->downloadList->add([$ccode => [self::BASE_GEONAMES_URL . $ccode . '.zip', $ccode.'.txt']]);
    }
}