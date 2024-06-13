<?php
namespace Demo\CustomerDiscount\Plugin;

class Product
{
    protected $helper;
    private $_objectManager;

 
     public function __construct(
         \Demo\CustomerDiscount\Helper\Data $helperData,
         \Magento\Framework\ObjectManagerInterface $objectmanager
      ) {
         $this->helper = $helperData;
         $this->_objectManager = $objectmanager;
      }
   public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
   {
      // echo "<pre>";
      // print_r($subject->debug());
      // die('TTT');
      $customer = $this->helper->getCustomer();
      $customerSession = $this->_objectManager->get('Magento\Customer\Model\Session');
      $discountType = $customer->getDiscountType();
      $customerDiscount = $customer->getCustomerDiscount();
      if ($customerSession->isLoggedIn()){
         if($discountType == "Fixed"){
            $result = $result-(int)$customerDiscount;
            return $result;
         } elseif ($discountType == "Percentage"){
            $result = ($result*(int)$customerDiscount)/100;
            return $result;
         } else {
               return $result;
         }
       } else {
           return $result;
      }    
   }
}