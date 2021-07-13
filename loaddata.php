<?php
include "config.php";
$id =$_GET['id'];
$sql_data = "SELECT * FROM text_list WHERE id ='$id'";
$result_data = mysqli_query($conn, $sql_data);

$row = mysqli_fetch_array($result_data, MYSQLI_ASSOC);



$temp_encode = json_encode($row);
echo $temp_encode;
