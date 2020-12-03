<?php
namespace Shopstack\Price\Block\Adminhtml\Edit\Tab\View;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
	/**
     * Core registry
     *
     * @var \Magento\Framework\Registry|null
     */
    protected $_coreRegistry = null;
 
    /**
     * @var \Magento\Sales\Model\Resource\Order\Grid\CollectionFactory
     */
    protected $_collectionFactory;
 
    /**
     * Constructor
     *
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Sales\Model\Resource\Order\Grid\CollectionFactory $collectionFactory
     * @param \Magento\Framework\Registry $coreRegistry
     * @param array $data
     */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $collectionFactory,
        \Magento\Framework\Registry $coreRegistry,
        array $data = []
    ) 
    {
        $this->_coreRegistry 		= $coreRegistry;
        $this->_collectionFactory 	= $collectionFactory;
        
        parent::__construct($context, $backendHelper, $data);
    }
 
    /**
     * Initialize the orders grid.
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        
        $this->setDefaultSort('created_at', 'desc');
        
        $this->setSortable(false);
        $this->setPagerVisibility(true);
        $this->setFilterVisibility(true);
        $this->setUseAjax(true);
    }

 
    /**
     * {@inheritdoc}
     */
    protected function _prepareCollection()
    {
        $collection = $this->_collectionFactory->create()->addAttributeToSelect(array("name","price", "sku"))->addAttributeToFilter('type_id', array('nin' => array('configurable','grouped','bundle')));

        $this->setCollection($collection);
        
        parent::_prepareCollection();
        
        return $this;
    }
 
    /**
     * {@inheritdoc}
     */
     protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
        [
        	'header' 		=> __('ID'), 
        	'index' 		=> 'entity_id',
        	'name'			=> 'price_product_id',
        	'type' 			=> 'checkbox', 
        	'field_name' 	=> 'price_product_id[]',
        	'width' 		=> '20px'
        ]);
        
        $this->addColumn('name',
        [
            'header' 	=> __('Product Name'),
            'index' 	=> 'name',
        ]);
        
        
        $this->addColumn('sku',
        [
        	'header' 	=> __('SKU'),
        	'index' 	=> 'sku',
        ]);
        
        $this->addColumn('price',
        [
            'header' 	=> __('Price'),
            'index' 	=> 'price',
        	'width' 	=> '60px'
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
     * @param \Magento\Catalog\Model\Product|\Magento\Framework\DataObject $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return null;
    }
    
    /**
     * Set grid URL
     * 
     * @see \Magento\Backend\Block\Widget\Grid::getGridUrl()
     */
    public function getGridUrl()
    {
    	return $this->getUrl('price/index/grid', ['_current' => true]);
    }
}