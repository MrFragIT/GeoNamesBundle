<?php

namespace MrFragIT\GeoNamesBundle\FileImporter;


use Doctrine\ORM\EntityManagerInterface;
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

    protected $fileReader;
    protected $syncTs;
    protected $entityManager;
    protected $output;

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
    }

    /**
     *
     */
    protected function flushEntities(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @return $this
     */
    public function parse()
    {
        while ($rowStr = $this->fileReader->getRow()) {
            $line = (new \ReflectionClass($this->getRowObjectFQN()))->newInstance($rowStr);
            if ($this->skipLine($line)) continue;
            $entity = $this->parseLine($line, $this->getEntity($line));
            $this->persistEntity($entity);
        }
        $this->flushEntities();
        return $this;
    }

    /**
     * @return AbstractGeoNamesFileImporter
     */
    public function deleteOldEntities(): AbstractGeoNamesFileImporter
    {
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

    /**
     * @return int
     */
    private function getSyncTs(): int
    {
        if (!$this->syncTs) {
            $this->syncTs = time();
        }
        return $this->syncTs;
    }
}