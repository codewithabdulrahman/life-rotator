<?php
include "config.php";
$temp_data = $_POST['data']; // get id through query string

$del = mysqli_query($conn, "delete from category_list where category = '$temp_data'");
if (!$del) {
    echo 'failed';
    die();
    //         echo mysqli_error();
} else {
    echo "Removed Category";
}
mysqli_close($conn);
