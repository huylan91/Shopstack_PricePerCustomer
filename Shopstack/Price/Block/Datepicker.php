<?php
namespace Shopstack\Price\Block;

class Datepicker extends \Magento\Framework\Data\Form\Element\Date
{
	public function getAfterElementHtml()
	{
		$calendarYearsRange = $this->getYearsRange();
		
		return '<script type="text/javascript">
		            require(["jquery", "mage/calendar"], function($)
		            {
		                    $("#' . $this->getId() . '").calendar(
		                    {
		                        showsTime: 		'  .($this->getTimeFormat() ? 'true' : 'false') .', ' . ($this->getTimeFormat() ? 'timeFormat: "' . $this->getTimeFormat() . '",' : '') . '
		                        dateFormat: 	"' . $this->getDateFormat() . '",
		                        buttonImage: 	"' . $this->getImage() . '",' . ($calendarYearsRange ? 'yearRange: "' . $calendarYearsRange . '",' : '') . ' buttonText: "' . (string) new \Magento\Framework\Phrase('Select Date') . '"
		                    })
		            });
            	</script>';
	}
}