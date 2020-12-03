<?php 
namespace Shopstack\Price\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

    	$sql = array();

		$sql[] = "SET foreign_key_checks = 0";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS " . $installer->getTable('ss_price') . " (price_id int(6) NOT NULL AUTO_INCREMENT,price_customer_id int(6) NOT NULL DEFAULT '0',price_product_id int(6) NOT NULL DEFAULT '0',price decimal(8,2) NOT NULL DEFAULT '0.00',price_valid_from timestamp NULL DEFAULT NULL,price_valid_to timestamp NULL DEFAULT NULL,PRIMARY KEY (price_id)) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8";
		
		
		$sql[] = "SET foreign_key_checks = 1";
		
		foreach ($sql as $query)
		{
			$installer->run($query);
		}
		
        $installer->endSetup();
    }
}


