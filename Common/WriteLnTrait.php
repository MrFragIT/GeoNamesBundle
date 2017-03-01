<?php

namespace MrFragIT\GeoNamesBundle\Common;


use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WriteLnTrait
 * @package MrFragIT\GeoNamesBundle\Common
 */
trait WriteLnTrait
{
    /**
     * @param $message
     */
    public function writeln($message): void
    {
        if (isset($this->output) && $this->output instanceof OutputInterface) {
            $this->output->writeln($message);
        }
    }
}