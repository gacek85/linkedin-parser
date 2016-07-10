<?php
namespace Gacek85\LinkedInCrawler\Output;

use Gacek85\LinkedInCrawler\OutputInterface;

/**
 *  Default output data OutputInterface implementation, will take any single data
 *  object as constructor param and return it with getOutputData method
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class DefaultOutput implements OutputInterface 
{
    
    /**
     *
     * @var         mixed
     */
    protected $data = null;
    
    
    /**
     * Constructs the object with any data
     * 
     * @param       mixed       $data
     */
    public function __construct ($data)
    {
        $this->data = $data;
    }
    
    /**
     * Provides operation output data
     * 
     * @return      mixed
     */
    public function getOutputData ()
    {
        return $this->data;
    }
}