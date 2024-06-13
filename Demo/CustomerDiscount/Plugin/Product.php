<?php
namespace Demo\CustomerDiscount\Plugin;

use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\CookieManagerInterface;

class Product
{
    protected $helper;
    private $httpContext;
    private $cookieManager;

 
     public function __construct(
         \Demo\CustomerDiscount\Helper\Data $helperData,
         HttpContext $httpContext,
         CookieManagerInterface $cookieManager

      ) {
         $this->helper = $helperData;
         $this->httpContext = $httpContext;
         $this->cookieManager = $cookieManager;
      }
   public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
   {
      $customer = $this->helper->getCustomer();
      $discountType = $customer->getDiscountType();
      $customerDiscount = $customer->getCustomerDiscount();
      
      $isLoggedIn = $this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
      if ($isLoggedIn) {
         $discountType = $this->cookieManager->getCookie('discount_type');;
         $customerDiscount = $this->cookieManager->getCookie('customer_discount');;
         if($discountType == "Fixed"){
            $result = $result-(float)$customerDiscount;
            return $result;
         } elseif ($discountType == "Percentage"){
            $result = ($result*(float)$customerDiscount)/100;
            return $result;
         } else {
               return $result;
         }
      } else {
         return $result;
      }    
   }
}