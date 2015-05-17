<?php
/*------------------------------------------------------------------------
# com_j2store - J2Store
# ------------------------------------------------------------------------
# author    Hashem Hashemi -  http://www.joomina.ir
# copyright Copyright (C) 2012 Weblogicxindia.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomina.ir
# Technical Support:  Forum - http://forum.joomina.ir/
-------------------------------------------------------------------------*/
define('_JEXEC',1);
define('JPATH_BASE',realpath(dirname(__FILE__).'/../../../../..'));
define('DS',DIRECTORY_SEPARATOR); 
require_once(JPATH_BASE.DS.'includes'.DS.'defines.php');
require_once(JPATH_BASE.DS.'includes'.DS.'framework.php');
require_once(JPATH_BASE.DS.'libraries'.DS.'joomla'.DS.'methods.php');
require_once('lib/nusoap.php');
$MerchantID = $_GET['merchant'];
$Amount = $_GET['amount'];
$Amount = intval($Amount);
$Authority = $_GET['Authority'];
$Address = $_GET['Address'];
$orderId = $_GET['orderId']; 
$db =& JFactory::getDBO();
$query = "select orderpayment_amount,transaction_status,order_state_id  from #__j2store_orders where order_id = ". $orderId;
$db->setQuery($query);
$orderData = $db->loadObject(); 
if($_GET['Status'] == 'OK' && $orderData->orderpayment_amount == $Amount && $orderData->transaction_status == 'ناقص' && $orderData->order_state_id == 5) {
    $client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
    $client->soap_defencoding = 'UTF-8';
    $result = $client->call('PaymentVerification', array(
                                                        array(
                                                                'MerchantID'     => $MerchantID,
                                                                'Authority'      => $Authority,
                                                                'Amount'          => $Amount
                                                            )
                                                        )
    );  
    if($result['Status'] == 100){
        //die('http://'.$Address.'/index.php?option=com_j2store&view=checkout');
        ?>
        <form action="<?php echo 'http://'.$Address.'/index.php?option=com_j2store&view=checkout'; ?>" method="post" name="adminForm" id="DoPayment" enctype="multipart/form-data">
            <input type='hidden' name='order_id' value='<?php echo JRequest::getCmd('orderId'); ?>'>
            <input type='hidden' name='orderpayment_id' value='<?php echo JRequest::getCmd('orderpayment_id'); ?>'>
            <input type='hidden' name='orderpayment_type' value='payment_zarinpalzg'>
            <input type='hidden' name='orderpayment_amount' value='<?php echo $Amount; ?>'>
            <input type='hidden' name='task' value='confirmPayment'>
        </form>
        <script>document.getElementById('DoPayment').submit();</script>
        <?php  
    } else {
        //echo 'Transation failed. Status:'. $result['Status'];
        session_start();        
        $_SESSION['status'] = 'failed';
        $_SESSION['address'] = $Address;
        $link = "Location:".  $Address . "/plugins/j2store/payment_zarinpalzg/payment_zarinpalzg/tmpl/status.php";
        header($link );      
    }
} else {  
        session_start();      
        if($orderData->orderpayment_amount != $Amount && $orderData->transaction_status != 'ناقص' && $orderData->order_state_id != 5) {
        $_SESSION['status'] = 'failed';}
        else{
        $_SESSION['status'] = 'canceled';
       }
        $_SESSION['address'] = $Address;
        $link = "Location:".  $Address . "/plugins/j2store/payment_zarinpalzg/payment_zarinpalzg/tmpl/status.php";
        header($link );     
}
?>
