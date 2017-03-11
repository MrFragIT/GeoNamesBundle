<?php

namespace MrFragIT\GeoNamesBundle\FileImporter;


use Doctrine\ORM\EntityManagerInterface;
use MrFragIT\GeoNamesBundle\Common\ProgressBarTrait;
use MrFragIT\GeoNamesBundle\Common\WriteLnTrait;
use MrFragIT\GeoNamesBundle\Entity\GeoNamesEntityInterface;
use MrFragIT\GeoNamesBundle\FileReader\GeoNamesFileReader;
use MrFragIT\GeoNamesBundle\Row\GeoNamesRowDataInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractGeoNamesFileImporter
 * @package MrFragIT\GeoNamesBundle\FileImporter
 */
abstract class AbstractGeoNamesFileImporter
{
    use WriteLnTrait;
    use ProgressBarTrait;

    const FLUSH_THRESHOLD = 1000;

    protected $fileReader;
    protected $syncTs;
    protected $entityManager;
    protected $output;
    protected $skippedRowsCounter;

    private $waitingForFlush;

    /**
     * AbstractGeoNamesFileImporter constructor.
     * @param GeoNamesFileReader $fileReader
     * @param EntityManagerInterface $em
     * @param null|OutputInterface $output
     */
    public function __construct(GeoNamesFileReader $fileReader, EntityManagerInterface $em, ?OutputInterface $output)
    {
        $this->fileReader = $fileReader;
        $this->entityManager = $em;
        $this->output = $output;
        return $this;
    }

    /**
     * @return string
     */
    abstract protected function getRowObjectFQN(): string;

    /**
     * @return string
     */
    abstract protected function getEntityFQN(): string;

    /**
     * @param int $ts
     * @return AbstractGeoNamesFileImporter
     */
    public function setSyncTs(int $ts): AbstractGeoNamesFileImporter
    {
        $this->syncTs = $ts;
        return $this;
    }

    /**
     * @return int
     */
    public function getSyncTs(): int
    {
        if (!$this->syncTs) {
            $this->syncTs = time();
        }
        return $this->syncTs;
    }

    /**
     * @return AbstractGeoNamesFileImporter
     */
    public function parse(): AbstractGeoNamesFileImporter
    {
        $this->setBar($this->fileReader->getTotalRows());
        $this->skippedRowsCounter = 0;
        $this->waitingForFlush = 0;
        while ($rowStr = $this->fileReader->getRow()) {
            $this->advanceBar();

            $line = (new \ReflectionClass($this->getRowObjectFQN()))->newInstance($rowStr);
            if ($this->skipLine($line)) {
                $this->skippedRowsCounter++;
                continue;
            }
            $entity = $this->parseLine($line, $this->getEntity($line));
            $this->persistEntity($entity);

            if ($this->waitingForFlush >= self::FLUSH_THRESHOLD) {
                $this->flushEntities();
            }
        }
        $this->flushEntities();
        $this->finishBar();
        $this->writeln();

        if ($this->skippedRowsCounter) {
            $this->writeln(sprintf("<info>%d rows have been skipped</info>", $this->skippedRowsCounter));
        }

        return $this;
    }

    /**
     * @return AbstractGeoNamesFileImporter
     */
    public function deleteOldEntities(): AbstractGeoNamesFileImporter
    {
        $this->writeln('Deleting old entities');
        $this->entityManager
            ->createQueryBuilder()
            ->delete($this->getEntityFQN(), 'e')
            ->where('e.lastSync < :ts')
            ->setParameter('ts', $this->getSyncTs())
            ->getQuery()->getResult();
        return $this;
    }

    /**
     * @param GeoNamesRowDataInterface $line
     * @return GeoNamesEntityInterface
     */
    protected function getEntity(GeoNamesRowDataInterface $line): GeoNamesEntityInterface
    {
        return $this->entityManager
            ->getRepository($this->getEntityFQN())
            ->findOneById($line->get('geonameId'))
            ?: (new \ReflectionClass($this->getEntityFQN()))->newInstance();
    }

    /**
     * @param GeoNamesEntityInterface $entity
     */
    protected function persistEntity(GeoNamesEntityInterface $entity): void
    {
        $this->entityManager->persist($entity);
        $this->waitingForFlush++;
    }

    /**
     *
     */
    protected function flushEntities(): void
    {
        $this->entityManager->flush();
        $this->waitingForFlush = 0;
    }

    /**
     * @param GeoNamesRowDataInterface $line
     * @return bool
     */
    protected function skipLine(GeoNamesRowDataInterface $line): bool
    {
        return false;
    }

    /**
     * @param GeoNamesRowDataInterface $line
     * @param GeoNamesEntityInterface $entity
     * @return GeoNamesEntityInterface
     */
    protected function parseLine(GeoNamesRowDataInterface $line, GeoNamesEntityInterface $entity): GeoNamesEntityInterface
    {
        foreach ($line as $K => $V) {
            if ($K === 'geonameId') {
                $entity->setId($V);
            } else {
                (new \ReflectionMethod(get_class($entity), 'set' . ucfirst($K)))->invoke($entity, $V);
            }
            $entity->setLastSync($this->getSyncTs());
        }
        return $entity;
    }
}