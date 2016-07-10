<?php
namespace Gacek85\LinkedInCrawler\Input;

use Gacek85\LinkedInCrawler\InputInterface;
use RuntimeException;

/**
 *  HTML file input implementation for InputInterface
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class HtmlFileInput implements InputInterface 
{

    const TYPE_NAME = "html_file";
    
    
    protected $file_path = null;
    
    
    
    /**
     * Constructs the HTML file input
     * 
     * @param       string                      $file_path
     */
    public function __construct ($file_path)
    {
        $this->file_path = $file_path;
    }
    

    /**
     * Provides input data
     * 
     * @return      array               Returns an array of containing the file path
     * @throws      RuntimeException    If the file cannot be opened
     */
    public function getData ()
    {
        if (!is_file($this->file_path) || !fopen($this->file_path, 'r')) {
            throw new RuntimeException(sprintf(
                'Cannot open file `%s` for reading!',
                $this->file_path
            ));
        }
        
        return array(
            $this->file_path
        );
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