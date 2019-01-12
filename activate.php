<?php
include('includes/connection.php');
$id = trim($_GET['x']);
$active = trim($_GET['y']);
if(is_numeric($id) && !empty($active))
{
	$query = "UPDATE user_details set verify_key='Yes' where uid='$id' and verify_key='$active'";
	$result = mysqli_query($con, $query);

	header('Location: index.php?action=active');
}
?>