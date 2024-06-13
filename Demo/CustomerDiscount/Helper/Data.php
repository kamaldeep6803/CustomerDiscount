<?php

namespace Demo\CustomerDiscount\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    private $customerSession;

    public function __construct(
        Context $context,
        \Magento\Customer\Model\Session $customerSession

    )
    {
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function getCustomer()
    {
        $customer = $this->customerSession->getCustomer();
        return $customer;
    }
}