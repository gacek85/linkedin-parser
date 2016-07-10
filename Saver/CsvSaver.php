<?php
namespace Gacek85\LinkedInCrawler\Saver;

use Gacek85\LinkedInCrawler\Formatter\CsvLineFormatter;
use Gacek85\LinkedInCrawler\OutputInterface;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use RuntimeException;

/**
 *  Saves the data in CSV
 *
 *  @author Maciej Garycki <maciej@neverbland.com>
 *  @company Neverbland
 *  @copyrights Neverbland 2015
 */
class CsvSaver implements SaverInterface 
{
    
    protected $output_path = null;
    
    
    public function __construct ($output_path)
    {
        $this->output_path = $output_path;
    }
    
    
    /**
     * Decides weather or not can save the output
     * 
     * @param       OutputInterface         $output
     * @return      bool
     */
    public function canHandle (OutputInterface $output)
    {
        $data = $output->getOutputData();
        if (is_array($data) && count($data) && (reset($data) instanceof LinkedInEntry)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Handles the output giving some response
     * 
     * @param       OutputInterface         $output
     * @return      mixed
     */
    public function handle (OutputInterface $output)
    {
        /* @var $data LinkedInEntry[] */
        $data = $data = $output->getOutputData();
        $can_create = touch($this->output_path);
        if (!$can_create) {
            throw new RuntimeException(sprintf(
                'Could not open file %s for writing!',
                $this->output_path
            ));
        }
        
        $this->doHandle($this->output_path, $data);
        
        return $this->output_path;
    }
    
    
    /**
     * 
     * @param       LinkedInEntry[]     $entries
     */
    protected function doHandle ($output_path, $entries)
    {
        $counter = 0;
        file_put_contents($output_path, "\xEF\xBB\xBF", FILE_APPEND); // That shit fixes UTF8 encoding! WTF?!?!
        foreach ($entries as $entry) {
            $formatter = new CsvLineFormatter();
            $line = $formatter->formatLine($entry, $counter);
            $this->storeLine($output_path, $line);
            $counter++;
        } 
    }
    
    
    protected function storeLine ($output_path, $line)
    {
        file_put_contents(
            $output_path, 
            sprintf("%s\n", $line), 
            FILE_APPEND
        );
    }
}