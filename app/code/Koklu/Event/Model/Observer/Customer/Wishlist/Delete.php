<?php
namespace Koklu\Event\Model\Observer\Customer\Wishlist;

use Koklu\Event\Model\Event;

class Delete extends \Koklu\Event\Model\Observer\Catalog\Product\Base
{
    const SUBJECT = 'removed_from_wishlist';

    /**
     * Builds event body for API
     * @param \Magento\Framework\Event $event
     * @return Event
     */
    public function buildEventBody(\Magento\Framework\Event $event)
    {
        return new Event(static::SUBJECT, [
            'user_id' => $this->_userHelper->getUserId(),
            'sku'     => $event->getItem()->getProduct()->getSku()
        ]);
    }
}