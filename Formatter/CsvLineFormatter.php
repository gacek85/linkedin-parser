<?php
namespace Gacek85\LinkedInCrawler\Formatter;

use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;

/**
 *  Formats LinkedInEntry to csv line
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CsvLineFormatter
{
    
    /**
     * Formats entry into a single line of csv
     * 
     * @param       LinkedInEntry       $entry
     * @param       int                 $add_headers
     */
    public function formatLine (LinkedInEntry $entry, $add_headers)
    {
        $results = array();
        if ($add_headers) {
            $results[] = $this->getHeaders($entry);
        }
        $results[] = $this->formatEntry($entry);
        
        return implode("\n\r", $results);
    }
    
    
    protected function getHeaders (LinkedInEntry $entry)
    {
        $keys = array_keys($entry->toArray());
        $results = array();
        foreach ($keys as $key) {
            $results[] = $this->fixKey($key);
        }
        
        return $this->formatRow($results);
    }
    
    
    protected function fixKey ($key)
    {
        $replaced = str_replace('_', ' ', $key);
        
        return strtoupper($replaced);
    }
    
    
    protected function formatEntry (LinkedInEntry $entry)
    {
        $results = array();
        foreach ($entry->toArray() as $value) {
            if (!is_array($value)) {
                $results[] = $value;
            } else {
                $results[] = $this->formatArray($value);
            }
        }
        
        return $this->formatRow($results);
    }
    
    
    protected function formatRow (array $results)
    {
        return sprintf('"%s"', implode('","', $results));
    }
    
    
    /**
     * Formats given array tocombined string value
     * 
     * @param       array       $array_value
     * @return      string
     */
    public function formatArray (array $array_value)
    {
        $results = array();
        $is_single = false;
        foreach ($array_value as $value) {
            $results[] = $this->formatValue($value, $is_single);
        }
        
        return $is_single ? implode(", ", $results) : implode("\n\r", $results);
    }
    
    
    protected function formatValue ($value, &$is_single)
    {
        if (is_scalar($value)) {
            $is_single = true;
            return $value;
        } else {
            $is_single = false;
            return $this->formatValueArray($value);
        }
    }
    
    
    protected function formatValueArray (array $value)
    {
        $single_results = array();
        foreach ($value as $name => $skill_value) {
            if (!$value OR !$name) {
                continue;
            }
            $single_results[] = sprintf('%s: %s', $name, $skill_value);
        }
        
        return implode("; ", $single_results);
    }
}