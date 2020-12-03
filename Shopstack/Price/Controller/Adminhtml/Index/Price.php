<?php
 
namespace Shopstack\Price\Controller\Adminhtml\Index;

class Price extends \Shopstack\Price\Controller\Adminhtml\Index
{
    /**
     * Price Action
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
    	$customerId = $this->initCurrentCustomer();
    	
        $layout = $this->resultLayoutFactory->create();
        
        $layout->getLayout()->getBlock('prices')->setCustomerId($customerId)->setUseAjax(true);
        
        return $layout;
    }
}