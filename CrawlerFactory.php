<?php
namespace Gacek85\LinkedInCrawler;

use Gacek85\LinkedInCrawler\Crawler;
use Gacek85\LinkedInCrawler\Operations\DetailsOperation;
use Gacek85\LinkedInCrawler\Parser\LinkedInDocumentParser;

/**
 *  Produces and keeps the crawler single instance
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CrawlerFactory 
{
    /**
     *
     * @var         Crawler
     */
    protected static $crawler = null;
    
    
    /**
     * If exists, returns stored Scraper instance, otherwise, creates, stores and
     * returns it
     * 
     * @return      Crawler
     */
    public static function getCrawler ()
    {
        if (self::$crawler === null) {
            self::$crawler = self::doGetCrawler();
        }
        
        return self::$crawler;
    }
    
    
    protected static function doGetCrawler ()
    {
        $crawler = new Crawler();
        $parser = new LinkedInDocumentParser();
        $details_operation = new DetailsOperation($parser);
        $crawler->addOperation($details_operation);
        
        return $crawler;
    }
}