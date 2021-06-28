<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>Save form Data in a Local Storage using JavaScript</title>
    <link href="custom/custom.css" media="all" type="text/css" rel="stylesheet">
    <!--    <script src="custom/custom.js"></script>-->
    <script src="custom/jquery.min.js"></script>
    <!--    <script src="custom/pagination.js"></script>-->
    <script src="bootstrap/js/bootstrap.min.js"></script>


</head>
<body>
<div id="main_container">
    <!--          <div id="edit">-->
    <div>
        <button id="add_category_button" type="button" class="btn btn-primary"
                onclick="document.location='category.php'">Add Category
        </button>
    </div>
    <!--Add few elements to the form-->
    <div id="show_box" class="show_box">
        <form method="POST">
            <?php
            include "config.php";


            $query = "SELECT * FROM text_list";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Query Failed' . mysqli_error());
            }
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $data = $row['data'];
                $category = $row['category'];
                echo "<div id='sementic' class='sementic'><input type='checkbox' onclick='changeCheckbox($id)' id=$id /><p id=$id+paragraph type='text' class='specific_text'  value=>$data</p>
       <p id=$id+category type='text' hidden class='specific_text'  value=>$category</p>
</div>";
            }
            mysqli_close($conn);
            ?>


    </div>

    <!--        </div>-->
    <div class="show_box">
        <input type="button" onclick="document.location='shuffle.php'" id="bt_shuffle" class="button_radius"
               value="Shuffle"/><input type="submit" id="bt_del" name="delete" class="button_radius"
                                       value="Delete"/><input type="button"
                                                              data-toggle="modal"
                                                              data-target="#exampleModal"
                                                              id="bt_edit"
                                                              class="button_radius"
                                                              value="Edit"/>

        <input type="button" id="bt_add" onclick="document.location='add.php'" class="button_radius" value="+"/>


    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="expand_data">

                <div class="form-outline">
                    <!--                <form method="POST">-->
                    <label class="form-label" for="edit_text">Your text</label>
                    <textarea class="form-control" name="edit_text" id="edit_text" rows="4"></textarea>
                    <textarea class="form-control" name="id_hidden" hidden id="id_hidden"></textarea>
                    <br>
                    <label class="form-label" for="edit_category_select">Your Category</label>
                    <select class="modal_select" name="edit_category_select" id="edit_category_select">
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


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="update" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
<script>
    function changeCheckbox(id) {
        let decider = document.getElementById(id);
        if (decider.checked) {
            let cen = id + '+paragraph';
            let cen2 = id + '+category';
            console.log(cen2)
            const hidden_value = document.getElementById(cen).textContent;
            const hidden_value2 = document.getElementById(cen2).textContent;
            console.log(hidden_value2)

            document.getElementById('edit_text').value = hidden_value;
            document.getElementById('id_hidden').value = id;
            let theDiv = document.getElementById("edit_category_select");
            theDiv.innerHTML += '<option name="0" value=' + hidden_value2 + '>' + hidden_value2 + '</option>';


        } else {

            alert('unchecked');
        }
    }


</script>
<?php

include "config.php";

if (isset($_POST['update'])) {

//    $data = $_POST['text'];
    $id = $_POST['id_hidden'];
    $data = $_POST['edit_text'];
    $category = $_POST['edit_category_select'];

//    $insert = mysqli_query($conn,"UPDATE `text_list` SET `data` = '$data',`category` = '$category' WHERE `id`=`$id` ");
    $update = mysqli_query($conn, "update text_list set data='$data', category='$category' where id='$id'");
    if (!$update) {
        echo 'failed';
        die();
//         echo mysqli_error();
    } else {
        echo "<script>window.open('index.php','_self')</script>";
    }
} elseif (isset($_POST['delete'])) {
    $id = $_POST['id_hidden']; // get id through query string

    $del = mysqli_query($conn, "delete from text_list where id = '$id'");
    if (!$del) {
        echo 'failed';
        die();
//         echo mysqli_error();
    } else {
        echo "<script>window.open('index.php','_self')</script>";
    }
}
mysqli_close($conn); // Close connection
?>

</html>
