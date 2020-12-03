<?php
namespace Shopstack\Price\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Paypal\Test\Unit\Model\ProTest;

class Price implements ObserverInterface
{
	/**
	 * @var \Shopstack\Price\Model\Price
	 */
	protected $priceModel = null;
	
	/**
	 * @var \Magento\Framework\App\State
	 */
	protected $state;
	
	/**
	 * @var \Magento\Customer\Api\CustomerRepositoryInterfac
	 */
	protected $customerRepository;
	
	/**
	 * @var \Magento\Backend\Model\Session\Quote
	 */
	protected $sessionQuote;
	
	/**
	 * @var \Magento\Catalog\Model\ProductFactory
	 */
	protected $productFactory;
	
	/**
	 * Constructor 
	 * 
	 * @param \Shopstack\Price\Model\Price $price
	 * @param \Magento\Framework\App\State $state
	 */
	public function __construct
	(
		\Shopstack\Price\Model\Price $price,
		\Magento\Framework\App\State $state,
		\Magento\Customer\Api\CustomerRepositoryInterface $customerRepository,
		\Magento\Backend\Model\Session\Quote $sessionQuote,
		\Magento\Catalog\Model\ProductFactory $productFactory
	)
	{
		/**
		 * Set price model 
		 * 
		 * @var \Shopstack\Price\Model\Price
		 */
		$this->priceModel = $price;
		
		/**
		 * Set state 
		 * 
		 * @var \Magento\Framework\App\State
		 */
		$this->state = $state;
		
		/**
		 * Set customer repository 
		 * 
		 * @var \Magento\Customer\Api\CustomerRepositoryInterfac
		 */
		$this->customerRepository = $customerRepository;
		
		/**
		 * Set session quote
		 * 
		 * @var \Magento\Backend\Model\Session\Quote
		 */
		$this->sessionQuote = $sessionQuote;
		
		/**
		 * Set product factory 
		 * 
		 * @var \Magento\Catalog\Model\ProductFactory
		 */
		$this->productFactory = $productFactory;
	}
	
	/**
	 * Execute observer 
	 * 
	 * @see \Magento\Framework\Event\ObserverInterface::execute()
	 */
	public function execute(EventObserver $observer)
	{
		
		$observer->getProduct()->setFinalPrice
		(
			$this->priceModel->getPrice
			(
				$observer->getProduct()
			)
		);
		
		return true;	
	}

}
