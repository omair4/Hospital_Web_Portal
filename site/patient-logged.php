

<!DOCTYPE html>
<html>
<head>
	<title>Patient Logged</title>
	<link rel="stylesheet" type="text/css" href="css/logged-tabs.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<script type="text/javascript">
		function openPage(pageName, elmnt, color) {
  			// Hide all elements with class="tabcontent" by default */
  			var i, tabcontent, tablinks;
  			tabcontent = document.getElementsByClassName("tabcontent");
  			for (i = 0; i < tabcontent.length; i++) {
			    tabcontent[i].style.display = "none";
			  }

		  // Remove the background color of all tablinks/buttons
			tablinks = document.getElementsByClassName("tablink");
			for (i = 0; i < tablinks.length; i++) {
    			tablinks[i].style.backgroundColor = "";
			}

		  // Show the specific tab content
			document.getElementById(pageName).style.display = "block";

		 // Add the specific color to the button used to open the tab content
			elmnt.style.backgroundColor = color;
		}

		// Get the element with id="defaultOpen" and click on it
		document.getElementById("defaultOpen").click();
	</script>
	<script type="text/javascript">
		function logout(){
			window.location.href= "site.html";


		}
	</script>

	<?php

	//error_reporting(0);
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

      	function get_hospital_ID($H_NAME,$con){
      		$q="select H_ID from system.hospital where H_NAME='".$H_NAME."'";
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];
      	}

?>

</head>
<body>

	<div id="header">
		<div id="logo"></div>
		<div id="logo-text"> FAST-NUCES Hospital </div>
		<div id="logout-div">
			<button id="logout-btn" onclick="logout()">Logout</button>
		</div>

	</div>



	<div id="tabs">
		<div>
			<button class="tablink" onclick="openPage('Dashboard',this,'#AA32FA')">Dashboard</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Appointment',this,'#AA32FA')">Appointment</button>
		</div>
		
		<div>
			<button class="tablink" onclick="openPage('Acct-mngmt',this,'#AA32FA')">Account Managment</button>
		</div>
		
	</div>


	<div id="content-div">
		<div id="Dashboard" class="tabcontent">
			<?php
				$q="select * from system.patient where P_name='".$db_user."'";
				
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
				//print_r($row);

				$patient_ID=$row['P_ID'];
				


			?>
			<table class="profile-table">
				<tbody>
					<tr>
						<td class="labels">Name : </td>
						<td class="info"><?php echo $row['P_NAME']; ?></td>
					</tr>
					<tr>
						<td class="labels">Age : </td>
						<td class="info">	<?php echo $row['P_AGE']; ?></td>
					</tr>
					<tr>
						<td class="labels">Gender : </td>
						<td class="info"><?php echo $row['P_GENDER']; ?></td>
					</tr>
					<tr>
						<td class="labels">Area : </td>
						<td class="info"><?php echo $row['P_AREA']; ?></td>
					</tr>
					<tr>
						<td class="labels">Phone number : </td>
						<td class="info"><?php echo $row['P_PHONE']; ?></td>
					</tr>
					<tr>
						<td class="labels">PCR Result : </td>
						<td class="info"><?php echo $row['P_PCR_RESULT']; ?></td>
					</tr>
					<tr>
						<td class="labels">Oxygen Saturation Level : </td>
						<td class="info"><?php echo $row['P_OXY_LEVEL']; ?></td>
					</tr>
					<tr>
						<td class="labels">Self Quarantined? : </td>
						<td class="info"><?php echo $row['P_SELF_QUARANTINED']; ?></td>
					</tr>
					<tr>
						<td class="labels">Quarantined Days : </td>
						<td class="info"><?php echo $row['P_QUARANTINE_DAYS']; ?></td>
					</tr>
					<tr>
						<td class="labels">Result : </td>
						<td class="info"><?php echo $row['P_RESULT']; ?></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div id="Appointment" class="tabcontent">
			NOTE: You can only get an appointment with a doctor which is already assigned to you.
				<?php 
				$q="select * from system.hospital";
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				echo "<form class='add-form' action='' method='POST' >Hospital:  <select name='hos-sel' class='t_input'>";
				while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
					echo "<option value=".$row['H_NAME']." >".$row['H_NAME']."</option>";
				}
				echo "</select>";

					$q="select * from system.doctor";
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					echo " <br> Doctor:   <select name='doc-sel' class='t_input'>";
					while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
						echo "<option value=".$row['D_NAME']." >".$row['D_NAME']."</option>";
					}
					echo "</select><br> <input type='hidden' name='hos-ID' value=".$hos_ID." > <input type='submit' name='sel' class='btn' value='Book Appointment'/></form>";
				
					if(isset($_POST['sel'])){
						$hospital=$_POST['hos-sel'];
						$doctor=$_POST['doc-sel'];
						$hospital_ID=get_hospital_ID($hospital,$con);

						$q="select d_id from system.doctor where d_name= '".$doctor."'";
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
						$doctor_ID=$row[0];

						

						/*$q="select h_id from system.hospital where h_name= '".$hospital."'";
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
						$hospital_ID=$row[0];*/

						
						$q="select count(*) from system.appointments where p_id= ".$patient_ID;
						$query_id=oci_parse($con, $q);
						$r=oci_execute($query_id);
						$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
						if($row[0]){
							echo("<br>You already have an appointment with Doctor ");
							$q="select d_id from system.appointments where p_id= ".$patient_ID;
							$query_id=oci_parse($con, $q);
							$r=oci_execute($query_id);
							$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
							$q="select d_name from system.doctor where d_id=".$row[0];
							$query_id=oci_parse($con, $q);
							$r=oci_execute($query_id);
							$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
							echo $row[0];


						}
						else{

							$q="insert into system.appointments(A_ID,P_ID,D_ID,H_ID) values(".rand().",".$patient_ID.",".$doctor_ID.",".$hospital_ID.")";
							$query_id=oci_parse($con, $q);
							$r=oci_execute($query_id);
							if(!$r){
								echo("Sorry that doctor doesn't work in that hospital");
							}
							$r=oci_commit($con);


						}

					}//if(isset) end


			



			?>
		</div>

		<div id="Acct-mngmt" class="tabcontent">
			<form action="" class="add-form" method="POST">
				<input type="Password" class="t_input" name="old-password" placeholder="Current Password" />
				<input type="Password" class="t_input" name="new-password" placeholder="New Password" />
				<input type="submit" name="change-pass" class="btn" value="Change Password"/>
			</form>

			<?php

				if(isset($_POST['change-pass'])){

					$current_pwd=$_POST['old-password'];
					$new_pwd=$_POST['new-password'];
					$r=oci_password_change($con, $db_user, $current_pwd, $new_pwd);
					header("Location: site.html");
					exit;
					
				}

			?>
		</div>


	</div>

</body>
</html>