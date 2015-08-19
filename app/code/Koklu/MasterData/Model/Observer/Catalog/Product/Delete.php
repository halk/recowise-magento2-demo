<?php
namespace Koklu\MasterData\Model\Observer\Catalog\Product;

use Koklu\Event\Model\Event;
use Koklu\Event\Model\Observer\ObserverAbstract;

class Delete extends ObserverAbstract
{
    const EVENT_SUBJECT = 'deleted_product';

    /**
     * Builds event body for API
     * @param \Magento\Framework\Event $event
     * @return Event
     */
    public function buildEventBody(\Magento\Framework\Event $event)
    {
        return new Event(self::EVENT_SUBJECT, ['sku' => $event->getProduct()->getSku()]);
    }
}