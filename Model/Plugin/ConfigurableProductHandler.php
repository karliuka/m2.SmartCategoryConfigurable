<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Model\Plugin;

use Faonni\SmartCategory\Model\Rule;
use Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider;

/**
 * Replace configurable sub products 
 */
class ConfigurableProductHandler
{
    /** 
     * ConfigurableProducts Provider
     * 	
     * @var \Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider
     */
    protected $_configurableProductsProvider;

    /**
     * Initialize plugin
     * 	
     * @param ConfigurableProductsProvider $configurableProductsProvider
     */
    public function __construct(
        ConfigurableProductsProvider $configurableProductsProvider
    ) {
        $this->_configurableProductsProvider = $configurableProductsProvider;
    }

    /**
     * @param \Faonni\SmartCategory\Model\Rule $rule
     * @param array $productIds
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function afterGetMatchingProductIds(Rule $rule, array $productIds)
    {
        $object = $rule->getCategory() ?: $rule;
		if (!$object->getReplaceOnConfigurable()) {
			return $productIds;
		}
        
        $displayIds = $this->_configurableProductsProvider
			->getDisplayIds(array_keys($productIds)); 
			
		$products = [];	      
        foreach ($displayIds as $productId => $displayId) {
			if ($displayId !== null) {
				if ($displayId == 0) {
					$products[$productId] = 1;
				} elseif (!isset($products[$displayId])) {
					$products[$displayId] = 1;					
				}
			}           
        } 
        return $products;
    }
} 
