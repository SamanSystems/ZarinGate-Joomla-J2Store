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
session_start();
$status = $_SESSION['status'];
$Address = $_SESSION['address'];
if($status == 'failed')
{
  ?>
    <script type="text/javascript">
        alert('Transaction Failed!!! \n Please try again...') ;
        var url =   "http://" + "<?php echo $Address; ?>" + "/index.php?option=com_j2store&view=checkout";
        location.href= url;
    </script>
  <?php
}
elseif($status == 'canceled')
{
 ?>
    <script type="text/javascript">
        alert('Transaction is canceled by user...') ;
        var url =   "http://" + "<?php echo $Address; ?>" + "/index.php?option=com_j2store&view=checkout";
        location.href= url;
    </script>
  <?php 
}  
else
{
 ?>
    <script type="text/javascript">
        alert('Invalid transaction...') ;
        var url =   "http://" + "<?php echo $Address; ?>" + "/index.php?option=com_j2store&view=checkout";
        location.href= url;
    </script>
  <?php 
}
session_start(); 
$_SESSION['status'] = '';
$_SESSION['address'] = '';
?>
