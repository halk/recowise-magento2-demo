<?php
namespace Koklu\Event\Model\Observer;

abstract class ObserverAbstract
{
    /**
     * Recommender client
     * @var \Koklu\Recommender\Model\Client
     */
    protected $_client;

    /**
     * Constructor
     * @param \Koklu\Recommender\Model\Client $client
     */
    public function __construct(\Koklu\Recommender\Model\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * Process event
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function process(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->skip()) {
            return;
        }

        $body = $this->buildEventBody($observer->getEvent());
        if ($body !== null) {
            $this->_client->postEvent($body);
        }
    }

    /**
     * Builds event body for API
     * @param \Magento\Framework\Event $event
     * @return \Koklu\Event\Model\Event
     */
    abstract public function buildEventBody(\Magento\Framework\Event $event);

    /**
     * Override this method if event has conditions
     * @return bool
     */
    protected function skip()
    {
        return false;
    }
}