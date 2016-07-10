<?php
namespace Gacek85\LinkedInCrawler\Operations;

use Gacek85\LinkedInCrawler\Input\CsvFileInput;
use Gacek85\LinkedInCrawler\InputInterface;
use Gacek85\LinkedInCrawler\OperationInterface;
use Gacek85\LinkedInCrawler\Output\DefaultOutput;
use Gacek85\LinkedInCrawler\OutputInterface;
use Gacek85\LinkedInCrawler\Parser\LinkedInDocumentParser;
use InvalidArgumentException;

/**
 *  Stores input urls in a temporary file for further
 *  processing and returns an output with that file path
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class DetailsOperation implements OperationInterface 
{

    const OPERATION_NAME = 'details';
    const TYPE_HTML_FILE = 'html_file';
    
    /**
     *
     * @var LinkedInDocumentParser
     */
    protected $parser = null;
    
    
    protected $inputs = array(
        CsvFileInput::TYPE_NAME,
        self::TYPE_HTML_FILE
    );
    
    
    public function __construct (LinkedInDocumentParser $parser)
    {
        $this->parser = $parser;
    }
    

    /**
     * Returns the unique key of the operation
     * 
     * @return      string
     */
    public function getKey ()
    {
        return self::OPERATION_NAME;
    }
    
    
    /**
     * Decides if the operation can consume particular InputInterface
     * implementation
     * 
     * @param       InputInterface      $input
     * @return      bool
     */
    public function canConsume (InputInterface $input)
    {
        $type = $input->getType();
        
        return in_array($type, $this->inputs);
    }
    
    
    /**
     * Executes the operation on given input producing output
     * 
     * @param       InputInterface      $input
     * @return      OutputInterface 
     * 
     * @throws      InvalidArgumentException       If an error occurs
     */
    public function execute (InputInterface $input)
    {
        // $data contains an array of urls or local file paths
        $data = $input->getData();
        $response = array();
        foreach ($data as $resource_address) {
            $html = @file_get_contents($resource_address);
            if (!$html) {
                throw new InvalidArgumentException(sprintf(
                    'Could not parse given file! %s',
                    $resource_address
                ));
            }
            $output = $this
                        ->parser
                        ->parse($html)
            ;
            $response[$resource_address] = $output; 
        }
        

        return new DefaultOutput($response);
    }
}