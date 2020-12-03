<?php

namespace Shopstack\Price\Controller\Adminhtml\Index;

class MassDelete extends \Magento\Backend\App\Action
{
	protected $factory = null;

	public function __construct
	(
		\Magento\Backend\App\Action\Context $context,
		\Shopstack\Price\Model\ItemFactory $factory
	)
	{
		parent::__construct($context);
		
		$this->factory = $factory;
	}
	
	public function execute()
	{
		foreach ((array) $this->getRequest()->getParam('price') as $price)
		{
			$this->factory->create()->load($price)->delete();
		}
		
		$this->getResponse()->setBody(json_encode(array
		(
			'success' => true
		), JSON_PRETTY_PRINT));
	}
}
