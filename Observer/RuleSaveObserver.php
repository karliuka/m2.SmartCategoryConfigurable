<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\SmartCategoryConfigurable\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * Rule save observer
 */
class RuleSaveObserver implements ObserverInterface
{	
    /**
     * Handler for rule save event
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
        return $this;
    }
}  
 
