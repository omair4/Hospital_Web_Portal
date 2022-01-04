<?php
	$current_pwd=$_POST['old-password'];
	$new_pwd=$_POST['new-password'];
	$db_user="dbadmin";
		$db_pass=$current_pwd;
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST=Turab-PC)(PORT = 1521)) )(CONNECT_DATA = (SID = orcl) ) )";

		$con=oci_connect($db_user, $db_pass, $db_sid);
		if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      	} 


	$r=oci_password_change($con, $db_user, $current_pwd, $new_pwd);
	
		function goback()
{
	header("Location: site.html");
	exit;
}

goback();

?>