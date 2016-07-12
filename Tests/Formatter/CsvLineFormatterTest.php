<?php
namespace Gacek85\LinkedInCrawler\Tests\Formatter;

use Gacek85\LinkedInCrawler\Formatter\CsvLineFormatter;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use Gacek85\LinkedInCrawler\Tests\LinkedInAwareTestcase;

/**
 *  Tesc case for CsvLineFormatter
 *
 *  @author Maciej Garycki <maciej@neverbland.com>
 *  @company Neverbland
 *  @copyrights Neverbland 2015
 */
class CsvLineFormatterTest extends LinkedInAwareTestcase 
{
    
    /**
     *
     * @var CsvLineFormatter
     */
    protected $formatter = null;
    
    
    protected function setUp()
    {
        $this->formatter = new CsvLineFormatter();
    }
    
    
    public function testFormatArray ()
    {
        $inputs = array(
            array(
                'given' => array('word1', 'word2', '3word'),
                'expected' => 'word1, word2, 3word'
            ),
            array(
                'given' => array(
                    array(
                        'name1' => 'value1',
                        'name2' => 'value2'
                    ),
                    array(
                        'name1' => 'value3',
                        'name2' => 'value4'
                    )
                ),
                'expected' => "name1: value1; name2: value2\n\rname1: value3; name2: value4"
            ),
        );
        
        foreach ($inputs as $input) {
            $given = $input['given'];
            $expected = $input['expected'];
            
            $this->assertEquals($expected, $this->formatter->formatArray($given));
        }
    }
    
    
    /**
     * @depends testFormatArray
     */
    public function testFormatLine ()
    {
        /* @var $entry LinkedInEntry */
        list($output, $raw, $entry) = $this->getValidData();
        
        $output_with_headers = $this
                                    ->formatter
                                    ->formatLine($entry, true)
        ;
        $rows = explode("\n\r", $output_with_headers);
        $this->assertCount(2, $rows);
        
        $this->validateHeaders($rows[0], $entry);
        
        $output_without_headers = $this
                                    ->formatter
                                    ->formatLine($entry, false)
        ;
        
        $rows2 = explode("\n\r", $output_without_headers);
        $this->assertCount(1, $rows2);
        
        $this->assertEquals($rows[1], $output_without_headers);
    }
    
    
    protected function validateHeaders ($row, LinkedInEntry $entry)
    {
        $headers = explode('","', $row);
        $headers[0] = str_replace('"', '', $headers[0]);
        $headers[count($headers) - 1] = str_replace('"', '', $headers[count($headers) - 1]);
        $values = $entry->toArray();
        $keys = array_keys($values);
        
        $mapped_keys = array_map(function ($key) {
            $replaced = str_replace('_', ' ', $key);
            
            return strtoupper($replaced);
        }, $keys);
        $this->assertEquals($mapped_keys, $headers);
    }
}