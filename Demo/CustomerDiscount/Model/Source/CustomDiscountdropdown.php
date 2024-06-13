<?php

namespace Demo\CustomerDiscount\Model\Source;

class CustomDiscountdropdown extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource 
{
    /* Discount Type Options */
    public function getAllOptions() 
    {
        if ($this->_options === null) {
            $this->_options = [
                ['value' => '', 'label' => __('Please Select')],

                ['value' => 'Fixed', 'label' => __('Fixed')],

                ['value' => 'percentage', 'label' => __('Percentage')]
            ];
        }
        return $this->_options;
    }

    public function getOptionText($value) 
    {
        foreach ($this->getAllOptions() as $option)
        {
            if ($option['value'] == $value)
            {
                return $option['label'];
            }
        }
        return false;
    }
}