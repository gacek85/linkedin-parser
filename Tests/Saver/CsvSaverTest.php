<?php
namespace Gacek85\LinkedInCrawler\Tests\Saver;

use Gacek85\LinkedInCrawler\Formatter\CsvLineFormatter;
use Gacek85\LinkedInCrawler\Output\DefaultOutput;
use Gacek85\LinkedInCrawler\Parser\LinkedInEntry;
use Gacek85\LinkedInCrawler\Saver\CsvSaver;
use Gacek85\LinkedInCrawler\Tests\LinkedInAwareTestcase;
use RuntimeException;

/**
 *  Test case for CSV saver
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CsvSaverTest extends LinkedInAwareTestcase 
{
    
    /**
     *
     * @var CsvSaver
     */
    protected $saver = null;
    
    
    protected function setUp()
    {
        $this->unlinkOutputFile();
        $this->saver = new CsvSaver($this->getOutputPath());
    }
    
    
    public function testCanHandle ()
    {
        $null_output = new DefaultOutput(null);
        $this->assertFalse($this->saver->canHandle($null_output));
        
        $empty_output = new DefaultOutput(array());
        $this->assertFalse($this->saver->canHandle($empty_output));
        
        list($valid_output) = $this->getValidData();
        
        $this->assertTrue($this->saver->canHandle($valid_output));
    }
    
    
    public function testHandle ()
    {
        list($valid_output, $raw_data) = $this->getValidData();
        $valid_data = $valid_output->getOutputData();
        /* @var $record LinkedInEntry */
        $record = $valid_data[0];
        $record_array = $record->toArray();
        $this
            ->saver
            ->handle($valid_output)
        ;
        
        $output_path = $this->getOutputPath();
        $this->assertFileExists($output_path);
        
        $this->validateHeaders($output_path, $record_array);
        $this->validateContent($output_path, $record_array);
    }
    
    
    protected function validateContent ($output_path, array $record_array)
    {
        $row = 0;
        if (($handle = fopen($output_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if ($row === 1) {
                    $this->doValidateContent($data, $record_array);
                }
                $row++;
            }
            fclose($handle);
        }
    }
    
    
    protected function doValidateContent (array $data, array $record_array)
    {
        $counter = 0;
        foreach ($record_array as $key => $value) {
            $this->assertEquals($this->normalize($value, $key), $data[$counter]);
            $counter++;
        }
    }
    
    
    protected function normalize ($value, $name) 
    {
        switch($name) {
            case 'name':
            case 'title':
            case 'first_name':
            case 'last_name':
            case 'summary':
            case 'location':
            case 'country':
            case 'industry':
            case 'picture':
                return $value;
            case 'skills':
                return implode(', ', $value);
            case 'past_companies':
            case 'current_companies':
            case 'organizations':
            case 'education':
            case 'websites':
            case 'groups':
            case 'languages':
            case 'certifications':
                $csv_line_formatter = new CsvLineFormatter();
                return $csv_line_formatter->formatArray($value);
        }
    }

    
    protected function validateHeaders ($output_path, array $record_array)
    {
        if (($handle = fopen($output_path, "r")) !== false) {
            $headers = fgetcsv($handle, 1000, ",");
            foreach ($headers as &$header) {
                $header = str_replace("\xEF\xBB\xBF", '', $header);
                $header = str_replace('"', '', $header);
            }
            fclose($handle);
            $this->doValidateHeaders($headers, $record_array);
        } else {
            throw new RuntimeException(sprintf(
                'Could not read file %s!',
                $output_path
            ));
        }
    }
    
    
    protected function doValidateHeaders (array $headers, array $record_array)
    {
        
        $keys = array_keys($record_array);
        $mapped_keys = array_map(function ($key) {
            $replaced = str_replace('_', ' ', $key);
            
            return strtoupper($replaced);
        }, $keys);
        $this->assertEquals($mapped_keys, $headers);
    }

    
    
    protected function getOutputPath ()
    {
        return sprintf(
            '%s/../Resources/LinkedIn/csv_output.csv', 
            __DIR__
        );
    }
    
    
    public function shutDown ()
    {
        $this->unlinkOutputFile();
    }
    
    protected function unlinkOutputFile()
    {
        $path = $this->getOutputPath();
        if (file_exists($path)) {
            unlink($path);
        }
    }
}