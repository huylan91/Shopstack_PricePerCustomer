<?php
namespace Shopstack\Price\Block;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
	protected $locale = null;
	
	protected $request = null;
	
	/**
	 * @var \Magento\Framework\Data\FormFactory
	 */
	protected $formFactory;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Backend\Block\Template\Context $context
	 * @param \Magento\Framework\Registry $registry
	 * @param \Magento\Framework\Data\FormFactory $formFactory
	 * @param array $data
	 */
    public function __construct
    (
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = []
    ) 
    {  
        parent::__construct($context, $registry, $formFactory, $data);
        
        $this->locale = $context->getLocaleDate();
        
        /**
		 * @var \Magento\Framework\App\RequestInterface
		 */
        $this->request = $context->getRequest();
    }

    /**
     * Prepare form for render
     *
     * @return void
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $form = $this->_formFactory->create();

        $fieldset = $form->addFieldset('base_fieldset', 
        [
        	'legend' => __('Add price for Customer')
        ]);
        

        $fieldset->addField
        (
        	'customer_id', 'hidden',
        	[
        		'name' 		=> 'customer_id',
        		'label' 	=> __('Customer'),
        		'title' 	=> __('Customer'),
        		'value'		=> (int) $this->request->getParam('id')
        	]
        );

		$fieldset->addType('products', 'Shopstack\Price\Block\Picker');
        
        $fieldset->addField
        (
            'price_product_id', 'products',
            [
                'name' 		=> 'price_product_id',
                'label' 	=> __('Select product(s)'),
                'title' 	=> __('Select product(s)'),
            	'note'		=> __('You can select 1 or more products at once.'),
                'required' 	=> false
            ]
        );

        $fieldset->addField
        (
        	'price_fixed', 'text',
        	[
        		'name' 		=> 'price_fixed',
        		'label' 	=> __('Fixed price'),
        		'title' 	=> __('Fixed price'),
        		'note' 		=> __('Set fixed price'),
        		'required' 	=> false
        	]
        );

        try 
        {
        	$fieldset->addType('datepicker', 'Shopstack\Price\Block\Datepicker');
        	
	        $fieldset->addField
	        (
	        	'price_valid_from', 'datepicker',
	        	[
	        		'name' 			=> 'price_valid_from',
	        		'label' 		=> __('Valid from'),
	        		'title' 		=> __('Valid from'),
	        		'date_format' 	=> $this->locale->getDateFormat(\IntlDateFormatter::SHORT),
	        		'input_format' 	=> \Magento\Framework\Stdlib\DateTime::DATE_INTERNAL_FORMAT,
	        		'note'			=> __('Apply discount from date'),
	        		'required' 		=> false
	        	]
	        );
	        
	        $fieldset->addField
	        (
	        	'price_valid_to', 'datepicker',
	        	[
	        		'name' 			=> 'price_valid_to',
	        		'label' 		=> __('Valid to'),
	        		'title' 		=> __('Valid to'),
	        		'date_format' 	=> $this->locale->getDateFormat(\IntlDateFormatter::SHORT),
	        		'input_format' 	=> \Magento\Framework\Stdlib\DateTime::DATE_INTERNAL_FORMAT,
	        		'note'			=> __('Apply discount to date'),
	        		'required' 		=> false
	        	]
	        );
        }
        catch (\Exception $e)
        {
        	
        }
        
        $submit = $fieldset->addField
        (
        	'submitter', 'text',
        	[
        		'name' => 'submitter'
        	]
        );
        
        $submit->setRenderer
        (
        	$this->getLayout()->createBlock('Shopstack\Price\Block\Form\Renderer\Submit')
        );
        
        $form->setUseContainer(true);
        $form->setId('edit_form');
        $form->setAction($this->getUrl('customer/*/save'));
        $form->setMethod('post');
        $this->setForm($form);
    }
}