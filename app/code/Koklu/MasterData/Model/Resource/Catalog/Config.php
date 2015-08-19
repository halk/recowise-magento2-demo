<?php
namespace Koklu\MasterData\Model\Resource\Catalog;

class Config extends \Magento\Framework\Model\Resource\Db\AbstractDb
{
    /**
     * Catalog product entity type id
     *
     * @var int
     */
    protected $_entityTypeId;


    /**
     * Eav config
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $_eavConfig;

    /**
     * @param \Magento\Framework\Model\Resource\Db\Context $context
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\Resource\Db\Context $context,
        \Magento\Eav\Model\Config $eavConfig,
        $resourcePrefix = null
    ) {
        $this->_eavConfig = $eavConfig;
        parent::__construct($context, $resourcePrefix);
    }

    /**
     * Initialize connection
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('eav_attribute', 'attribute_id');
    }

    /**
     * Retrieve catalog_product entity type id
     *
     * @return int
     */
    public function getEntityTypeId()
    {
        if ($this->_entityTypeId === null) {
            $this->_entityTypeId = (int)$this->_eavConfig->getEntityType(\Magento\Catalog\Model\Product::ENTITY)
                ->getId();
        }
        return $this->_entityTypeId;
    }

    /**
     * Retrieve Product Attributes Used in Recommender
     *
     * @return array
     */
    public function getAttributesUsedInRecommender()
    {
        $adapter = $this->_getReadAdapter();

        $select = $adapter->select()->from(
            ['main_table' => $this->getTable('eav_attribute')]
        )->join(
            ['additional_table' => $this->getTable('catalog_eav_attribute')],
            'main_table.attribute_id = additional_table.attribute_id'
        )->where(
            'main_table.entity_type_id = ?', $this->getEntityTypeId()
        )->where(
            'additional_table.used_in_recommender = ?', 1
        );

        return $adapter->fetchAll($select);
    }
}
