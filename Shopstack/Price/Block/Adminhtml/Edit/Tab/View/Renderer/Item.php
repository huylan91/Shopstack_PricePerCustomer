<?php
 
namespace Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Renderer;

use Magento\Catalog\Model\Product;

/**
 * Adminhtml customers wishlist grid item renderer for name/options cell
 */
class Item extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
	/**
	 * @var \Magento\Catalog\Api\ProductRepositoryInterface
	 */
	protected $productRepository;
	

	
	/**
	 * Constructor
	 * 
	 * @param \Magento\Backend\Block\Context $context
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Backend\Block\Context $context,
		\Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
		array $data = []
	)
	{
		parent::__construct($context, $data);
		
		/**
		 * Set product repository
		 *
		 * @var \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
		 */
		$this->productRepository = $productRepository;
		

	}
	
    /**
     * Renders item product name and its configuration
     *
     * @param \Magento\Catalog\Model\Product\Configuration\Item\ItemInterface|\Magento\Framework\DataObject $item
     * @return string
     */
    public function render(\Magento\Framework\DataObject $item)
    {
    	return $this->productRepository->getById($item->getPriceProductId())->getName();
    }
}
