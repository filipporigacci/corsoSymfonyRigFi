<?php


namespace AppBundle\Services;

use Monolog\Logger as Logger;


class LogExample
{
    private $logger;

    /**
     * @param Logger $logger
     *
     */
    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function log($message){

        $this->logger->info($message);
    }



}