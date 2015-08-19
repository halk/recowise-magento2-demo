<?php
namespace Koklu\Recommender\Model\Recommender\Checkout\Cart;

use Koklu\Recommender\Model\Client;

class Similar extends \Koklu\Recommender\Model\RecommenderAbstract
{
    /**
     * Type of recommender (see recommender configuration)
     */
    const TYPE = 'similar_products_in_basket';

    /**
     * Checkout session object
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * Constructor
     *
     * @param \Magento\Framework\Registry $registry
     * @param Client $client
     * @param \Koklu\Event\Helper\User $userHelper
     * @param \Magento\Checkout\Model\Session $checkoutSession
     */
    public function __construct(
        \Magento\Framework\Registry $registry,
        Client $client,
        \Koklu\Event\Helper\User $userHelper,
        \Magento\Checkout\Model\Session $checkoutSession
    ) {
        parent::__construct($registry, $client, $userHelper);
        $this->_checkoutSession = $checkoutSession;
    }

    /**
     * Add basket items
     *
     * @param array $params
     * @return array
     */
    public function setParameters(array $params = [])
    {
        $params['sku'] = $this->_getQuoteItems();
        return parent::setParameters($params);
    }

    /**
     * Returns an array of SKUs of items in the basket
     *
     * @return array
     */
    protected function _getQuoteItems()
    {
        $skus = [];
        foreach ($this->_checkoutSession->getQuote()->getAllVisibleItems() as $item) {
            $skus[] = $item->getProduct()->getData('sku');
        }

        return $skus;
    }
}