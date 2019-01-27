<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Plugin\SmartCategory\Model;

use Faonni\SmartCategory\Model\Rule as SmartCategoryRule;
use Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider;

/**
 * Rule Plugin
 */
class Rule
{
    /**
     * ConfigurableProducts Provider
     *
     * @var \Faonni\SmartCategoryConfigurable\Model\ConfigurableProductsProvider
     */
    protected $_configurableProductsProvider;

    /**
     * Initialize Plugin
     *
     * @param ConfigurableProductsProvider $configurableProductsProvider
     */
    public function __construct(
        ConfigurableProductsProvider $configurableProductsProvider
    ) {
        $this->_configurableProductsProvider = $configurableProductsProvider;
    }

    /**
     * Get Array of Product ids Which are Matched by Rule
     *
     * @param SmartCategoryRule $rule
     * @param array $productIds
     * @return array
     */
    public function afterGetMatchingProductIds(SmartCategoryRule $rule, array $productIds)
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
