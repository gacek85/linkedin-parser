<?php

use Gacek85\LinkedInCrawler\CrawlerFactory;
use Gacek85\LinkedInCrawler\Input\HtmlFileInput;
use Gacek85\LinkedInCrawler\Saver\CsvSaver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 *  Crawles given file
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CrawlFileCommand extends Command 
{
    
    protected function configure()
    {
        $this
            ->setName('linkedin:crawl-file:csv')
            ->setDescription('Parses given HTML file and outputs the parsed content in a CSV file')
            ->addArgument('path', InputArgument::REQUIRED, 'The path to the input HTML file')
            ->addArgument('output_path', InputArgument::REQUIRED, 'The path to the output CSV file')
        ;
    }
    
    
    protected function execute (InputInterface $input, OutputInterface $output)
    {
        $output_path = $input->getArgument('output_path');
        $input_path = $input->getArgument('path');
        $input_resource = new HtmlFileInput($input_path);
        
        $crawler = CrawlerFactory::getCrawler();
        $output_data = $crawler->execute('details', $input_resource);
        $csv_saver = new CsvSaver($output_path);
        if (!$csv_saver->canHandle($output_data)) {
            throw new RuntimeException('The output is in a wrong format!');
        }
        $csv_saver->handle($output_data);
        
        
        
        $output->writeln(sprintf(
            'The data is stored now in a file %s',
            $output_path
        ));
    }
}