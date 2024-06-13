<?php

namespace Demo\CustomerDiscount\Observer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\CookieManagerInterface;

class CustomerLoginObserver implements ObserverInterface
{
     public function __construct(
         CookieMetadataFactory $cookieMetadataFactory,
         CookieManagerInterface $cookieManager

      ) {
         $this->cookieMetadataFactory = $cookieMetadataFactory;
         $this->cookieManager = $cookieManager;
      }
    public function execute(Observer $observer)
    {
        /** @var CustomerInterface $customer */
        $customer = $observer->getEvent()->getCustomer();
        $discountType = $customer->getCustomAttribute('discount_type')?->getValue();
        $customerDiscount = $customer->getCustomAttribute('customer_discount')?->getValue();
        $this->setDiscountTypeCookie($discountType);
        $this->setCustomerDiscountCookie($customerDiscount);
    }

    public function setDiscountTypeCookie($discountType)
    {
        $cookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
            ->setHttpOnly(false)
            ->setDurationOneYear()
            ->setPath('/')
            ->setSameSite('Lax');

        $this->cookieManager->setPublicCookie(
            'discount_type',
            $discountType,
            $cookieMetadata
        );
    }

    public function setCustomerDiscountCookie($customerDiscount)
    {
        $cookieMetadata = $this->cookieMetadataFactory->createPublicCookieMetadata()
            ->setHttpOnly(false)
            ->setDurationOneYear()
            ->setPath('/')
            ->setSameSite('Lax');

        $this->cookieManager->setPublicCookie(
            'customer_discount',
            $customerDiscount,
            $cookieMetadata
        );
    }
}