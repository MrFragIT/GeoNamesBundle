<?php

namespace MrFragIT\GeoNamesBundle\Common;


use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WriteLnTrait
 * @package MrFragIT\GeoNamesBundle\Common
 */
class WriteLnTrait
{
    /**
     * @param $message
     */
    protected function writeln($message): void
    {
        if (isset($this->output) && $this->output instanceof OutputInterface) {
            $this->output->writeln($message);
        }
    }
}