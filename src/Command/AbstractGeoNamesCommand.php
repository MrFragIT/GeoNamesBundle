<?php

namespace GeoNames\Command;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractGeoNamesCmd
 * @package MrFragIT\GeoNamesBundle\Command
 */
abstract class AbstractGeoNamesCommand extends ContainerAwareCommand
{
    protected $input;
    protected $output;

    /**
     * AbstractGeoNamesCommand constructor.
     */
    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * @return AbstractGeoNamesCommand
     */
    protected function setDefaultOptions(): AbstractGeoNamesCommand
    {
        $this->addOption('src', null, InputOption::VALUE_OPTIONAL, "Uncompressed GeoNames file to read data from", null);
        return $this;
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->import();
    }

    /**
     * @return mixed
     */
    abstract protected function import();
}