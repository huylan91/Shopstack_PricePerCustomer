<?php
namespace Shopstack\Price\Controller\Adminhtml\Index;

class Create extends \Magento\Backend\App\Action
{
	/**
	 * @var \Shopstack\Price\Model\ItemFactory
	 */
	protected $factory = null;
	
	
	/**
	 * @var \Magento\Framework\App\Cache\TypeListInterface
	 */
	protected $cacheTypeList = null;
	
	/**
	 * @var \Magento\Framework\App\Cache\Frontend\Pool
	 */
	protected $cacheFrontendPool = null;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Backend\App\Action\Context $context
	 * @param \Shopstack\Price\Model\ItemFactory $factory
	 * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
	 * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
	 */
	public function __construct
	(
		\Magento\Backend\App\Action\Context $context,
		\Shopstack\Price\Model\ItemFactory $factory,
		\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
		\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
	)
	{
		parent::__construct($context);
		
		$this->factory 				= $factory;
		$this->cacheTypeList 		= $cacheTypeList;
		$this->cacheFrontendPool 	= $cacheFrontendPool;
	}
	
	/**
	 * Execute 
	 * 
	 * {@inheritDoc}
	 * @see \Magento\Framework\App\ActionInterface::execute()
	 */
    public function execute()
    {
    	$response = new \Magento\Framework\DataObject(array
    	(
    		'success' => false
    	));
    	
    	/**
    	 * Function pusher 
    	 * 
    	 * @var Closure
    	 */
    	$f = function($product = null) use ($response)
    	{
    		$model = $this->factory->create();
    		
    		
    		$data = 
    		[
    			'price_customer_id' 	=> 			$this->getRequest()->getParam('customer_id'),
    			'price_type' 			=> (int) 	$this->getRequest()->getParam('price_type'),
    			'price' 				=> (float) 	$this->getRequest()->getParam('price_fixed'),
    			'price_discount' 		=> (float) 	$this->getRequest()->getParam('price_discount'),
    			'price_amount' 			=> (float) 	$this->getRequest()->getParam('price_amount'),
    			'price_tier_quantity'	=> (int) 	$this->getRequest()->getParam('price_tier_quantity'),
    			'price_valid_from'		=> strtotime
    			(
    				$this->getRequest()->getParam('price_valid_from')
    			),
    			'price_valid_to'		=> strtotime
    			(
    				$this->getRequest()->getParam('price_valid_to')
    			)
    		];
    		
    		if ($product > 0)
    		{
    			$data['price_product_id'] = (int) $product;
    		}
    		

    		$model->setData($data);
    		
    		try
    		{
    			$model->save();
    			 
    			 
    			/**
    			 * Set success status
    			 */
    			$response->setSuccess(true);
    		}
    		catch (\Exception $e)
    		{
    			$response->setError($e->getMessage());
    		}
    	};
    	
    	/**
    	 * Get products
    	 *
    	 * @var \ArrayAccess
    	 */
    	$products = [];
    	 
    	/**
    	 * Get products
    	 *
    	 * @var \ArrayAccess
    	*/
    	$products = (array) $this->getRequest()->getParam('price_product_id');
    	 
    	if ($products)
    	{
    		foreach ($products as $product)
    		{
    			$f((int) $product);
    		}
    	}
    	else 
    	{
    		$f();
    	}
    	

    	/**
    	 * Refresh cache and initialize response
    	 */
    	$this->refresh()->getResponse()->setBody(json_encode($response->getData(), JSON_PRETTY_PRINT));
    }
    
    /**
     * Clear cache
     */
    private function refresh()
    {
    	$types = array
    	(
    		'config',
    		'layout',
    		'block_html',
    		'full_page'
    	);
    
    	foreach ($types as $type)
    	{
    		$this->cacheTypeList->cleanType($type);
    	}
    
    	foreach ($this->cacheFrontendPool as $cacheFrontend)
    	{
    		$cacheFrontend->getBackend()->clean();
    	}
    
    	return $this;
    }
}