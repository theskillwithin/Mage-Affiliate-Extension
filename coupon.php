<?php
 
require_once('../app/Mage.php'); //Path to Magento
umask(0);
Mage::app();

/* echo "it's worked!";
 
$_layout  = Mage::getSingleton('core/layout');
$_block   = $_layout->createBlock('catalog/navigation')->setTemplate('catalog/navigation/left.phtml');
 
echo $_block->toHtml(); */


$coupon = Mage::getModel('salesrule/coupon');
$coupon->load('family949', 'code');

if($coupon->getId()){
    /* @var $resourceCouponUsage Mage_SalesRule_Model_Mysql4_Coupon_Usage */
    $resourceCouponUsage = Mage::getResourceModel('salesrule/coupon_usage');
    $read = $resourceCouponUsage->getReadConnection();
    $select = $read->select()
                ->from($resourceCouponUsage->getMainTable())
                ->where('coupon_id = ?', $coupon->getId());

    $data = $read->fetchAll($select);
    print_r($data);
    foreach($data as $couponUsage){
        $customer = Mage::getModel('customer/customer')->load($couponUsage['customer_id']);
        echo $customer->getName();
    }
}


?>