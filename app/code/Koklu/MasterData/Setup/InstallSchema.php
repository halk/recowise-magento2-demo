<?php
namespace Koklu\MasterData\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $connection = $setup->getConnection();

        $connection->addColumn(
            $setup->getTable('catalog_eav_attribute'),
            'used_in_recommender',
            "smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Is Used In Product Listing'"
        );
        $connection->addIndex(
            $setup->getTable('catalog_eav_attribute'),
            $setup->getIdxName('catalog_eav_attribute', ['used_in_recommender']),
            ['used_in_recommender']
        );

        $setup->endSetup();
    }
}