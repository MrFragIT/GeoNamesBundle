<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 23/02/17
 * Time: 23.50
 */

namespace GeoNames\Command;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Class GeoNamesFileParser
 *
 * This class is in charge of downloading a file from geonames into a tempfile
 * then, by calling parse() the temfile will be ridden and persisted into DB
 *
 * @package MrFragIT\GeoNamesBundle\Command
 */
class GeoNamesFileParser
{
    private $input;
    private $output;

    private $rowsParsed;
    private $rowsSkipped;
    private $syncTs;

    /**
     * GeoNamesFileParser constructor.
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        $this->tempFile = null;
        $this->rowsParsed = 0;
        $this->rowsSkipped = 0;
        $this->syncTs = 0;
    }


    public function parse()
    {
        $this->syncTs = time();
        $this->rowsParsed = 0;
        $this->rowsSkipped = 0;

        $progress = new ProgressBar($this->output, $parser->getTotalLines());
        $em = $this->getEntityManager();
        $fqn = $this->getEntityClassFQN();

        $progress->start();
        while ($item = $parser->parseLine()) {
            $this->rowsParsed++;
            if ($this->skipLine($item)) {
                $this->rowsSkipped++;
                continue;
            }
            $e = $em->getRepository($fqn)->findOneById($item->get('geonameId')) ?: (new \ReflectionClass($fqn))->newInstance();
            $this->parseLine($item, $e);
            $em->persist($e);
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('');
        $output->writeln(sprintf('Persisting entities...'));
        $em->flush();

        return $this;
    }


}