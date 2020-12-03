<?php

namespace Shopstack\Price\Plugin;


class FinalPrice
{
	
	
	/**
     * @var Config
     */
    protected $priceModel;
	

    /**
     * ProductGetFinalPrice constructor.
     * @param Config $config
     */
    public function __construct(\Shopstack\Price\Model\Price $priceModel)
    {
        $this->priceModel = $priceModel;
	}
	
	
    
    public function afterGetValue(\Magento\Catalog\Pricing\Price\FinalPrice $subject, $result)
    {

		return $this->priceModel->getPrice($subject->getProduct(),$result);

        
    }
}