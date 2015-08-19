<?php
namespace Koklu\Recommender\Model;

use Koklu\Event\Model\Event;
use Koklu\Recommender\Helper\Data;

class Client
{
    /**
     * REST client
     * @var \Zend_Rest_Client
     */
    protected $_client;

    /**
     * Recommender helper
     * @var Data
     */
    protected $_helper;

    /**
     * Logging handler for events
     * @var \Koklu\Recommender\Logger\Event
     */
    protected $_eventLogger;

    /**
     * Logging handler for recommendations
     * @var \Koklu\Recommender\Logger\Recommender
     */
    protected $_recommendLogger;

    /**
     * Constructor
     * @param Data $helper
     * @param \Koklu\Recommender\Logger\Event $eventLogger
     * @param \Koklu\Recommender\Logger\Recommender $recommenderLogger
     * @throws \Zend_Http_Client_Exception
     */
    public function __construct(
        Data $helper,
        \Koklu\Recommender\Logger\Event $eventLogger,
        \Koklu\Recommender\Logger\Recommender $recommenderLogger
    ) {
        $this->_helper = $helper;
        $this->_eventLogger = $eventLogger;
        $this->_recommendLogger = $recommenderLogger;

        $this->_client = new \Koklu\Rest\Json\Client($helper->getApiBaseUrl());
        $this->_client->getHttpClient()->setConfig([
                'keepalive'    => true,
                'useragent'    => 'Magento2 Recommender Client',
                'maxredirects' => 0
            ])
            ->setUnmaskStatus(true);
    }

    /**
     * Post event body to event API
     * @param Event $event
     * @return bool
     */
    public function postEvent(Event $event)
    {
        try {
            $response = $this->_client->restPost(
                sprintf('/event/%s', $event->getSubject()), $event->toArray()
            );
            $this->_eventLogger->logApiCall($this->_client, $response);
        } catch (\Zend_Http_Client_Exception $e) {
            $this->_eventLogger->logApiCallException($this->_client, $e);
        }

        return true;
    }

    /**
     * Get recommendations from recommender API
     * @param string $type
     * @param array  $parameters
     * @return array
     */
    public function getRecommendations($type, $parameters)
    {
        try {
            $response = $this->_client->restGet(sprintf('/recommend/%s', $type), $parameters);
            $this->_recommendLogger->logApiCall($this->_client, $response);
            if ($response->getStatus() !== 200) {
                throw new \Zend_Http_Client_Exception('Recommender failed to respond');
            }

            $recommendations = json_decode($response->getRawBody(), true);
            if (is_array($recommendations)) {
                return $recommendations;
            }
        } catch (\Zend_Http_Client_Exception $e) {
            $this->_recommendLogger->logApiCallException($this->_client, $e);
        }

        return [];
    }
}