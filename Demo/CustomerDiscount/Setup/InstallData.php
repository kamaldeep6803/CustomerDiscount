<?php
namespace Demo\CustomerDiscount\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface 
{
   private $eavSetupFactory;

   public function __construct(
      EavSetupFactory $eavSetupFactory,
      Config $eavConfig
   ) 
   {
      $this->eavSetupFactory = $eavSetupFactory;
      $this->eavConfig = $eavConfig;
   }

   public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) 
   {
      $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

      /* Discount Type Attribute */
      $eavSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'discount_type', [
         'label' => 'Discount Type',
         'system' => 0,
         'position' => 700,
         'sort_order' => 700,
         'visible' => true,
         'note' => '',
         'type' => 'text',
         'input' => 'select',
         'source' => 'Demo\CustomerDiscount\Model\Source\CustomDiscountdropdown',
         ]
      );

      $this->getEavConfig()->getAttribute('customer', 'discount_type')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout'])->save();

        /* Customer Discount Attribute */
      $eavSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'customer_discount', [
         'label' => 'Customer Discount',
         'system' => 0,
         'position' => 800,
         'sort_order' => 800,
         'visible' => true,
         'note' => '',
         'type' => 'varchar',
         'input' => 'text',
         ]
      );

      $this->getEavConfig()->getAttribute('customer', 'customer_discount')->setData('is_user_defined', 1)->setData('is_required', 0)->setData('default_value', '')->setData('used_in_forms', ['adminhtml_customer', 'checkout_register', 'customer_account_create', 'customer_account_edit', 'adminhtml_checkout'])->save();
   }
 
   public function getEavConfig() {
      return $this->eavConfig;
   }
}