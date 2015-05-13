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


defined('_JEXEC') or die('Restricted access'); 
$user =& JFactory::getUser();
$userId =    $user -> id;
?>

<form action="<?php echo JRoute::_( JURI::root().'plugins/j2store/payment_zarinpalzg/payment_zarinpalzg/tmpl/pay.php'); ?>" method="post" name="adminForm" enctype="multipart/form-data">

	<br />
    <div class="note">
        <p>
             <strong><?php echo JText::_($vars->onbeforepayment_text); ?></strong>
        </p>
    </div>
   
    <input type="submit" class="j2store_cart_button btn btn-primary" value="<?php echo JText::_($vars->button_text); ?>" />
    <input type='hidden' name='order_id' value='<?php echo @$vars->order_id; ?>'>
    <input type='hidden' name='orderpayment_id' value='<?php echo @$vars->orderpayment_id; ?>'>
    <input type='hidden' name='orderpayment_type' value='payment_zarinpalzg'>
    <input type='hidden' name='orderpayment_amount' value='<?php echo @$vars->orderpayment_amount; ?>'>
    <input type='hidden' name='merchantId' value='<?php echo @$vars->MerchantID; ?>'>
    <input type='hidden' name='Address' value='<?php echo @$vars->Address; ?>'>
    <input type='hidden' name='userId' value='<?php echo $userId; ?>'>
    <input type='hidden' name='task' value='confirmPayment'>
</form>