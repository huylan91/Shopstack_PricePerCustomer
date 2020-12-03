<?php
namespace Shopstack\Price\Helper;

use Magento\Store\Model\Store;
use Magento\Framework\Registry;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
		
	/**
	 * @var \Magento\Customer\Model\Session
	 */
	protected $session = null;
	
	/**
	 * @var \Magento\Framework\Registry
	 */
	protected $registry = null;
	
	/**
	 * @var \Magento\Framework\App\Http\Context
	 */
	protected $httpContext;
	
	/**
	 * @var \Magento\Customer\Model\CustomerFactory
	 */
	protected $customerFactory;
	
	/**
	 * @var Magento\Customer\Model\Customer
	 */
	protected $customer = null;
	
	/**
	 * @var \Magento\Framework\App\State
	 */
	protected $state;
	
	/**
	 * @var \Magento\Framework\App\Request\Http
	 */
	protected $request;
	
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\App\Helper\Context $context
	 * @param \Magento\Framework\App\Http\Context $httpContext
	 * @param \Magento\Framework\Registry $registry
	 * @param \Magento\Customer\Model\Session $session
	 * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\App\Http\Context $httpContext,
		\Magento\Framework\Registry $registry,
		\Magento\Customer\Model\Session $session,
		\Magento\Customer\Model\CustomerFactory $customerFactory, 
		\Magento\Framework\App\State $state,
		array $data = []
	)
	{
		parent::__construct($context);
		
		/**
		 * Set Request 
		 * 
		 * @var \Shopstack\Price\Helper\Data $request
		 */
		$this->request = $context->getRequest();
		
		/**
		 * Set session 
		 * 
		 * @var \Magento\Customer\Model\Session
		 */
		$this->session = $session;
		
		/**
		 * Set HTTP context 
		 * 
		 * @var \Magento\Framework\App\Http\Context
		 */
		$this->httpContext = $httpContext;
		
		/**
		 * Set registry 
		 * 
		 * @var \Magento\Framework\Registry
		 */
		$this->registry = $registry;
		
		/**
		 * Set customer repository 
		 * 
		 * @var \Shopstack\Price\Helper\Data $customerRepositoryInterface
		 */
		$this->customerFactory = $customerFactory;
		
		/**
		 * Set state 
		 * 
		 * @var \Magento\Framework\App\State $state
		 */
		$this->state = $state;
		
	}
	
	
	/**
	 * Check if customer is logged in
	 */
	public function isLoggedIn()
	{
		if ($this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH))
		{
			return true;
		}
		elseif ($this->session->isLoggedIn())
		{
			return true;
		}
		
		return false;
	}
	
	
	
	public function getCustomerId()
	{
		return $this->httpContext->getValue('customer_id');
	}
	
	
	public function getState()
	{
		return $this->state;
	}
	
}
