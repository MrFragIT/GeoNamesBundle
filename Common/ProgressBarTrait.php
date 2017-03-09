<?php
/**
 * Created by PhpStorm.
 * User: frag
 * Date: 09/03/17
 * Time: 23.16
 */

namespace MrFragIT\GeoNamesBundle\Common;


use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

trait ProgressBarTrait
{
    private $progressBar;

    /**
     * @return null|ProgressBar
     */
    public function getBar(): ?ProgressBar
    {
        return $this->progressBar;
    }

    /**
     * @param int $steps
     */
    public function setBar(int $steps): void
    {
        $this->progressBar = null;
        if (isset($this->output) && $this->output instanceof OutputInterface) {
            $this->progressBar = new ProgressBar($this->output, $steps);
        }
    }

    /**
     * @param int $steps
     */
    public function advanceBar(int $steps = 1): void
    {
        if ($this->progressBar instanceof ProgressBar)
            $this->progressBar->advance($steps);
    }

    /**
     *
     */
    public function finishBar(): void
    {
        if ($this->progressBar instanceof ProgressBar)
            $this->progressBar->finish();
    }
}