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
     * @var \Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider
     */
    private $_configurableProductsProvider;

    /**
     * @var array
     */
    private $_parentProducts = [];

    /**
     * @param \Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider $configurableProductsProvider
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
        $linkProductIds = $this->_configurableProductsProvider->getLinkIds(array_keys($productIds));       
        foreach ($linkProductIds as $productId => $parentId) {
            if (!isset($this->parentProducts[$parentId])) {
                $this->parentProducts[$parentId] = 1;
            }
            unset($productIds[$productId]);
        }           
        return array_replace($productIds, $this->parentProducts);
    }
} 
