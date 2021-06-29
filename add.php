
<html>
<?php include"assets/include_header/header.php"?>
<body>
<div id="main_container">

    <!--Add few elements to the form-->
    <div class="show_box" id="show_box">
        <form method="POST">
            <textarea id="text" class="specific_text" name="text" placeholder="Write Some Text ..." required></textarea>


            <div class="show_box">

                                <select name="basic[]" id="mutiple_select" multiple="multiple" >

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
        <br>
        <br>
        <br>
     <a href="paginate.php">Cancel</a>
    </div>

</div>

</div>

</body>
<script>


    $('#mutiple_select').multiselect({

        columns: 1,
        placeholder: 'Select Category',
    });

</script>
</html>
<?php
// Using database connection file here
include "config.php";
if (isset($_POST['submit'])) {
//    $data = $_POST['text'];
    $data = $_POST['text'];
    $category = $_POST['basic'];
    $temp_cat_json=json_encode($category);
    $insert = mysqli_query($conn, "INSERT INTO `text_list`(`data`, `category`) VALUES ('$data','$temp_cat_json')");

    if (!$insert) {
        echo $insert;
//         echo mysqli_error();
    } else {
        echo "<script>window.open('paginate.php','_self')</script>";
    }
}

mysqli_close($conn); // Close connection
?>
