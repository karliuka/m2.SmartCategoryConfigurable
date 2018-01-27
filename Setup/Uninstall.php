<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Setup;

use Magento\Framework\Setup\UninstallInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Category;

/**
 * SmartCategoryConfigurable Uninstall
 */
class Uninstall implements UninstallInterface
{
    /**
     * EAV Setup Factory
     *
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * Initialize Setup
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
		EavSetupFactory $eavSetupFactory
	) {
        $this->_eavSetupFactory = $eavSetupFactory;
    }
    
    /**
     * Uninstall DB Schema for a Module SmartCategoryConfigurable
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->removeAttributes();	
		
        $setup->endSetup();
    }

    /**
     * Remove Attributes
     *
     * @return void
     */
    private function removeAttributes()
    {
        $attributes = ['replace_on_configurable'];
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->_eavSetupFactory->create();         
        foreach ($attributes as $attribute) {
			$eavSetup->removeAttribute(Category::ENTITY, $attribute); 	
        }
    }    
}