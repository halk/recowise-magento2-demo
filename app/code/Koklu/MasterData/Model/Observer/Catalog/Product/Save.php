<?php
namespace Koklu\MasterData\Model\Observer\Catalog\Product;

use Koklu\Event\Model\Event;
use Koklu\Event\Model\Observer\ObserverAbstract;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Model\Product\Visibility;

class Save extends ObserverAbstract
{
    const EVENT_SUBJECT = 'saved_product';

    /**
     * Product builder object
     * @var \Koklu\MasterData\Model\Catalog\Product\Builder
     */
    protected $_productBuilder;

    /**
     * Product resource object
     * @var \Koklu\MasterData\Model\Resource\Catalog\Product
     */
    protected $_productResource;

    /**
     * Event manager object
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $_eventManager;

    /**
     * Constructor
     * @param \Koklu\Recommender\Model\Client $client
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Visitor $customerVisitor
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Koklu\MasterData\Model\Resource\Catalog\Product $productResource
     * @param \Koklu\MasterData\Model\Catalog\Product\Builder $productBuilder
     */
    public function __construct(
        \Koklu\Recommender\Model\Client $client,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Visitor $customerVisitor,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Koklu\MasterData\Model\Resource\Catalog\Product $productResource,
        \Koklu\MasterData\Model\Catalog\Product\Builder $productBuilder
    ) {
        parent::__construct($client, $customerSession, $customerVisitor);
        $this->_productBuilder = $productBuilder;
        $this->_productResource = $productResource;
        $this->_eventManager = $eventManager;
    }

    /**
     * Builds event body for API
     * @param \Magento\Framework\Event $event
     * @return \Koklu\Event\Model\Event
     */
    public function buildEventBody(\Magento\Framework\Event $event)
    {
        $product = $this->_productResource->getProduct($event->getProduct()->getId(), false);

        // we do not need to send an event if product is disabled or invisible
        $allowedVisibility = [Visibility::VISIBILITY_IN_CATALOG, Visibility::VISIBILITY_BOTH];
        if ($product->getStatus() != Status::STATUS_ENABLED
            || !in_array($product->getVisibility(), $allowedVisibility)
        ) {
            // however if the changes involved status or visibility, then we need to send a delete event
//            if ($event->getProduct()->dataHasChangedFor('status')
//                || $event->getProduct()->dataHasChangedFor('visibility')
//            ) {
                $this->_eventManager->dispatch(
                    'koklu_masterdata_not_salable_product_save', ['product' => $product]
                );
//            }
            return null;
        }

        return new Event(self::EVENT_SUBJECT, $this->_productBuilder->create($product));
    }
}