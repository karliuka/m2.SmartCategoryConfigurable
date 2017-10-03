<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * SmartCategoryConfigurable Upgrade Schema
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB Schema for a Module Faonni_SmartCategoryConfigurable
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $this->addReplaceOnConfigurableColumn($setup);
        }

        $setup->endSetup();
    }

    /**
     * Add Replace on Configurable Column
	 *
     * @param SchemaSetupInterface $setup
     * @return void
     */
    private function addReplaceOnConfigurableColumn(SchemaSetupInterface $setup)
    {
        $setup->getConnection()->addColumn(
            'faonni_smartcategory_rule',
            'replace_on_configurable',
            [
                'type' => Table::TYPE_SMALLINT,
                'unsigned' => true,
                'nullable' => false,
                'default' => 1,
                'comment' => 'Replace on Configurable'
            ]
        );
    }
}
