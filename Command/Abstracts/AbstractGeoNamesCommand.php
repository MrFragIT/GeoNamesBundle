<?php

namespace MrFragIT\GeoNamesBundle\Command\Abstracts;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractGeoNamesCmd
 * @package MrFragIT\GeoNamesBundle\Command
 */
abstract class AbstractGeoNamesCommand extends ContainerAwareCommand
{
    protected $syncTs;
    protected $dryRun = true;
    protected $input;
    protected $output;

    private $rowsParsed;
    private $rowsSkipped;

    public function __construct()
    {
        return parent::__construct();
    }

    /**
     * Returns the path to a downloaded GeoNames file
     * @return string
     */
    protected abstract function getGeoNamesFilePath();

    /**
     * Returns the FQN for the Row Template class
     * @return string
     */
    protected abstract function getRowTemplateClassFQN();

    /**
     * Returns the Entity FQN that will persist data
     * @return string
     */
    protected abstract function getEntityClassFQN();

    /**
     * @return mixed
     */
    public function getRowsParsed()
    {
        return $this->rowsParsed;
    }

    /**
     * @return mixed
     */
    public function getRowsSkipped()
    {
        return $this->rowsSkipped;
    }

    /**
     *
     */
    protected function setDefaultOptions()
    {
        $this->addOption('src', null,InputOption::VALUE_OPTIONAL, "Uncompressed GeoNames file to read data from",null);
        return $this;
    }

    /**
     * @return int
     */
    protected function getSyncTs()
    {
        return $this->syncTs;
    }

    protected function getFilePath(InputInterface $input)
    {
        $src = $input->getOption('src');
        if (!$src) {
            $src = $this->getGeoNamesFilePath();
        }

        if (! file_exists($src)) {
            throw new \Exception(sprintf("File %s not found", $src));
        }

        return $src;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $output->writeln(sprintf('<info>Starting import process...</info>'));

        $this
            ->parseFile($this->getFilePath($input), $output)
            ->deleteOldEntities($output);

        $output->writeln(sprintf('<info>Import completed</info>'));

        return 0;
    }

    /**
     * @param $filepath
     * @param OutputInterface $output
     * @return $this
     */
    protected function parseFile($filepath, OutputInterface $output)
    {
        $this->syncTs = time();
        $this->rowsParsed = $this->rowsSkipped = 0;

        $parser   = new GeoNamesFileParser($filepath, $this->getRowTemplateClassFQN());
        $progress = new ProgressBar($output, $parser->getTotalLines());
        $em       = $this->getEntityManager();
        $fqn      = $this->getEntityClassFQN();

        $progress->start();
        while ($item = $parser->parseLine()) {

            $this->rowsParsed++;

            if ($this->skipLine($item)) {
                $this->rowsSkipped++;
                continue;
            }

            $e = $em->getRepository($fqn)->findOneById($item->get('geonameId')) ?: (new \ReflectionClass($fqn))->newInstance();

            $this->parseLine($item, $e);

            if (!$this->isDryRun()) {
                $em->persist($e);
            }

            $progress->advance();
        }
        $progress->finish();
        $output->writeln('');
        $output->writeln(sprintf('Persisting entities to database...'));
        $em->flush();

        return $this;
    }

    /**
     * @param OutputInterface $output
     * @return $this
     */
    protected function deleteOldEntities(OutputInterface $output)
    {
        $em       = $this->getEntityManager();
        $fqn      = $this->getEntityClassFQN();

        $output->write(sprintf('<info>Deleting old entities...</info>'));

        // Deletes old entities
        $em->createQueryBuilder()
            ->delete($fqn, 'e')
            ->where('e.lastSync < :ts')
            ->setParameter('ts', $this->getSyncTs())
            ->getQuery()->getResult();

        return $this;
    }

    /**
     * @param $line
     * @return bool
     */
    protected function skipLine($line)
    {
        return false;
    }

    /**
     * @param $item
     * @param GeoNamesEntityInterface $entity
     */
    protected function parseLine($item, &$entity)
    {
        foreach($item as $K => $V) {
            switch($K) {
                case 'geonameId':
                    $entity->setId($V);
                    break;
                default:
                    (new \ReflectionMethod(get_class($entity), 'set' . ucfirst($K)))->invoke($entity, $V);
                    break;
            }
            $entity->setLastSync($this->getSyncTs());
        }
    }

    /**
     * @return EntityManagerInterface
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }
}