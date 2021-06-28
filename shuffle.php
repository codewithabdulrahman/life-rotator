<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css"/>
    <title>Save form Data in a Local Storage using JavaScript</title>
    <link href="custom/custom.css" media="all" type="text/css" rel="stylesheet">
    <!--    <script src="custom/custom.js"></script>-->
    <script src="custom/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>


</head>
<body>
<div id="main_container">
    <!--          <div id="edit">-->
    <div>
        <button id="add_category_button" type="button" class="btn btn-primary" onclick="document.location='index.php'">
            Show Text List
        </button>
    </div>
    <!--Add few elements to the form-->
    <div id="show_box" class="show_box">
        <form method="post">
            <div id="listingTable" class="show_box"></div>


    </div>
    <!--        </div>-->
    <div class="show_box">

        <div><input type="button" id="btn_prev" onclick="prevPage()" class="button_radius" value="Prev"/>
            <button type="button" id="page" class="btn btn-secondary" data-dismiss="modal"></button>
            <!--              <span id="page"></span>-->
            <input type="button" id="btn_next" onclick="nextPage()" class="button_radius" value="Next"/>


            <input type="button" id="bt_shuffle" onclick="document.location='shuffle.php'" class="button_radius"
                   value="Shuffle"/>
            <input type="button" data-toggle="modal" data-target="#exampleModal" id="bt_edit" class="button_radius edit"
                   value="Edit"/>
            <input type="button" id="bt_add" onclick="document.location='add.php'" class="button_radius" value="+"/>

        </div>
    </div>
    <div id="dom-target" style="display: block;">

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
                    <label class="form-label" for="edit_text">Your text</label>
                    <textarea class="form-control" name="edit_text" id="edit_text" rows="4"></textarea>
                    <textarea class="form-control" name="id_hidden_paginate" hidden id="id_hidden_paginate"></textarea>
                    <br>
                    <label class="form-label" for="edit_category_select">Your Category</label>
                    <select class="modal_select" id="edit_category_select" name="edit_category_select">

                    </select>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                <button type="submit" name="update" class="btn btn-primary">Update</button>

                </form>
            </div>
        </div>
    </div>
</div>


</body>
<script>
    let test_data =<?php
        include "config.php";
        $sql_data = "SELECT * FROM text_list";
        $result_data = mysqli_query($conn, $sql_data);
        $data_ = array();

        $row = mysqli_fetch_all($result_data, MYSQLI_ASSOC);



        $temp_encode = json_encode($row);
        echo $temp_encode;
        ?>;
    console.log(test_data.length);

    let current_page = 1;
    let records_per_page = 1;
    let objJson = [];
    let i;
    if (localStorage.hasOwnProperty("category")) {
        i = 1;
    } else {
        i = 0;
    }
    for (i; i < test_data.length; i++) {


        let item = test_data[i];


        objJson.push(item);
    }
    for (let a = 0; a < objJson.length; a++) {
        let x = objJson[a];
        let y = Math.floor(Math.random() * (a + 1));
        objJson[a] = objJson[y];
        objJson[y] = x;
    }
    console.log(objJson)

    function prevPage() {
        if (current_page > 1) {
            current_page--;
            changePage(current_page);
        }
    }

    function nextPage() {
        if (current_page < numPages()) {
            current_page++;
            changePage(current_page);
        }
    }

    function changePage(page) {
        let btn_next = document.getElementById("btn_next");
        let btn_prev = document.getElementById("btn_prev");
        let listing_table = document.getElementById("listingTable");
        let page_span = document.getElementById("page");

        if (page < 1) page = 1;
        if (page > numPages()) page = numPages();

        listing_table.innerHTML = "";

        for (let i = (page - 1) * records_per_page; i < (page * records_per_page) && i < objJson.length; i++) {

            listing_table.innerHTML += '<div id=\'sementic\'><p id=\'paragraph\' type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].data + ' </p><p id=\'id_hidden\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].id + ' </p><p id=\'hidden_category_tmp\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].category + ' </p></div>';
        }

        page_span.innerHTML = page + "/" + numPages();

        if (page == 1) {
            btn_prev.style.visibility = "hidden";
        } else {
            btn_prev.style.visibility = "visible";
        }

        if (page == numPages()) {
            btn_next.style.visibility = "hidden";
        } else {
            btn_next.style.visibility = "visible";
        }
    }

    function numPages() {
        return Math.ceil(objJson.length / records_per_page);
    }

    window.onload = function () {
        changePage(1);
    };
    $(document).ready(function () {
        $(document).on('click', '.edit', function () {
            const text = document.getElementById("id_hidden").textContent;
            console.log(text)
            let id = document.getElementById("id_hidden").textContent;
            let tmp_category = document.getElementById("hidden_category_tmp").textContent;
            console.log(tmp_category)
            let data = $('#paragraph').text();


            $('#exampleModal').modal('show');
            $('#id_hidden_paginate').val(id);
            $('#edit_text').val(data);

            let test_data_category =<?php
                include "config.php";
                $sql_data = "SELECT * FROM category_list";
                $result_data = mysqli_query($conn, $sql_data);
                $data_ = array();

                $row = mysqli_fetch_all($result_data, MYSQLI_ASSOC);



                $temp_encode = json_encode($row);
                echo $temp_encode;
                ?>;
            let objJson_category = [];


            for (let i = 0; i < test_data_category.length; i++) {
                let item = test_data_category[i];
                objJson_category.push(item);
            }
            let theDiv = document.getElementById("edit_category_select");
            theDiv.innerHTML += '<option value=' + tmp_category + '>' + tmp_category + '</option>';


            for (let i = 0; i < objJson_category.length; i++) {

                let item = objJson_category[i].category;
                theDiv.innerHTML += '<option value=' + item + '>' + item + '</option>';

            }

        });

    });
</script>

</html>
<?php
include "config.php";
if (isset($_POST['update'])) {

//    $data = $_POST['text'];
    $id = $_POST['id_hidden_paginate'];
    $data = $_POST['edit_text'];
    $category = $_POST['edit_category_select'];

//    $insert = mysqli_query($conn,"UPDATE `text_list` SET `data` = '$data',`category` = '$category' WHERE `id`=`$id` ");
    $update = mysqli_query($conn, "update text_list set data='$data', category='$category' where id='$id'");
    if (!$update) {
        echo 'failed';
        die();
//         echo mysqli_error();
    } else {
        echo "<script>window.open('paginate.php','_self')</script>";
    }
} elseif (isset($_POST['delete'])) {
    $id = $_POST['id_hidden_paginate']; // get id through query string

    $del = mysqli_query($conn, "delete from text_list where id = '$id'");
    if (!$del) {
        echo 'failed';
        die();
//         echo mysqli_error();
    } else {
        echo "<script>window.open('paginate.php','_self')</script>";
    }
}
mysqli_close($conn); // Close connection
?>