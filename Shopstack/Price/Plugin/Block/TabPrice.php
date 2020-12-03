<?php

namespace Shopstack\Price\Plugin\Block;

class TabPrice extends \Magento\Backend\Block\Template
{
	/**
	 * Block output modifier 
	 * 
	 * @param \Magento\Framework\View\Element\Template $block
	 * @param string $html
	 */
	public function afterToHtml($block, $content) 
	{
		if (!$this->getRequest()->getParam('ajax'))
		{
			$content .= $block->getLayout()->createBlock('Shopstack\Price\Block\Form')->toHtml();
		}
		
		return $content;
	}
}