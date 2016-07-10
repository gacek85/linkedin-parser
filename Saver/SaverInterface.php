<?php
namespace Gacek85\LinkedInCrawler\Saver;

use Gacek85\LinkedInCrawler\OutputInterface;

/**
 *  Saves the content from the output
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
interface SaverInterface {
    
    /**
     * Decides weather or not can save the output
     * 
     * @param       OutputInterface         $output
     * @return      bool
     */
    public function canHandle (OutputInterface $output);
    
    /**
     * Handles the output giving some response
     * 
     * @param       OutputInterface         $output
     * @return      mixed
     */
    public function handle (OutputInterface $output);
    
}