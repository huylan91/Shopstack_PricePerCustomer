<?php
namespace Shopstack\Price\Block;

use Magento\Framework\Data\Form\Element\Select;

class Picker extends \Magento\Framework\Data\Form\Element\Select
{
	/**
	 * @var \Magento\Framework\View\Element\BlockFactory
	 */
	protected $layout;
	
	protected $formKey;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\Data\Form\Element\Factory $factoryElement
	 * @param \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection
	 * @param \Magento\Framework\Escaper $escaper
	 * @param \Magento\Framework\View\Element\BlockFactory $blockFactory
	 * @param unknown $data
	 */
    public function __construct
    (
        \Magento\Framework\Data\Form\Element\Factory $factoryElement,
        \Magento\Framework\Data\Form\Element\CollectionFactory $factoryCollection,
        \Magento\Framework\Escaper $escaper,
    	\Magento\Framework\View\LayoutInterface $layout,
    	\Magento\Framework\Data\Form\FormKey $formKey,
        $data = []
    ) 
    {
        parent::__construct($factoryElement, $factoryCollection, $escaper, $data);
        
        $this->layout = $layout;
        $this->formKey = $formKey;
    }
    
    /**
     * Prepares content block
     *
     * @return string
     */
    public function getContentHtml()
    {
    	return $this->layout->createBlock('Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Grid')->setId($this->getHtmlId() . '_content')->setElement($this)->toHtml();
    }
    
    public function getElementHtml()
    {
    	return $this->getContentHtml();
    }
}