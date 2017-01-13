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

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Category;

/**
 * Faonni_SmartCategoryConfigurable UpgradeSchema
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
		EavSetupFactory $eavSetupFactory
	) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }

    /**
     * Upgrades data for a module Faonni_SmartCategoryConfigurable
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        
        if (version_compare($context->getVersion(), '2.0.4', '<')) {
            $this->addReplaceOnConfigurableAttribute($setup);
        }        
             
        $setup->endSetup();  
	}

    /**
     * Add Replace on Configurable Attribute
	 *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    private function addReplaceOnConfigurableAttribute(ModuleDataSetupInterface $setup)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);        
        $eavSetup->addAttribute(
            Category::ENTITY,
            'replace_on_configurable',
            [
				'type' => 'int',
				'label' => 'Replace on Configurable',
				'input' => 'select',
				'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
				'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
				'required' => false,
				'sort_order' => 20,
				'default' => '1',				
				'group' => 'Products in Category',
				'note' => 'Replace the associated products (Not Visible Individually) on corresponding configurable product',
            ]
        );  
    }	
}
