<?php
namespace Gacek85\LinkedInCrawler;

/**
 *  Defines the input
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
interface InputInterface 
{
    
    /**
     * Provides input data
     * 
     * @return      mixed
     */
    public function getData ();
    
    
    /**
     * Returns the data type name
     * 
     * @return      string
     */
    public function getType ();
}