<?php
namespace Koklu\MasterData\Model\Resource\Catalog;

use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\Product\Attribute\Source\Status;

class Product
{
    /**
     * Product collection
     * @var \Magento\Catalog\Model\Resource\Product\Collection
     */
    protected $_productCollection;
    /**
     * Config object
     * @var \Koklu\MasterData\Model\Catalog\Config
     */
    protected $_config;

    /**
     * Constructor
     * @param \Magento\Catalog\Model\Resource\Product\Collection $productCollection
     * @param \Koklu\MasterData\Model\Catalog\Config $config
     */
    public function __construct(
        \Magento\Catalog\Model\Resource\Product\Collection $productCollection,
        \Koklu\MasterData\Model\Catalog\Config $config
    ) {
        $this->_productCollection = $productCollection;
        $this->_config = $config;
    }

    /**
     * Get products by IDs
     * @param array    $productIds
     * @param null|int $chunkSize
     * @param bool     $filterVisibility
     * @return \Magento\Catalog\Model\Resource\Product\Collection
     */
    public function getProducts(array $productIds = [], $chunkSize = null, $filterVisibility = true)
    {
        $this->_productCollection
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect($this->_config->getProductAttributes())
            ->addAttributeToSelect('status')
            ->addAttributeToSelect('visibility');

        if ($filterVisibility) {
            $this->_productCollection
                ->addAttributeToFilter('visibility', ['in' => [
                    Visibility::VISIBILITY_IN_CATALOG, Visibility::VISIBILITY_BOTH
                ]])
                ->addAttributeToFilter('status', Status::STATUS_ENABLED);
        }

        if (!empty($productIds)) {
            $this->_productCollection->addIdFilter($productIds);
        }
        if ($chunkSize !== null) {
            $this->_productCollection->setPageSize($chunkSize);
        }

        return $this->_productCollection;
    }

    /**
     * Get product by ID
     * @param int  $productId
     * @param bool $filterVisibility
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct($productId, $filterVisibility = true)
    {
        $collection = $this->getProducts([$productId], null, $filterVisibility);
        $collection->setPageSize(1);

        return $collection->getFirstItem();
    }
}