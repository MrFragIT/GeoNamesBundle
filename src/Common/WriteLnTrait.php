<?php

namespace GeoNames\Common;


use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WriteLnTrait
 * @package GeoNames\Common
 */
trait WriteLnTrait
{
    /**
     * @param $message
     */
    public function writeln($message = "\r\n"): void
    {
        if (isset($this->output) && $this->output instanceof OutputInterface) {
            $this->output->writeln($message);
        }
    }
}