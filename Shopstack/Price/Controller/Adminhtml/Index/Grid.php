<?php
namespace Shopstack\Price\Controller\Adminhtml\Index;

class Grid extends \Shopstack\Price\Controller\Adminhtml\Index
{
    /**
     * Price Action
     *
     * @return \Magento\Framework\View\Result\Layout
     */
    public function execute()
    {
    	/**
    	 * Create grid block
    	 * 
    	 * @var string
    	 */
    	$block = $this->resultLayoutFactory->create()->getLayout()->createBlock('Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Grid');
    	
    	/**
    	 * Set response
    	 */
    	$this->getResponse()->setContent($block->setId('price_product_id_content')->toHtml())->sendResponse();
    	exit();
    }
}