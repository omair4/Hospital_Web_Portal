<?php
	
	$db_user="dbadmin";
		$db_pass="1234";
		$db_sid = "(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST=Turab-PC)(PORT = 1521)) )(CONNECT_DATA = (SID = orcl) ) )";

		$con=oci_connect($db_user, $db_pass, $db_sid);
		if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      	} 


	$q="select  h_".$_POST['resource-sel']."_num from system.hospital 
				where h_id=".$_POST['row-id'];
			
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			$new_num=$row[0]+$_POST['resource-num'];

			$q="update system.hospital set h_".$_POST['resource-sel']."_num=".$new_num."
				where h_id=".$_POST['row-id'];
			
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$r=oci_commit($con);

	function goback()
{
	header("Location: {$_SERVER['HTTP_REFERER']}");
	exit;
}

goback();

?>