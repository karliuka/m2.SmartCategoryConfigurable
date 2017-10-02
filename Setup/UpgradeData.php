<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
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
 * SmartCategoryConfigurable Upgrade Data
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
     * Upgrades DB Data for a Module Faonni_SmartCategoryConfigurable
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
