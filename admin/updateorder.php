<?php
session_start();

include_once 'include/config.php';
if(strlen($_SESSION['alogin'])==0)
  { 
header('location:index.php');
}
else{
$oid=intval($_GET['oid']);
if(isset($_POST['submit2'])){
$status=$_POST['status'];
$remark=$_POST['remark'];//space char

$query=mysqli_query($con,"insert into ordertrackhistory(orderId,status,remark) values('$oid','$status','$remark')");
$sql=mysqli_query($con,"update orders set orderStatus='$status' where id='$oid'");
echo "<script>alert('Order updated sucessfully...');</script>";
//}
}

 ?>
 
 <!DOCTYPE html>
 <html lang="en">
 <head>
  
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin| Change Password</title>
   <link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
   <link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
   <link type="text/css" href="css/theme.css" rel="stylesheet">
   <link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
   <link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
   <script type="text/javascript">
 function valid()
 {
 if(document.chngpwd.password.value=="")
 {
 alert("Current Password Filed is Empty !!");
 document.chngpwd.password.focus();
 return false;
 }
 else if(document.chngpwd.newpassword.value=="")
 {
 alert("New Password Filed is Empty !!");
 document.chngpwd.newpassword.focus();
 return false;
 }
 else if(document.chngpwd.confirmpassword.value=="")
 {
 alert("Confirm Password Filed is Empty !!");
 document.chngpwd.confirmpassword.focus();
 return false;
 }
 else if(document.chngpwd.newpassword.value!= document.chngpwd.confirmpassword.value)
 {
 alert("Password and Confirm Password Field do not match  !!");
 document.chngpwd.confirmpassword.focus();
 return false;
 }
 return true;
 }
 </script>
 </head>
 <body>
 <?php include('include/header.php');?>
 
   <div class="wrapper">
     <div class="container">
       <div class="row">
 <?php include('include/sidebar.php');?>				
       <div class="span9">
           <div class="content">
 
             <div class="module">
               <div class="module-head">
                 <h3>Delivery Action</h3>
               </div>
               <div style="margin-left:50px;">
 <form name="updateticket" id="updateticket" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0">

    <tr height="50">
      <td colspan="2" class="fontkink2" style="padding-left:0px;"><div class="fontpink2"> <b>Update Order !</b></div></td>
      
    </tr>
    <tr height="30">
      <td  class="fontkink1"><b>order Id:</b></td>
      <td  class="fontkink"><?php echo $oid;?></td>
    </tr>
    <?php 
$ret = mysqli_query($con,"SELECT * FROM ordertrackhistory WHERE orderId='$oid'");
     while($row=mysqli_fetch_array($ret))
      {
     ?>
		
    
    
      <tr height="20">
      <td class="fontkink1" ><b>At Date:</b></td>
      <td  class="fontkink"><?php echo $row['postingDate'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Status:</b></td>
      <td  class="fontkink"><?php echo $row['status'];?></td>
    </tr>
     <tr height="20">
      <td  class="fontkink1"><b>Remark:</b></td>
      <td  class="fontkink"><?php echo $row['remark'];?></td>
    </tr>

   
    <tr>
      <td colspan="2"><hr /></td>
    </tr>
   <?php } ?>
   <?php 
$st='Delivered';
   $rt = mysqli_query($con,"SELECT * FROM orders WHERE id='$oid'");
     while($num=mysqli_fetch_array($rt))
     {
     $currrentSt=$num['orderStatus'];
   }
     if($st==$currrentSt)
     { ?>
   <tr><td colspan="2"><b>
      Product Delivered </b></td>
   <?php }else  {
      ?>
   
    <tr height="50">
      <td class="fontkink1">Status: </td>
      <td  class="fontkink"><span class="fontkink1" >
        <select name="status" class="fontkink" required="required" >
          <option value="">Select Status</option>
                 <option value="in Process">In Process</option>
                  <option value="Delivered">Delivered</option>
        </select>
        </span></td>
    </tr>

     <tr style=''>
      <td class="fontkink1" >Remark:</td>
      <td class="fontkink" align="justify" ><span class="fontkink">
        <textarea cols="50" rows="7" name="remark"  required="required" ></textarea>
        </span></td>
    </tr>
    <tr>
      <td class="fontkink1">&nbsp;</td>
      <td  >&nbsp;</td>
    </tr>
    <tr>
      <td class="fontkink">       </td>
      <td class="fontkink"> <input type="submit" name="submit2"  value="update"   size="40" style="cursor: pointer;" /> &nbsp;&nbsp;   
      <input name="Submit2" type="submit" class="txtbox4" value="Close this Window " onClick="return f2();" style="cursor: pointer;"  /></td>
    </tr>
<?php } ?>
</table>
 </form>
</div>

 
             
             
           </div><!--/.content-->
         </div><!--/.span9-->
       </div>
     </div><!--/.container-->
   </div><!--/.wrapper-->
 
 <?php include('include/footer.php');?>
 
   <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
   <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
   <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
   <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
 </body>
 <?php } ?>