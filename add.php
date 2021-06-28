<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>Save form Data in a Local Storage using JavaScript</title>
    <link href="custom/custom.css" media="all" type="text/css" rel="stylesheet">
    <script src="custom/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>


</head>
<body>
<div id="main_container">

    <!--Add few elements to the form-->
    <div class="show_box" id="show_box">
        <form method="POST">
            <textarea id="text" class="specific_text" name="text" placeholder="Write Some Text ..."></textarea>


            <div id="append_select">
                <!--                <label >Choose a Category:</label>-->

                <select class="category_select" name="category_list" id="category_select">
                    <option value="">--Please choose a category--</option>
                    <?php
                    include "config.php";


                    $query = "SELECT * FROM category_list";
                    $result = mysqli_query($conn, $query);

                    if (!$result) {
                        die('Query Failed' . mysqli_error());
                    }
                    while ($row = mysqli_fetch_assoc($result)) {
                        $id = $row['id'];
                        $category = $row['category'];
                        echo "<option name='$id'  value='$category'>$category</option>";
                    }
                    mysqli_close($conn);
                    ?>


                </select>

            </div>
            <div style="margin-left: 4px;">

                <button type="submit" id="add" name="submit" class="btn btn-primary">Add</button>
        </form>
        <button type="button" id="show_list" class="btn btn-warning" onclick="document.location='index.php'">Show
            List
        </button>
    </div>

</div>

</div>

</body>


</html>
<?php
// Using database connection file here
include "config.php";
if (isset($_POST['submit'])) {
//    $data = $_POST['text'];
    $data = $_POST['text'];
    $category = $_POST['category_list'];

    $insert = mysqli_query($conn, "INSERT INTO `text_list`(`data`, `category`) VALUES ('$data','$category')");

    if (!$insert) {
        echo $insert;
//         echo mysqli_error();
    } else {
        echo "<script>window.open('index.php','_self')</script>";
    }
}

mysqli_close($conn); // Close connection
?>
