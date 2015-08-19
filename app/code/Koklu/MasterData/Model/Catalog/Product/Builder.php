<?php
namespace Koklu\MasterData\Model\Catalog\Product;

use Magento\Catalog\Model\Product;

class Builder
{
    /**
     * Config object
     * @var \Koklu\MasterData\Model\Catalog\Config
     */
    protected $_config;
    /**
     * Cache for attributes
     * @var array|null
     */
    protected $_attributes;
    /**
     * Helper object
     * @var \Koklu\MasterData\Helper\Data
     */
    protected $_helper;

    /**
     * Constructor
     * @param \Koklu\MasterData\Model\Catalog\Config $config
     * @param \Koklu\MasterData\Helper\Data $helper
     */
    public function __construct(
        \Koklu\MasterData\Model\Catalog\Config $config,
        \Koklu\MasterData\Helper\Data $helper
    ) {
        $this->_config = $config;
        $this->_helper = $helper;
    }

    /**
     * Creates a product dataset which is filtered for the attributes the recommender system requires
     *
     * @param Product $product
     * @return array
     */
    public function create(Product $product)
    {
        $data = array_intersect_key($product->getData(), $this->getAttributes());
        return ['sku' => $product->getSku(), 'data' => $data];
    }

    /**
     * Get attributes for the recommender system
     * @return array
     */
    protected function getAttributes()
    {
        if ($this->_attributes === null) {
            $this->_attributes = array_fill_keys($this->_config->getProductAttributes(), true);
        }
        return $this->_attributes;
    }
}