<?php
namespace Gacek85\LinkedInCrawler\Input;

use Gacek85\LinkedInCrawler\FormatterInterface;
use Gacek85\LinkedInCrawler\InputInterface;
use InvalidArgumentException;
use RuntimeException;

/**
 *  CSV input implementation for InputInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CsvFileInput implements InputInterface 
{

    const TYPE_NAME = "csv_file";
    
    
    protected $csv_file_path = null;
    
    
    /**
     *
     * @var FormatterInterface 
     */
    protected $formatter = null;
    
    
    /**
     * Constructs the Csv file input
     * 
     * @param       string                      $csv_file_path
     * 
     * @param       FormatterInterface          Optional formatter
     * @throws      InvalidArgumentException   If invalid formatter is set
     */
    public function __construct ($csv_file_path, FormatterInterface $formatter = null)
    {
        $this->csv_file_path = $csv_file_path;
        $this->formatter = $formatter ? $this->validateFormatter($formatter) : null;
    }
    
    
    protected function validateFormatter (FormatterInterface $formatter)
    {
        if ($formatter->isInputCompatible($this)) {
            return $formatter;
        } else {
            throw new InvalidArgumentException(sprintf(
                'The formatter of class %s is not compatible to work with!',
                get_class($formatter)
            ));
        }
    }



    /**
     * Provides input data
     * 
     * @return      array               Returns an array of CSV fields
     * @throws      RuntimeException   If the CSV file cannot be opened
     */
    public function getData ()
    {
        $handle = fopen($this->csv_file_path, 'r');
        if ($handle === false) {
            throw new RuntimeException(sprintf(
                'Cannot open file `%s` for reading!',
                $this->csv_file_path
            ));
        }
        
        $raw_data = $this->doGetData($handle);
        
        if ($this->formatter !== null) {
            return $this->formatter->format($raw_data);
        } else {
            return $raw_data;
        }
    }
    
    
    protected function doGetData ($file_handle)
    {
        $results = array();
        while (($data = fgetcsv($file_handle, 1000, ",")) !== FALSE)  {
            $results[] = $this->clearRow($data);
        }
        
        return $results;
    }
    
    
    protected function clearRow (array $row)
    {
        $results = array();
        foreach ($row as $field) {
            $trimed = trim($field, " \t\n\r\0\x0B\"");
            $results[] = $trimed;
        }
        
        return $results;        
    }
    
    
    /**
     * Returns the data type name
     * 
     * @return      string
     */
    public function getType ()
    {
        return self::TYPE_NAME;
    }
}