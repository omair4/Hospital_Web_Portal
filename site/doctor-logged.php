<!DOCTYPE html>
<html>
<head>
	<title>Logged</title>
	<link rel="stylesheet" type="text/css" href="css/logged-tabs.css">
	<link rel="stylesheet" type="text/css" href="css/table.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<link rel="stylesheet" type="text/css" href="css/profile.css">
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
			<button class="tablink" onclick="openPage('Patients',this,'#AA32FA')">Patients</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Search',this,'#AA32FA')">Search</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('All-Patients',this,'#AA32FA')">All Patients</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Add-Patients',this,'#AA32FA')">Add Patients</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Acct-mngmt',this,'#AA32FA')">Account Managment</button>
		</div>
		
	</div>



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


	?>
	


	<div id="content-div">
		<div id="Dashboard" class="tabcontent">
		<h2>Doctor's Profile</h2>
			<?php
				$q="select * from system.doctor where D_name='".$db_user."'";
		
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
				//print_r($row);

				$doctor_ID=$row['D_ID'];
				$hospital_ID=$row['H_ID'];
				$_SESSION['H_ID']=$hospital_ID;
				$_SESSION['D_ID']=$doctor_ID;

				$q="select H_name from system.hospital where H_ID='".$row['H_ID']."'";
				
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				$ro=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
				$hospital_name=$ro[0];
			?>

			<table class="profile-table">
				<tbody>
					<tr>
						<td class="labels">Name :</td>
						<td class="info" ><?php echo $row['D_NAME']; ?></td>
					</tr>
					<tr>
						<td class="labels">Age :</td>
						<td class="info"> <?php echo $row['D_AGE']; ?></td>
					</tr>
					<tr>
						<td class="labels">Gender :</td> 
						<td class="info"><?php echo $row['D_GENDER']; ?></td>
					</tr>
					<tr>
						<td class="labels">Phone number :</td> 
						<td class="info"><?php echo $row['D_PHONE']; ?></td>
					</tr>
					<tr>
						<td class="labels">PCR Result :</td> 
						<td class="info"><?php echo $row['D_PCR_RESULT']; ?></td>
					</tr>
					<tr>
						<td class="labels">Last date of PCR :</td> 
						<td class="info"><?php echo $row['D_PCR_DATE']; ?></td>
					</tr>
					<tr>
						<td class="labels">Hospital Name :</td> 
						<td class="info"><?php echo $hospital_name; ?></td>
					</tr>
				</tbody>
			</table>



		</div>



		


		<div id="Patients" class="tabcontent">
				<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Oxygen Level</th>
				<th>Recommendation</th>

			</tr>
		</thead>
		<tbody>
	
	
	<?php

		

		
		$q="select * from system.patient where D_ID=".$doctor_ID;
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<form action='recommend.php' method='POST' id='recommend-form'>";
			if($row['P_OXY_LEVEL']>85){
				echo "<tr>";
			}
			if($row['P_OXY_LEVEL']<=85 && $row['P_OXY_LEVEL']>60){
				echo "<tr class='oxygen-needed'>";


			}
			if($row['P_OXY_LEVEL']<=60){
				echo "<tr class='ventilator-needed'>";
			}
			
			echo "<td>".$row['P_ID']."</td>
					<td>".$row['P_NAME']."</td>
					<td>".$row['P_OXY_LEVEL']."</td>";



			if($row['P_OXY_LEVEL']<=90 && $row['P_OXY_LEVEL']>85){
				echo "<td> Monitor </td>";
			}

			if($row['P_OXY_LEVEL']<=85 && $row['P_OXY_LEVEL']>60){
				echo "<input type='hidden' name='recommend-PID' value='".$row['P_ID']."'>";
				echo "<td>";
				$q="select * from system.oxygen where P_ID=".$row['P_ID'];
				$oxy_q=oci_parse($con, $q);
				$rr=oci_execute($oxy_q);
				$res=oci_fetch_array($oxy_q,OCI_BOTH+OCI_RETURN_NULLS);
				if($res[0]){
					echo "Oxygen Recommendation sent.";
				}
				else{
					$q="select P_ID from system.patient where P_ID=".$row['P_ID']." and p_oxygen='yes'";
					$oxy_q=oci_parse($con, $q);
					$rr=oci_execute($oxy_q);
					$res=oci_fetch_array($oxy_q,OCI_BOTH+OCI_RETURN_NULLS);
					if($res[0]){
						echo "Oxygen Assigned";
					}
					else{

						echo "<input type='submit' name='oxy-btn' value='oxygen' /> ";
						
					}
				}
				
				echo "</td>";

			}
			if($row['P_OXY_LEVEL']<=60){
				echo "<input type='hidden' name='recommend-PID' value='".$row['P_ID']."'>";
				echo "<td>";
				$q="select * from system.ventilators where P_ID=".$row['P_ID'];
				$oxy_q=oci_parse($con, $q);
				$rr=oci_execute($oxy_q);
				$res=oci_fetch_array($oxy_q,OCI_BOTH+OCI_RETURN_NULLS);
				if($res[0]){
					echo "Ventilator Recommendation sent.";
				}
				else{

					$q="select P_ID from system.patient where P_ID=".$row['P_ID']." and p_ventilator='yes'";
					$oxy_q=oci_parse($con, $q);
					$rr=oci_execute($oxy_q);
					$res=oci_fetch_array($oxy_q,OCI_BOTH+OCI_RETURN_NULLS);
					if($res[0]){
						echo "Ventilator Assigned";
					}
					else{
						echo "<input type='submit' name='vent-btn' value='ventilator' />";
						
					}
				}
				echo "</td>";
			}
			if($row['P_OXY_LEVEL']>90){
				echo "<td> </td>";
			}			

			echo "</form></tr>";
		}

	?>


	</tbody>
		
	</table>

		</div>

		<div id="Search" class="tabcontent">
				<form action="" method="POST">
			Enter the name of Patient: <input type="text" name="name-search">
			or Enter Mobile number: <input type="number" name="phone-search">
			<input type="submit" name="search-btn" value="Search"/>
		</form>

		<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>PCR Result</th>
				<th>Result</th>

			</tr>
		</thead>
		<tbody>

		<?php

			if(isset($_POST['search-btn'])){
				if($_POST['name-search']){
					$q="select * from system.patient where P_name='".$_POST['name-search']."'";
				}
				if($_POST['phone-search']){
					$q="select * from system.patient where P_phone=".$_POST['phone-search'];
				}
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);

				echo "<tr> <td>".$row['P_ID']."</td>
						   <td>".$row['P_NAME']."</td>
						   <td>".$row['P_AGE']."</td>
						   <td>".$row['P_GENDER']."</td>
						   <td>".$row['P_PCR_RESULT']."</td>
						   <td>".$row['P_RESULT']."</td>
					  </tr>";
			}

		?>
	</tbody>
	</table>

		</div>

		<div id="All-Patients" class="tabcontent">
			<h3>All Patients</h3>
		<table class="styled-table">
		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>PCR Result</th>
				<th>Result</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$q="select * from system.patient";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr> <td>".$row['P_ID']."</td>
						<td>".$row['P_NAME']."</td>
						   <td>".$row['P_AGE']."</td>
						   <td>".$row['P_GENDER']."</td>
						   <td>".$row['P_PCR_RESULT']."</td>
						   <td>".$row['P_RESULT']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

		</div>

		<div id="Add-Patients" class="tabcontent">
		<form action="pat_add.php" class="add-form" method="post">
			<legend>Add Patients</legend>
		<div>
			<input type="number" class="t_input" name="P_ID" placeholder="Patient ID">
		</div>
		<div>
			<input type="text" class="t_input" name="P_name" placeholder="Name">
		</div>
		<div>
			<input type="number" class="t_input" name="P_age" placeholder="Age">
		</div>
		<div>
			<input type="radio" class="check" name="P_gender" value="Male">
			<span class="radio-cont">Male</span> 
			<input type="radio" class="check" name="P_gender" value="Female">
			<span class="radio-cont">Female</span>
		</div>
		<div>
			<input type="text" class="t_input" name="P_area" placeholder="Area e.g (G-11,G-10,G-9)">
		</div>
		<div>
			<input type="number" class="t_input" name="P_phone" placeholder="Phone Number">
		</div>
		<div>
			PCR Result:
		</div>
		<div>
			<input type="radio" class="check" name="P_pcr_result" value="positive">
			<span class="radio-cont">Positive</span>
			<input type="radio" class="check" name="P_pcr_result" value="negative">     
			<span class="radio-cont">Negative</span>
		</div>
		<div>
			<input type="number" class="t_input" name="P_oxy_level" placeholder="Oxygen Level">
		</div>
		<div>
			self-Quarantined?
		</div>
		<div>
			<input type="radio" class="check" name="P_self_quarantined" value="yes">
			<span class="radio-cont">Yes</span>
			<input type="radio" class="check" name="P_self_quarantined" value="no">
			<span class="radio-cont">No</span>
		</div>
		<div>
			<input type="number" class="t_input" name="P_quarantine_days" placeholder="Number of Quarantine Days">
		</div>
		<div>
			Result:
		</div>
		<div>
			<input type="radio" name="P_result" value="active" style="width:25px; height: 25px; margin-left: 40px;">active
			<input type="radio" name="P_result" value="recovered" style="width:25px; height: 25px; margin-left: 40px;">recovered
			<input type="radio" name="P_result" value="dead" style="width:25px; height: 25px; margin-left: 40px;">Terminal
		</div>
		<div>
			On Oxygen?
		</div>
		<div>
			<input type="radio" class="check" name="P_oxygen" value="yes">
			<span class="radio-cont">Yes</span>
			<input type="radio" class="check" name="P_oxygen" value="no">
			<span class="radio-cont">No</span>
		</div>
		<div>
			On Ventilator?
		</div>
		<div>
			<input type="radio" class="check" name="P_ventilator" value="yes">
			<span class="radio-cont">Yes</span>
			<input type="radio" class="check" name="P_ventilator" value="no">
			<span class="radio-cont">No</span>
		</div>
		<?php
		echo "<input type='hidden'  name='hos-id' value='".$hospital_ID."'>
			  <input type='hidden' name='doc-id' value='".$doctor_ID."'>";

		?>

		<div>
			<input type="submit" class="btn" name="signup"/>
		</div>
	</form>
		</div>

		<div id="Acct-mngmt" class="tabcontent">
			<form action="" method="POST">
		Current password:<input type="Password" name="old-password" />
		New Password:<input type="Password" name="new-password" />
		<input type="submit" name="change-pass" value="Change Password"/>
	</form>
	<?php


		if(isset($_POST['change-pass'])){
			$current_pwd=$_POST['old-password'];
			$new_pwd=$_POST['new-password'];
			$r=oci_password_change($con, $db_user, $current_pwd, $new_pwd);
			header("Location : site.html");
			exit;
		}
	?>
		</div>


	</div>

</body>
</html>