<?php

namespace Demo\CustomerDiscount\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class CustomPrice implements ObserverInterface
{

    public function execute(Observer $observer)
    {
        $item = $observer->getEvent()->getData('quote_item');
        $item = ( $item->getParentItem() ? $item->getParentItem() : $item );
        $customer = $observer->getCustomer();
        $customerPrice = $item->getData('price');
        $item->setCustomPrice($customerPrice);
        $item->setOriginalCustomPrice($customerPrice);
        $item->getProduct()->setIsSuperMode(true);
    }
}