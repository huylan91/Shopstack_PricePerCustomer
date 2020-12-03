<?php
namespace Shopstack\Price\Model\ResourceModel\Item;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * @var \Magento\Catalog\Model\ProductFactory
	 */
	protected $factory = null;
	
	/**
	 * @var \Magento\Framework\App\RequestInterface
	 */
	protected $request = null;
	
	public function __construct
	(
		\Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
		\Magento\Catalog\Model\ProductFactory $factory,
		\Magento\Framework\View\Element\Context $context
	)
	{
		/**
		 * Set factory 
		 * 
		 * @var \Magento\Catalog\Model\ProductFactory
		 */
		$this->factory = $factory;
		
		/**
		 * Set request 
		 * 
		 * @var \Magento\Framework\App\RequestInterface
		 */
		$this->request = $context->getRequest();
		
		parent::__construct($entityFactory, $context->getLogger(), $fetchStrategy, $context->getEventManager());
	}
    /**
     * Initialize resource
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Shopstack\Price\Model\Item', 'Shopstack\Price\Model\ResourceModel\Item');
    }
    
    
    
    public function addCurrentCustomer()
    {
    	$this->addFieldToFilter('price_customer_id', $this->request->getParam('id'));
    	
    	return $this;
    }
    
    
    public function getSize()
    {
    	return sizeof( $this->getAllIds());
    }
    
    public function addDistinctCount()
    {
    	return $this;
    }
    
    /**
     * After load processing
     *
     * @return $this
     */
    protected function _afterLoad()
    {
    	parent::_afterLoad();
    	
    	/**
    	 * Associate each row with product
    	 */
        foreach ($this as $item) 
        {
        	if ((int) $item->getPriceProductId())
        	{
	        	$product = $this->factory->create()->load($item->getPriceProductId());
	        	
	            $item->setProduct($product);
        	}
        }

    	return $this;
    }
}