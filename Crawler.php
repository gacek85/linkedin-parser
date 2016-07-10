<?php

namespace Gacek85\LinkedInCrawler;

use Gacek85\LinkedInCrawler\OperationInterface;
use Gacek85\LinkedInCrawler\InputInterface;

/**
 *  Main endopint for the LinkedIn servide operations
 *
 *  @author Maciej Garycki <maciekgarycki@gmail.com>
 */
class Crawler 
{
    
    /**
     *
     * @var OperationInterface[] 
     */
    protected $operations = array();
    
    
    /**
     * Registers an operation
     * 
     * @param       OperationInterface      $operation
     * @return      Crawler                 This instance
     * @throws      \RuntimeException       If operation is already registered
     */
    public function addOperation (OperationInterface $operation)
    {
        $key = $operation->getKey();
        if (array_key_exists($key, $this->operations)) {
            throw new \RuntimeException(sprintf(
                'The operation %s is already registered!',
                $key
            ));
        }
        $this->operations[$key] = $operation;
        
        return $this;
    }
    
    
    /**
     * Executes the operation on given input
     * 
     * @param       string                      $operation_key
     * @param       InputInterface              $input
     * @return      OutputInterface
     * @throws      \InvalidArgumentException   If the operation cannot handle
     *                                          given input
     */
    public function execute ($operation_key, InputInterface $input)
    {
        /* @var $operation OperationInterface */
        $operation = $this->getOperation($operation_key);
        
        if (!$operation->canConsume($input)) {
            throw new \InvalidArgumentException(sprintf(
                'The operation %s cannot consume given intput %s of class %s!', 
                $operation_key,
                $input->getType(),
                get_class($input)
            ));
        }
        
        $output = $operation->execute($input);
        
        return $output;
    }
    
    
    protected function getOperation ($operation_key)
    {
        if (!array_key_exists($operation_key, $this->operations)) {
            throw new \InvalidArgumentException(sprintf(
                'The operation %s does not exist!', 
                $operation_key
            ));
        }
        
        return $this->operations[$operation_key];
    }
}