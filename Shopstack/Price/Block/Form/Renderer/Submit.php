<?php
namespace Shopstack\Price\Block\Form\Renderer;

use Magento\Backend\Block\Widget;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;
use Magento\Backend\Block\Template;


class Submit extends Widget implements RendererInterface
{
	public function __construct
	(
		\Magento\Backend\Block\Template\Context $context, array $data = []
	)
	{
		parent::_construct($context);
	}
    /**
     * Render form element as HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
    	return $this->getLayout()->createBlock('Shopstack\Price\Block\Button')->toHtml();
    }
}
