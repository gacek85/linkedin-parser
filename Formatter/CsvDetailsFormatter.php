<?php
namespace Gacek85\LinkedInCrawler\Formatter;

use Gacek85\LinkedInCrawler\FormatterInterface;
use Gacek85\LinkedInCrawler\Input\CsvFileInput;
use Gacek85\LinkedInCrawler\InputInterface;
use Gacek85\LinkedInCrawler\OperationInterface;
use Gacek85\LinkedInCrawler\Operations\DetailsOperation;
use InvalidArgumentException;

/**
 *  Formsts the CSV data to get LinkedIn details urls
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CsvDetailsFormatter implements FormatterInterface
{
    
    /**
     * Formats input data to proper output
     * 
     * @param       mixed                       $data
     * @return      array                       An array of LinkedIn urls
     * @throws      InvalidArgumentException   If cannot process data
     */
    public function format ($data)
    {
        $results = array();
        foreach ($data as $row) {
            $row_results = $this->getRowResults($row);
            $results = array_merge($results, $row_results);
        }
        
        return array_unique($results);
    }
    
    
    protected function getRowResults (array $row)
    {
        $results = array();
        foreach ($row as $field) {
            $clean = trim($field);
            if ($this->fieldMatchesUrl($clean)) {
                $results[] = $clean;
            }
        }
        
        return $results;
    }
    
    
    protected function fieldMatchesUrl ($url)
    {
        $regexp = "/^((https|http):\/\/)?(www.)?(linkedin.com).*$/i";
        return preg_match($regexp, $url);
    }
    
    
    /**
     * Checks if can work with given input
     * 
     * @param       InputInterface      $input
     * @return      bool
     */
    public function isInputCompatible (InputInterface $input)
    {
        return ($input instanceof CsvFileInput);
    }
    
    
    /**
     * Checks if can work with given operation
     * 
     * @param       OperationInterface      $operation
     * @return      bool
     */
    public function isOperationCompatible (OperationInterface $operation)
    {
        return ($operation instanceof DetailsOperation);
    }
}