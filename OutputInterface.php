<?php
namespace Gacek85\LinkedInCrawler;

/**
 *  Defines the output of the scraping
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
interface OutputInterface 
{
    /**
     * Provides operation output data
     * 
     * @return mixed
     */
    public function getOutputData ();
}