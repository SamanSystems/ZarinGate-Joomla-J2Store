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
require_once('lib/nusoap.php');
$MerchantID = JRequest::getVar('merchantId'); 
$Amount = JRequest::getVar('orderpayment_amount');
$orderpayment_id = JRequest::getVar('orderpayment_id');
$session = JFactory::getSession();
$session->set('Amount',$Amount);
$userId = JRequest::getVar('userId');
$db =& JFactory::getDBO();
$query = "select email ,phone_2 from #__j2store_address where user_id = ".$userId;
$db->setQuery($query);
$userData = $db->loadObject(); 
$orderID = JRequest::getVar('order_id');
$Description = 'پرداخت فاکتور شماره: '.$orderID.'    |     تلفن: '.$userData -> phone_2.'    |    ایمیل خریدار: '.$userData -> email; 
$Email = $userData -> email;
$Mobile =$userData -> phone_2;
$Address = JRequest::getVar('Address');
$Addnew = explode('//',$Address);
if (strlen($Addnew[0]) != 0)
   $Address =   $Addnew[1];
$CallbackURL = JURI::root()."verify.php?Address=".$Address."&orderId=".$orderID."&orderpayment_id=".$orderpayment_id."&merchant=".$MerchantID."&amount=".$Amount;  // Required
$client = new nusoap_client('https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl'); 
$client->soap_defencoding = 'UTF-8';
$result = $client->call('PaymentRequest', array(
                                            array(
                                                    'MerchantID'     => $MerchantID,
                                                    'Amount'         => $Amount,
                                                    'Description'     => $Description,
                                                    'Email'         => $Email,
                                                    'Mobile'         => $Mobile,
                                                    'CallbackURL'     => $CallbackURL
                                                )
                                            )
);  
if($result['Status'] == 100)
{
    Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result['Authority'].'/ZarinGate');
} else {
    echo'ERR: '.$result['Status'];
}
?>
