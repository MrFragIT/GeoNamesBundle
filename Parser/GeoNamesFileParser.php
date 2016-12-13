<?php

namespace MrFragIT\GeoNamesBundle\Parser;

/**
 * Class GeoNamesFileParser
 * @package MrFragIT\GeoNamesBundle\Parser
 */
class GeoNamesFileParser
{
    private $fileHandler;
    private $lineTemplateFQN;

    private $parsedLines     = 0;
    private $totalLines;

    public function __construct($filename, $lineTemplateFQN)
    {
        $this->totalLines = $this->countFileRows($filename);
        $this->fileHandler = fopen($filename, "r");
        $this->lineTemplateFQN = $lineTemplateFQN;
    }

    /**
     * @param $file
     * @return int
     */
    private function countFileRows($file)
    {
        return intval(exec("wc -l '$file'"));
    }

    /**
     * @return int
     */
    public function getParsedLines()
    {
        return $this->parsedLines;
    }

    /**
     * @return null|object
     */
    public function parseLine()
    {
        $line = fgets($this->fileHandler);

        if (!$line)
            return null;

        // Update stats
        $this->parsedLines++;

        return (new \ReflectionClass($this->lineTemplateFQN))->newInstance($line);
    }

    /**
     * @return int
     */
    public function getTotalLines()
    {
        return $this->totalLines;
    }
}