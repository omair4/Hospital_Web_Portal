<!DOCTYPE html>
<html>
<head>
	<title>Logged</title>
	<link rel="stylesheet" type="text/css" href="css/logged-tabs.css">
	<link rel="stylesheet" type="text/css" href="css/table.css">
	<link rel="stylesheet" type="text/css" href="css/forms.css">
	<link rel="stylesheet" type="text/css" href="css/reports.css">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
			<button class="tablink" onclick="openPage('Doctor',this,'#AA32FA')">Doctors</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Resources',this,'#AA32FA')">Resources</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Patients',this,'#AA32FA')">Patients</button>
		</div>
		<div>
			<button class="tablink" onclick="openPage('Reports',this,'#AA32FA')">Reports</button>
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
	<?php

		function get_hospital_name($H_ID,$con){
			$q="select H_name from system.hospital where H_ID=".$H_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}
		function get_doctor_name($D_ID,$con){
			$q="select D_name from system.doctor where D_ID=".$D_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}
		function get_patient_name($P_ID,$con){
			$q="select P_name from system.patient where P_ID=".$P_ID;
			$query_id=oci_parse($con, $q);
			$r=oci_execute($query_id);
			$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
			return $row[0];

		}

	?>


	<div id="content-div">
		<div id="Dashboard" class="tabcontent">
		<h2>Patients</h2>
		<table class="styled-table">

		<thead>
			<tr>
				<th>P_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Area</th>
				<th>Phone</th>
				<th>PCR Result</th>
				<th>Oxygen Level</th>
				<th>Self Quarantined?</th>
				<th>Quarantined Days</th>
				<th>Result</th>
			</tr>
		</thead>
		<tbody>
	<?php

		$q="select * from system.patient";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['P_ID']."</td>
						<td>".$row['P_NAME']."</td>
						<td>".$row['P_AGE']."</td>
						<td>".$row['P_GENDER']."</td>
						<td>".$row['P_AREA']."</td>
						<td>".$row['P_PHONE']."</td>
						<td>".$row['P_PCR_RESULT']."</td>
						<td>".$row['P_OXY_LEVEL']."%</td>
						<td>".$row['P_SELF_QUARANTINED']."</td>
						<td>".$row['P_QUARANTINE_DAYS']."</td>
						<td>".$row['P_RESULT']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>
	<h3>Doctors</h3>
	<table class="styled-table">

		<thead>
			<tr>
				<th>D_ID</th>
				<th>Name</th>
				<th>Age</th>
				<th>Gender</th>
				<th>Phone</th>
				<th>PCR Result</th>
				<th>Last PCR Date</th>
				<th>Hospital ID</th>
			</tr>
		</thead>
		<tbody>
		<?php

		$q="select * from system.doctor";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['D_ID']."</td>
						<td>".$row['D_NAME']."</td>
						<td>".$row['D_AGE']."</td>
						<td>".$row['D_GENDER']."</td>
						<td>".$row['D_PHONE']."</td>
						<td>".$row['D_PCR_RESULT']."</td>
						<td>".$row['D_PCR_DATE']."</td>
						<td>".$row['H_ID']."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

	<h3>Appointments</h3>

	<table class="styled-table">

		<thead>
			<tr>
				<th>Appointment ID</th>
				<th>Patient Name</th>
				<th>Doctor Name</th>
				<th>Hospital Name</th>
			</tr>
		</thead>
		<tbody>
		<?php

		$q="select * from system.appointments";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<tr>  <td>".$row['A_ID']."</td>
						<td>".get_patient_name($row['P_ID'],$con)."</td>
						<td>".get_doctor_name($row['D_ID'],$con)."</td>
						<td>".get_hospital_name($row['H_ID'],$con)."</td>
					  </tr>";
		}


	?>
	</tbody>
	</table>

		</div>

		<div id="Doctor" class="tabcontent">
			

	<form action="" method="post" class="add-form">
		<legend>Add Doctors</legend>
		<div>
			<input type="number" class="t_input" name="D_ID" placeholder="Doctor ID">
		</div>
		<div>
			<input type="text" class="t_input" name="D_name" placeholder="Name">
		</div>
		<div>
			<input type="number" class="t_input" name="D_age" placeholder="Age">
		</div>
		<div>
			
			<input type="radio" class="check" name="D_gender" value="Male"><span class="radio-cont">Male
			</span>
			<input type="radio"class="check" name="D_gender" value="Female"><span class="radio-cont">Female
		</span>
		</div>
		
		<div>
			<input type="number" class="t_input" name="D_phone" placeholder="Phone Number">
		</div>
		<div>
			PCR Result:
		</div>
		<div>
			<input type="radio" class="check" name="D_pcr_result" value="positive">
			<span class="radio-cont">Positive </span>
			<input type="radio" class="check" name="D_pcr_result" value="negative">
			<span class="radio-cont">Negative </span>
		</div>
		<div>
			PCR Last date:<input type="date" class="t_input" name="D_pcr_date" >
		</div>
	
		
			<?php $q="select * from system.hospital";
				$query_id=oci_parse($con, $q);
				$r=oci_execute($query_id);
				echo "<form action='doc-add.php' method='POST' ><div>Hospital:</div>  <select class='t_input' name='hos-sel' >
				<option value=''></option>";
				while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
					echo "<option value=".$row['H_NAME']." >".$row['H_NAME']."</option>";
				}
				echo "</select><br><input type='submit' class='btn' name='sel' value='Sign-up'/></form> ";
				if(isset($_POST['sel'])){
					$hospital=$_POST['hos-sel'];
					$q="select h_id from system.hospital where h_name= '".$hospital."'";
					$query_id=oci_parse($con, $q);
					$r=oci_execute($query_id);
					$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
					$hospital_ID=$row[0];
					$_SESSION['H_ID']=$hospital_ID;


				}

			?>
</form>
		<?php
		if(isset($_POST['sel'])){
		$d_id=$_POST['D_ID'];
      	$h_id=$_SESSION['H_ID'];
      	$d_name=$_POST['D_name'];
      	$d_age=$_POST['D_age'];
      	$d_gender=$_POST['D_gender'];
      	$d_phone=$_POST['D_phone'];
      	$d_pcr_result=$_POST['D_pcr_result'];
      	$d_pcr_date=$_POST['D_pcr_date'];
      	



      	
      	$q="insert into system.doctor (D_ID,H_ID,D_name,D_age,D_gender,D_phone,
      		D_pcr_result,D_pcr_date)values(".
      		$d_id.",".
      		$h_id.",'".
      		$d_name."',".
      		$d_age.",'".
      		$d_gender."',".
      		$d_phone.",'".
      		$d_pcr_result.
      		"',to_date('".$d_pcr_date."','yyyy-mm-dd'))";
		
      	$query_id=oci_parse($con, $q); 
      	$r=oci_execute($query_id); 
      	$r=oci_commit($con);

      	$q1="create user ".$d_name." identified by 1234";
      	$q2="grant doctor_role to ".$d_name;
      	$query_id=oci_parse($con, $q1); 
      	$r=oci_execute($query_id);
      	$query_id=oci_parse($con, $q2); 
      	$r=oci_execute($query_id);
      	$r=oci_commit($con);

      	if($r){
      		echo"Doctor Added Suffessfully";
      	}

      }
		?>

		</div>

		<div id="Resources" class="tabcontent">
				<table class="styled-table">

		<thead>
			<tr>
				<th>H_ID</th>
				<th>Hospital Name</th>
				<th>Area</th>
				<th>Doctor Number</th>
				<th>Oxygen Available</th>
				<th>Ventilator Available</th>
				<th>Add Resources<th>
				
			</tr>
		</thead>
		<tbody>
		<?php

		$q="select * from system.hospital";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			if($row['H_VENTILATOR_NUM']<=2){
				echo "<tr class='ventilator-needed'>";
			}
			else{
				echo "<tr>";

			}

			echo "  <td>".$row['H_ID']."</td>
						<td>".$row['H_NAME']."</td>
						<td>".$row['H_AREA']."</td>
						<td>".$row['H_DOCTOR_NUM']."</td>
						<td>".$row['H_OXYGEN_NUM']."</td>
						<td>".$row['H_VENTILATOR_NUM']."</td>
						<td> <form action='add-resourses.php' method='POST'>
								<select name='resource-sel'>
									<option value='ventilator'>Ventilator</option>
									<option value='oxygen'> Oxygen </option>
								</select>
								<input type='number' name='resource-num'>
								<input type='hidden' name='row-id' value='".$row['H_ID']."'>
								<input type='submit' name='add-btn' value='Add'/>
							</form>
						</td>
					  </tr>";
		}

		


	?>
	</tbody>
	</table>

		</div>

		<div id="Patients" class="tabcontent">
		<h3>Patient Managment</h3>
		<table class="styled-table">

		<thead>
			<tr>
				<th>Patient</th>
				<th>Doctor</th>
				<th>Hospital</th>
				<th>Recommendation</th>
			</tr>
		</thead>
		<tbody>
		
		<?php

		$q="select * from system.ventilators";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<form action='assign-resources.php' method='POST'>";
			echo "<input type='hiddden' name='add-PID' value='".$row['P_ID']."' >
				  <input type='hiddden' name='add-HID' value='".$row['H_ID']."' >";
			echo "<tr>  
						<td>".get_patient_name($row['P_ID'],$con)."</td>
						<td>".get_doctor_name($row['D_ID'],$con)."</td>
						<td>".get_hospital_name($row['H_ID'],$con)."</td>
						<td>
							
							<input type='submit' name='ventilator-add' value='Assign Ventilator' >
						</td>
				 </form>	  </tr>";
		}

		$q="select * from system.oxygen";
		$query_id=oci_parse($con, $q);
		$r=oci_execute($query_id);
		
		while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			echo "<form action='assign-resources.php' method='POST'>";
			echo "<input type='hiddden' name='add-PID' value='".$row['P_ID']."' >
				  <input type='hiddden' name='add-HID' value='".$row['H_ID']."' >";
			echo "<tr>  
						<td>".get_patient_name($row['P_ID'],$con)."</td>
						<td>".get_doctor_name($row['D_ID'],$con)."</td>
						<td>".get_hospital_name($row['H_ID'],$con)."</td>
						<td>
							
							<input type='submit' name='oxygen-add' value='Assign Oxygen' />
						</td>
				</form>  </tr>";
		}


	?>
	</tbody>
	</form>
	</table>

	<h3>Patient Search</h3>
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

		<div id="Reports" class="tabcontent">
	<?php 

	$recovered=0;
	$active=0;
	$dead=0;

	$q="select p_result,count(*) as mycount from system.patient
		group by p_result";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);


	while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
			$st=trim($row[0]);
			if($st=="dead"){
				$dead=$row[1];
			}
			if($st=="active"){
				$active=$row[1];
			}
			if($st=="recovered"){
				$recovered=$row[1];
			}
	}

	$age_below_16=0;
	$age17_30=0;
	$age31_50=0;
	$age_above_50=0;
	$total_postive=0;

	$q="select count(*) as num_people from system.patient where p_age<=16 and p_pcr_result='positive'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$age_below_16=$row[0];

	$q="select count(*) as num_people from system.patient where p_age>16 and p_age<=30 and p_pcr_result='positive'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$age17_30=$row[0];

	$q="select count(*) as num_people from system.patient where p_age>30 and p_age<=50 and p_pcr_result='positive'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$age31_50=$row[0];

	$q="select count(*) as num_people from system.patient where p_age>50 and p_pcr_result='positive'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$age_above_50=$row[0];

	$male_positive=0;
	$female_positive=0;

	$q="select count(*) as num_people from system.patient where p_gender='Male'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$male_positive=$row[0];

	$q="select count(*) as num_people from system.patient where p_gender='Female'";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);
	$row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS);
	$female_positive=$row[0];


	echo "<script type='text/javascript'>
		
		
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

		
		function drawChart() {
		  var data = google.visualization.arrayToDataTable([
  			['Rates', 'cases'],
  			['Recovered', ".$recovered."],
		  	['Active', ".$active."],
  			['Dead', ".$dead."]
			]);

			
			var options = {'title':'Infection Rates', 'width':550, 'height':400};

  			
  			var chart = new google.visualization.PieChart(document.getElementById('ratechart'));
  			chart.draw(data, options);
		}
	</script>";

	echo "<script type='text/javascript'>
		
		
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

		
		function drawChart() {
		 var data = google.visualization.arrayToDataTable([
  			['Age Group', 'Number of People'],
  			['16 and Below', ".$age_below_16."],
		  	['between 17 and 30', ".$age17_30."],
  			['between 31 and 50', ".$age31_50."],
  			['Above  50',".$age_above_50."]
			]);

			
		var options = {'title':'Age Groups and Infection rates', 'width':560, 'height':560};	
  			var chart = new google.visualization.PieChart(document.getElementById('agechart'));
  			chart.draw(data, options);
		}
	</script>";

	echo "<script type='text/javascript'>
		
		
			google.charts.load('current', {'packages':['corechart']});
			google.charts.setOnLoadCallback(drawChart);

		
		function drawChart() {
		 var data = google.visualization.arrayToDataTable([
  			['Gender', 'cases'],
  			['Male', ".$male_positive."],
		  	['Female', ".$female_positive."]
			]);

			
		var options = {'title':'Gender and Infection rate', 'width':560, 'height':560};
  			var chart = new google.visualization.PieChart(document.getElementById('genderchart'));
  			chart.draw(data, options);
		}
	</script>";




	?>
	<h3>Statistics</h3>
	<div id="ratechart" class="pie"></div>
	<div id="agechart" class="pie"></div>
	<div id="genderchart" class="pie"></div>

	<h3>Hotspots & Lockdown</h3>
	<?php
	$q="select p_area,count(*) as mycount from system.patient
		where P_PCR_RESULT='positive'
		group by p_area";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);

	echo "<div id='hotspot-container' class='lockandhot-container'> <h3>Hotspot</h3>";

	while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
		if($row['MYCOUNT']>=5 && $row['MYCOUNT']<8){
			echo "<div class='lockandhot'>".$row['P_AREA']."</div>";
		}
		
	}
	echo "</div>";

	$q="select p_area,count(*) as mycount from system.patient
		where P_PCR_RESULT='positive'
		group by p_area";
	$query_id=oci_parse($con, $q);
	$r=oci_execute($query_id);

	echo "<div id='lockdown-container' class='lockandhot-container' >
		  <h3>Lockdowns</h3>";

	while($row=oci_fetch_array($query_id,OCI_BOTH+OCI_RETURN_NULLS)){
		if($row['MYCOUNT']>=8){
			echo "<div  class='lockandhot' >".$row['P_AREA']."</div>";
		}
	}

	echo "</div>";



	?>


	</div>

		<div id="Acct-mngmt" class="tabcontent">
			<form action="change-pass.php" method="POST">
				Current password:<input type="Password" name="old-password" />
				New Password:<input type="Password" name="new-password" />
				<input type="submit" name="change-pass" value="Change Password"/>
			</form>
		</div>


	</div>

</body>
</html>