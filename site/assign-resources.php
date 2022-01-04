<?php
	session_start(); 
	//$con=$_SESSION['con'];
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

    //update patient
    //delete from ventilators or oxygen
    //minus from hospital

    $P_ID=$_POST['add-PID'];
    $H_ID=$_POST['add-HID'];
    if(isset($_POST['oxygen-add'])){
    	$q1="update system.patient
    		set p_oxygen='yes'
    		where p_id=".$P_ID;
    	$q2="delete from system.oxygen
    		where p_id=".$P_ID;
    	$q3="select h_oxygen_num from system.hospital
    		 where h_id=".$H_ID;
    	$query=oci_parse($con, $q3);
    	$r=oci_execute($query);
    	$row=oci_fetch_array($query,OCI_BOTH+OCI_RETURN_NULLS);
    	$oxy_num=$row[0];
    	$oxy_num=$oxy_num - 1;
    	echo "oxy:".$oxy_num;
    	$q4="update system.hospital
    		set h_oxygen_num=".$oxy_num." 
    		where h_id=".$H_ID;

    }

    if(isset($_POST['ventilator-add'])){
    	$q1="update system.patient
    		set p_ventilator='yes'
    		where p_id=".$P_ID;
    	$q2="delete from system.ventilators
    		where p_id=".$P_ID;
    	$q3="select h_ventilator_num from system.hospital
    		 where h_id=".$H_ID;
    	$query=oci_parse($con, $q3);
    	$r=oci_execute($query);
    	$row=oci_fetch_array($query,OCI_BOTH+OCI_RETURN_NULLS);
    	$vent_num=$row[0];
    	$vent_num=$vent_num - 1;
    	echo "vent:".$vent_num;
    	$q4="update system.hospital
    		set h_ventilator_num=".$vent_num." 
    		where h_id=".$H_ID;

    } 

    $query_id=oci_parse($con, $q1);
    $r=oci_execute($query_id);
    $r=oci_commit($con);
    $query_id=oci_parse($con, $q2);
    $r=oci_execute($query_id);
    $r=oci_commit($con);
    $query_id=oci_parse($con, $q4);
    $r=oci_execute($query_id);
    $r=oci_commit($con);

    header("Location: admin-logged.php");
	exit();







?>