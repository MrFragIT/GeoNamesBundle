<?php

namespace MrFragIT\GeoNamesBundle\Command;
use MrFragIT\GeoNamesBundle\Entity\Continent;
use MrFragIT\GeoNamesBundle\Entity\Country;
use MrFragIT\GeoNamesBundle\Parser\Template\CountryRowTemplate;

/**
 * Class GeoNamesSyncCountriesCommand
 * @package MrFragIT\GeoNamesBundle\Command
 */
class GeoNamesSyncCountriesCommand extends AbstractGeoNamesCommand
{
    use GeoNamesTxtDownload;

    const SOURCE_URL    = 'http://download.geonames.org/export/dump/countryInfo.txt';

    private $tempFile;

    /**
     * GeoNamesSyncCountriesCommand constructor.
     */
    function __construct()
    {
        $this->tempFile = sys_get_temp_dir() . '/geonames_countries.zip';
        return parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('geonames:sync:countries')
            ->setDescription('Imports countries table from GeoNames')
            ->setDefaultOptions()
        ;
    }

    /**
     * @param $item
     * @param GeoNamesEntityInterface $entity
     */
    protected function parseLine($item, &$entity)
    {
        $em       = $this->getEntityManager();
        $continent= $em->getRepository(Continent::class)->findOneByCode(strtoupper($item->get('continentCode')));

        if ($continent) {
            $entity->setContinent($continent);
        }

        return parent::parseLine($item, $entity);
    }


    /**
     * @return string
     */
    protected function getGeoNamesFilePath()
    {
        if ($this->downloadFromGeoNames(self::SOURCE_URL, $this->tempFile)) {
            return $this->tempFile;
        }
        $this->output->writeln(sprintf("<error>Aborting</error>"));
        exit();
    }

    /**
     * @return string
     */
    protected function getRowTemplateClassFQN()
    {
        return CountryRowTemplate::class;
    }

    /**
     * @return string
     */
    protected function getEntityClassFQN()
    {
        return Country::class;
    }

    /**
     *  Deletes temprary file
     */
    protected function cleanup()
    {
        @unlink($this->tempFile);
        return parent::cleanup();
    }
}
