<?php
namespace Koklu\Event\Model\Observer\Catalog\Product;

use Koklu\Event\Model\Event;
use Koklu\Event\Model\Observer\CustomerAbstract;

class Base extends CustomerAbstract
{
    const SUBJECT = 'catalog_product';

    /**
     * Builds event body for API
     * @param \Magento\Framework\Event $event
     * @return Event
     */
    public function buildEventBody(\Magento\Framework\Event $event)
    {
        return new Event(static::SUBJECT, [
            'user_id' => $this->_userHelper->getUserId(),
            'sku'     => $event->getProduct()->getSku()
        ]);
    }
}