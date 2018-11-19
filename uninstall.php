<?php
require_once 'app/Mage.php';
Mage::app('default');

$installer =  new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();


$installer->run("DELETE FROM {$installer->getTable('core/resource')} WHERE code = 'fox_news_setup'" );
$installer->run("DROP TABLE  IF EXISTS `" .   $installer->getTable('fox_news') . "`");
$installer->run("DROP TABLE  IF EXISTS `" .   $installer->getTable('fox_news_items') . "`");

 $installer->endSetup();
echo 'end';