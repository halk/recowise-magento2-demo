<?php
namespace Koklu\Recommender\Logger\Handler;

use Monolog\Logger;

abstract class Base extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::INFO;
}
