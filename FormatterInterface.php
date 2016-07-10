<?php
namespace Gacek85\LinkedInCrawler;

use Gacek85\LinkedInCrawler\InputInterface;
use Gacek85\LinkedInCrawler\OperationInterface;
use InvalidArgumentException;

/**
 *  Defines formatter interface 
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
interface  FormatterInterface 
{
    
    /**
     * Formats input data to proper output
     * 
     * @param       mixed                       $data
     * @return      mixed
     * @throws      InvalidArgumentException   If cannot process data
     */
    public function format ($data);
    
    
    /**
     * Checks if can work with given input
     * 
     * @param       InputInterface      $input
     * @return      bool
     */
    public function isInputCompatible (InputInterface $input);
    
    
    /**
     * Checks if can work with given operation
     * 
     * @param       OperationInterface      $operation
     * @return      bool
     */
    public function isOperationCompatible (OperationInterface $operation);
    
}