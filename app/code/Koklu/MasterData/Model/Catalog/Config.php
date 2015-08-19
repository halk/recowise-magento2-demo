<?php
namespace Koklu\MasterData\Model\Catalog;

class Config
{
    /**
     * Array of attributes codes needed for product load
     *
     * @var array
     */
    protected $_productAttributes;

    /**
     * Product Attributes used in recommender
     *
     * @var array
     */
    protected $_usedInRecommender;

    /**
     * Eav config
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $_eavConfig;

    /**
     * Config factory
     *
     * @var \Magento\Catalog\Model\Resource\ConfigFactory
     */
    protected $_configFactory;

    /**
     * Constructor
     *
     * @param \Koklu\MasterData\Model\Resource\Catalog\ConfigFactory $configFactory
     * @param \Magento\Eav\Model\Config $eavConfig
     */
    public function __construct(
        \Koklu\MasterData\Model\Resource\Catalog\ConfigFactory $configFactory,
        \Magento\Eav\Model\Config $eavConfig
    ) {
        $this->_configFactory = $configFactory;
        $this->_eavConfig = $eavConfig;
    }

    /**
     * Load Product attributes
     *
     * @return array
     */
    public function getProductAttributes()
    {
        if ($this->_productAttributes === null) {
            $this->_productAttributes = array_keys($this->getAttributesUsedInRecommender());
        }
        return $this->_productAttributes;
    }

    /**
     * Retrieve resource model
     *
     * @return \Koklu\MasterData\Model\Resource\Catalog\Config
     */
    protected function _getResource()
    {
        return $this->_configFactory->create();
    }

    /**
     * Retrieve Attributes used in product listing
     *
     * @return array
     */
    public function getAttributesUsedInRecommender()
    {
        if ($this->_usedInRecommender === null) {
            $this->_usedInRecommender = [];
            $entityType = \Magento\Catalog\Model\Product::ENTITY;

            $attributesData = $this->_getResource()->getAttributesUsedInRecommender();
            $this->_eavConfig->importAttributesData($entityType, $attributesData);

            foreach ($attributesData as $attributeData) {
                $attributeCode = $attributeData['attribute_code'];
                $this->_usedInRecommender[$attributeCode] = $this->_eavConfig->getAttribute(
                    $entityType, $attributeCode
                );
            }
        }
        return $this->_usedInRecommender;
    }
}