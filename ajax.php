<?php
$link=mysqli_connect("localhost","root","");
mysqli_select_db($link,"mu_enotice_board");

$campus = isset($_GET['campus']) ? $_GET['campus'] : '';
//$campus=$_GET["campus"];
$college = isset($_GET['college']) ? $_GET['college'] : '';
// $college=$_GET["college"];

if ($campus!='') {
	$res=mysqli_query($link,"SELECT * FROM college where Campus=$campus");
	echo "<select id='collegeid' onchange='change_college()'>";
	echo "<option>"; echo "college"; echo "</option>";
	while($row=mysqli_fetch_array($res))
	{
		echo '<option value="'.$row['ID'].'" >'.$row['Name']. '</option>';
	}
	echo "</select>";
}

if ($college!='') {
	$res=mysqli_query($link,"SELECT * FROM department where College=$college");
	echo "<select>";
	echo "<option>"; echo "Department"; echo "</option>";
	while($row=mysqli_fetch_array($res))
	{
		 echo '<option value="'.$row['ID'].'" >'.$row['Dept_Name']. '</option>';
	}
	echo "</select>";
}
?>