<?php
namespace Gacek85\LinkedInCrawler\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Finder\Finder;

/**
 *  Loads existing commands from the application Commands dir
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class CommandsLoader
{

    const COMMAND_PATTERN = '/Command\.php$/';

    protected $commands = null;
    
    protected $commands_directories = array();
    
    public function __construct ($commands_directory)
    {
        $this->commands_directories = is_array($commands_directory) 
                ? $commands_directory 
                : array($commands_directory);
    }
    
    /**
     * Returns a collection of all located command classes
     * inside a dir(s) defined in constructor
     * 
     * @return Command[]
     */
    public function getCommands ()
    {
        if ($this->commands === null) {
            $this->commands = $this->doGetCommands();
        }
        
        return $this->commands;
    }
    
    
    protected function doGetCommands ()
    {
        $commands = array();
        foreach ($this->commands_directories as $directory) {
            $this->load($directory, $commands);
        }
        
        return $commands;
    }
    
    
    protected function load ($directory, array &$commands)
    {
        $finder = new Finder();
        $finder->files()->in($directory)->name(self::COMMAND_PATTERN);
        foreach ($finder->getIterator() as $file) {
            $this->loadSingle($file, $commands);       
        }
    }
    
    
    protected function loadSingle ($file, array &$commands)
    {
        $name = pathinfo($file, PATHINFO_FILENAME);
        require_once $file;
        $instance = new $name();
        $commands[] = $instance;
    }
}