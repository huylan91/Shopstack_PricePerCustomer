<?php
 
namespace Shopstack\Price\Block\Adminhtml\Edit\Tab\View\Renderer;

/**
 * Adminhtml customers wishlist grid item renderer for name/options cell
 */
class Fixed extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
	/**
	 * @var \Magento\Framework\Pricing\Helper\Data
	 */
	protected $pricingHelper;
	
	/**
	 * Constructor
	 *  
	 * @param \Magento\Backend\Block\Context $context
	 * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
	 * @param array $data
	 */
	public function __construct
	(
		\Magento\Backend\Block\Context $context,
		\Magento\Framework\Pricing\Helper\Data $pricingHelper,
		array $data = []
	)
	{
		parent::__construct($context, $data);
		
		$this->pricingHelper = $pricingHelper;
	}

    /**
     * Renders item product name and its configuration
     *
     * @param \Magento\Catalog\Model\Product\Configuration\Item\ItemInterface|\Magento\Framework\DataObject $item
     * @return string
     */
    public function render(\Magento\Framework\DataObject $item)
    {
        return $this->pricingHelper->currency($item->getPrice());
    }
}
