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
 * @package     SmartCategoryConfigurable
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
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
