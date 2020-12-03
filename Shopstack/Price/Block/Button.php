<?php
namespace Shopstack\Price\Block;

class Button extends \Magento\Backend\Block\Template
{
	public function _construct()
	{
		parent::_construct();
		
		$this->setTemplate('renderer/button.phtml');
	}
	
	public function getTarget()
	{
		return $this->getUrl('price/index/create') . '?isAjax=true';
	}
}