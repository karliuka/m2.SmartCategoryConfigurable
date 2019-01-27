<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Rule Save Observer
 */
class RuleSaveObserver implements ObserverInterface
{
    /**
     * Handler for Rule Save Event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $rule = $observer->getEvent()->getRule();
        $rule->setReplaceOnConfigurable(
            $rule->getCategory()->getReplaceOnConfigurable()
        );
    }
}
