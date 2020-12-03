<?php
 
namespace Shopstack\Price\Block\Adminhtml\Edit\Tab\View;

class Price extends \Magento\Backend\Block\Widget\Grid\Extended
{
	protected $_coreRegistry 		= null;
	protected $_collectionFactory 	= null;
	
    public function __construct
    (
    	\Magento\Backend\Block\Template\Context $context,
    	\Magento\Backend\Helper\Data $backendHelper,
    	\Shopstack\Price\Model\ResourceModel\Item\CollectionFactory $collectionFactory,
    	\Magento\Framework\Registry $coreRegistry,
    	array $data = []
    ) 
    {
        $this->_coreRegistry 		= $coreRegistry;
        $this->_collectionFactory 	= $collectionFactory;
        
        parent::__construct($context, $backendHelper, $data);
    }
    
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
    	parent::_construct();
    	
    	$this->setId('customer_price_grid');
    	$this->setUseAjax(true);
    }
    
    protected function _prepareCollection()
    {
    	try 
    	{
			
	    	$collection = $this->_collectionFactory->create()->addCurrentCustomer();
	    	/**
	    	 * Set collection
	    	 */
	    	$this->setCollection($collection);
	    	
	    	parent::_prepareCollection();
    	}
    	catch (\Exception $e)
    	{
    		$this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the statement.'));
    	}
    	
    	return $this;
    }
    
    /**
     * Prepare grid mass actions
     *
     * @return void
     */
    protected function _prepareMassaction()
    {
    	$this->setMassactionIdField('price_id');
    	$this->getMassactionBlock()->setUseAjax(true);
    	$this->getMassactionBlock()->setFormFieldName('price');
    
    	$this->getMassactionBlock()->addItem
    	(
    		'delete',
    		[
    			'label' => __('Delete'),
    			'url' => $this->getUrl
    			(
    				'price/index/massDelete',['_current' => true]
    			),
    			'confirm' => __('Are you sure?'),
    			'complete' => 'customer_price_gridJsObject.reload()'
    		]
    	);
    }

    /**
     * Prepare columns.
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('value',
        [
        	'header' 	=> __('Product'),
        	'index'		=> 'value',
        	'renderer' 	=> 'Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Renderer\Item'
        ]);

        $this->addColumn('price',
        [
        	'header' 	=> __('Price'),
        	'index'		=> 'price',
        	'type' 		=> 'number',
        	'width' 	=> '60px',
        	'renderer' 	=> 'Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Renderer\Fixed'
        ]);

        
        $this->addColumn('price_valid_from',
        [
        	'header' 	=> __('Valid from'),
        	'index' 	=> 'price_valid_from',
        	'width' 	=> '80px',
        	'type' 		=> 'date'
        ]);
        
        $this->addColumn('price_valid_to',
        [
        	'header' 	=> __('Valid to'),
        	'index' 	=> 'price_valid_to',
        	'width' 	=> '80px',
        	'type' 		=> 'date'
        ]);
        
        
        
        return parent::_prepareColumns();
    }

    /**
     * Get headers visibility
     *
     * @return bool
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getHeadersVisibility()
    {
        return $this->getCollection()->getSize() >= 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowUrl($row)
    {
        return null;
    }
}
