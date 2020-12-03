<?php
namespace Shopstack\Price\Controller\Adminhtml;

use Magento\Customer\Controller\RegistryConstants;

abstract class Index extends \Magento\Backend\App\Action
{
	/**
	 * @var \Magento\Framework\View\Result\LayoutFactory
	 */
	protected $resultLayoutFactory = null;
	
    public function __construct
    (
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) 
    {
    	$this->_coreRegistry 		= $coreRegistry;
        $this->resultLayoutFactory 	= $resultLayoutFactory;
        
        parent::__construct($context);
    }

    /**
     * Customer initialization
     *
     * @return string customer id
     */
    protected function initCurrentCustomer()
    {
        $customerId = (int) $this->getRequest()->getParam('id');

        if ($customerId) 
        {
            $this->_coreRegistry->register(RegistryConstants::CURRENT_CUSTOMER_ID, $customerId);
        }

        return $customerId;
    }

    /**
     * Prepare customer default title
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return void
     */
    protected function prepareDefaultCustomerTitle(\Magento\Backend\Model\View\Result\Page $resultPage)
    {
        $resultPage->getConfig()->getTitle()->prepend(__('Customers'));
    }

    /**
     * Add errors messages to session.
     *
     * @param array|string $messages
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedLocalVariable)
     */
    protected function _addSessionErrorMessages($messages)
    {
        $messages = (array) $messages;
        
        $session = $this->_getSession();

        $callback = function ($error) use ($session) 
        {
            if (!$error instanceof Error) 
            {
                $error = new Error($error);
            }
            
            $this->messageManager->addMessage($error);
        };
        
        array_walk_recursive($messages, $callback);
    }

    /**
     * Customer access rights checking
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magento_Customer::manage');
    }
}
