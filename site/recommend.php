<?php
	
	session_start();
	$db_user=$_SESSION['u_name'];
		$db_pass=$_SESSION['pass'];
		$db_sid=$_SESSION['sid'];
		
		//echo($db_user." ".$db_pass);
		$con=oci_connect($db_user, $db_pass, $db_sid);
		if(!$con) {
   				$e=oci_error();
      			echo $e; 
      			die('\ncould no connect');
      	} 

    if(isset($_POST['vent-btn'])){
    	$type="ventilator";
    }
    if(isset($_POST['oxy-btn'])){
    	$type="oxygen";
    }
    $P_ID=$_POST['recommend-PID'];
    $H_ID=$_SESSION['H_ID'];
    $D_ID=$_SESSION['D_ID'];

    if($type=="ventilator"){
    	echo "ventilator";
   		$q="insert into system.ventilators (V_ID,P_ID,D_ID,H_ID) values (
   			".rand().","
   			.$P_ID.","
   			.$D_ID.","
   			.$H_ID.")";
    }
    if($type=="oxygen"){
    	echo "oxygen";
    	$q="insert into system.oxygen (O_ID,P_ID,D_ID,H_ID) values (
   			".rand().","
   			.$P_ID.","
   			.$D_ID.","
   			.$H_ID.")";
    }
    echo $q;
    $query_id=oci_parse($con, $q);
    $r=oci_execute($query_id);
    $r=oci_commit($con);

 

  header("Location: doctor-logged.php");
	exit();

?>