<?php

namespace Gacek85\LinkedInCrawler;

use Gacek85\LinkedInCrawler\InputInterface;
use Gacek85\LinkedInCrawler\OutputInterface;
use InvalidArgumentException;

/**
 *  Describes an operation
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
interface OperationInterface 
{
    
    /**
     * Returns the unique key of the operation
     * 
     * @return      string
     */
    public function getKey ();
    
    
    /**
     * Decides if the operation can consume particular InputInterface
     * implementation
     * 
     * @param       InputInterface      $input
     * @return      bool
     */
    public function canConsume (InputInterface $input);
    
    
    /**
     * Executes the operation on given input producing output
     * 
     * @param       InputInterface      $input
     * @return      OutputInterface 
     * 
     * @throws      InvalidArgumentException       If an error occurs
     */
    public function execute (InputInterface $input);
    
}