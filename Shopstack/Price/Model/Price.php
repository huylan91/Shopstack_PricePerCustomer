<?php
namespace Shopstack\Price\Model;

use Magento\Framework\Registry;

class Price
{
	
	
	/**
	 * Include tax in price calculation 
	 * 
	 * @var Boolean
	 */
	const TAX = false;
	
	/**
	 * \Shopstack\Price\Helper\Data
	 */
	protected $helper;
	
	/**
	 * Customer session
	 *
	 * @var \Magento\Customer\Model\Session
	 */
	protected $customerSession = null;
	
	/**
	 * @var \Shopstack\Price\Model\ResourceModel\Item\CollectionFactory
	 */
	protected $collectionFactory = null;
	
	
	
	/**
	 * @var \Magento\Catalog\Helper\Data
	 */
	protected $catalogData = null;
	
	/**
	 * @var \Magento\Framework\App\Http\Context
	 */
	protected $httpContext = null;
	
	/**
	 * @var \Magento\Framework\Registry
	 */
	protected $registry = null;
	
	
	/**
	 * @var \Magento\Framework\App\Config\ScopeConfigInterface
	 */
	protected $scopeConfig;
	
	/**
	 * @var \Magento\Tax\Api\TaxCalculationInterface
	 */
	protected $taxCalculation;
	
	/**
	 * @var \Magento\Catalog\Api\ProductRepositoryInterface
	 */
	protected $productRepository;
	
	/**
	 * Constructor 
	 * 
	 * @param \Magento\Framework\Pricing\Adjustment\CalculatorInterface $calculator
	 * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
	 * @param \Magento\Customer\Model\Session $session
	 * @param \Shopstack\Price\Model\ResourceModel\Item\CollectionFactory $collectionFactory
	 * @param \Shopstack\Price\Helper\Data $helper
	 * @param \Magento\Catalog\Helper\Data $catalogData
	 * @param \Magento\Framework\App\Http\Context $httpContext
	 * @param \Magento\Framework\Registry $registry
	 * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
	 */
	public function __construct
	(
		\Magento\Framework\Pricing\Adjustment\CalculatorInterface $calculator,
		\Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
		\Magento\Customer\Model\Session $customerSession,
		\Shopstack\Price\Model\ResourceModel\Item\CollectionFactory $collectionFactory,
		\Shopstack\Price\Helper\Data $helper,
		\Magento\Catalog\Helper\Data $catalogData,
		\Magento\Framework\App\Http\Context $httpContext,
		\Magento\Framework\Registry $registry,
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository
	)
	{
		/**
		 * Set helper 
		 * 
		 * @var \Shopstack\Price\Helper\Data $helper
		 */
		$this->helper = $helper;
		
		/**
		 * Set customerSession 
		 * 
		 * @var \Magento\Customer\Model\Session $customerSession
		 */
		$this->customerSession = $customerSession;
		
		/**
		 * Set item collection factory 
		 * 
		 * @var \Shopstack\Price\Model\ResourceModel\Item\CollectionFactory $collectionFactory
		 */
		$this->collectionFactory = $collectionFactory;
		
		
		/**
		 * Set catalog helper data 
		 * 
		 * @var \Magento\Catalog\Helper\Data $catalogData
		 */
		$this->catalogData = $catalogData;
		
		/**
		 * Set HTTP context 
		 * 
		 * @var \Magento\Framework\App\Http\Context $httpContext
		 */
		$this->httpContext = $httpContext;
		
		/**
		 * Set registry 
		 * 
		 * @var \Magento\Framework\Registry $registry
		 */
		$this->registry	= $registry;
		
		
		/**
		 * Set product repository 
		 * 
		 * @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
		 */
		$this->productRepository = $productRepository;

	}

	/**
	 * Get customer id 
	 * 
	 * @return number
	 */
	public function getCustomerId()
	{
		return $this->helper->getCustomerId();
	}
	
	/**
	 * Get Custom price 
	 * 
	 * @param \Magento\Framework\Pricing\SaleableInterface $product
	 * @param number $final_price
	 * @param number $adjustment
	 */
	public function getPrice(\Magento\Framework\Pricing\SaleableInterface $product, $final_price = null, $adjustment = 0, $tax = true)
	{
		/**
		 * Skip processing for bundled product(s)
		 */
		if (\Magento\Catalog\Model\Product\Type::TYPE_BUNDLE == $product->getTypeId())
		{
			return 0;
		}

		/**
		 * Get original price
		 *
		 * @var float
		 */
		$value = (float) $this->catalogData->getTaxPrice($product, $final_price,self::TAX,null,null,null, null,null,false);
		
		
		
		
		/**
		 * Get Adjustment
		 */
		if ($adjustment)
		{
			$value = $adjustment;
		}
		if (!$this->helper->isLoggedIn())
		{
			return $value;
		}
		
		/**
		 * Retrieve customer specific price
		 */
		
		
		$prices = [];
	
		$collection = $this->collectionFactory->create()->addFieldToFilter('price_customer_id',$this->getCustomerId())->addFieldToFilter('price_product_id', $product->getId());
		
		foreach($collection as $item)
		{
		
			$prices[$item->getPriceId()] = array
			(
				'price_product_id'				=> (int) $item->getPriceProductId(),
				'price'							=> 		 $item->getPrice(),
				'price_valid_from'				=> 		 $item->getPriceValidFrom(),
				'price_valid_to'				=> 		 $item->getPriceValidTo()
			);
		}	
		
		
		if ($prices)
		{
			
			/* Check whether date range is specified */
			$date = new \DateTime
			(
				date('Y-m-d 00:00:00')
			);
			
			$prices = array_filter($prices, function($price) use ($date)
			{
				
				if ('' !== $price['price_valid_from'] || '' !== $price['price_valid_to'])
				{
					
					if ($price['price_valid_from'] && $price['price_valid_to'])
					{
						if ($date < new \DateTime($price['price_valid_from']) || $date > new \DateTime($price['price_valid_to']))
						{
							return false;
						}
					}
					elseif ($price['price_valid_from'])
					{
						if ($date < new \DateTime($price['price_valid_from']))
						{
							return false;
						}
					}
					elseif ($price['price_valid_to'])
					{
						if ($date > new \DateTime($price['price_valid_to']))
						{
							return false;
						}
					}
				}
				
				return true;
			});
			
			
			if (!$prices)
			{
				return $value;	
			}
			
			
			/**
			 * Date based prices to match higher priority
			 */
			usort($prices, function($a, $b)
			{
				if (($a['price_valid_from'] || $a['price_valid_to']) && (!$b['price_valid_from'] && !$b['price_valid_to'])) 
				{
					return 1;
				}
			});
			
			/**
			 * Presume current price as prime price
			 * 
			 * @var float $prime
			 */
			
			$prime = (float) $value;
			
			foreach ($prices as $price)
			{
				/**
				 * Get discounted price 
				 * 
				 * @var float $current
				 */
				
				
				if ($price['price'] < $prime)
				{
					$prime = $price['price'];
				}
			}

			if ($prime < $value)
			{
				$value = $prime;
			}
		}
		return $value ;
	}
	
	
	
	/**
	 * Get default product price
	 * 
	 * @param \Magento\Catalog\Model\Product $product
	 * @param int $quantity
	 * @param number $value
	 * @return number
	 */
	private function getDefaultPrice(\Magento\Catalog\Model\Product $product, $quantity = null, $value = 0)
	{
		return $value;
	}
	
	
}