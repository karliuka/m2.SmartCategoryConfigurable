<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_SmartCategoryConfigurable
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\SmartCategoryConfigurable\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Faonni_SmartCategoryConfigurable UpgradeSchema
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * Upgrades DB schema for a module Faonni_SmartCategoryConfigurable
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