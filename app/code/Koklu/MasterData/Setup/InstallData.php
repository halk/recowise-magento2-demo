<?php
namespace Koklu\MasterData\Setup;

use Koklu\MasterData\Helper\Data;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Data helper object
     * @var Data
     */
    protected $_helper;

    /**
     * EAV Setup Factory object
     * @var EavSetupFactory
     */
    protected $_eavSetupFactory;

    /**
     * Constructor
     * @param Data $helper
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(Data $helper, EavSetupFactory $eavSetupFactory)
    {
        $this->_helper = $helper;
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Sets used_in_recommender for relevant attributes
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

        $setup->startSetup();
        foreach ($this->_helper->getSystemAttributesToUseInRecommender() as $code) {
            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                $code,
                'used_in_recommender',
                true
            );
        }
        $setup->endSetup();
    }
}
