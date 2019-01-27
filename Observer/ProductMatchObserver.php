<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Product Match Observer
 */
class ProductMatchObserver implements ObserverInterface
{
    /**
     * Handler for Product Match Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $rule = $observer->getEvent()->getRule();
        $object = $rule->getCategory() ?: $rule;

        if ($object->getReplaceOnConfigurable()) {
            $rule->setVisibilityFilter(false);
        }
    }
}
