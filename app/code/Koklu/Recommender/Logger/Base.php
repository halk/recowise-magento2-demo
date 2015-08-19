<?php
namespace Koklu\Recommender\Logger;

class Base extends \Monolog\Logger
{
    /**
     * Log API call (request and response)
     * @param \Zend_Rest_Client $client
     * @param \Zend_Http_Response $response
     * @return void
     */
    public function logApiCall(
        \Zend_Rest_Client $client,
        \Zend_Http_Response $response
    ) {
        $this->info($client->getHttpClient()->getLastRequest());
        $this->info($response);
    }

    /**
     * Log API call (request and response)
     * @param \Zend_Rest_Client $client
     * @param \Exception $exception
     * @return void
     */
    public function logApiCallException(
        \Zend_Rest_Client $client,
        \Exception $exception
    ) {
        $this->info($client->getHttpClient()->getLastRequest());
        $this->err($exception->getMessage());
    }
}
