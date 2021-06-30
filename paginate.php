
<Html lang="en">
<?php include"assets/include_header/modal_header.php"?>
<body>
<div id="main_container">

    <div id="show_box" class="show_box">
        <form method="post">
            <div id="listingTable" class="show_box"></div>


    </div>
   <br>
    <br>
    <div class="show_box">

        <div><button type="button" id="page" class="btn btn-secondary" data-dismiss="modal"></button>
            <input type="button" id="btn_prev" onclick="prevPage()" class="button_radius" value="⬅"/>

            <input type="button" id="btn_next" onclick="nextPage()" class="button_radius" value="Next➞"/>

            <input type="button" id="bt_categories"  onclick="document.location='category.php'" class="button_radius" value="Categories"/>
            <input type="button" id="bt_shuffle" onclick="document.location='shuffle.php'" class="button_radius" value="Shuffle"/>
            <input type="button" data-toggle="modal" data-target="#exampleModal" id="bt_edit" class="button_radius edit" value="Edit"/>
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


                    <select id="edit_category_select" name="edit_category_select[]" multiple="multiple">
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
                <button type="button" style="border-radius: 12px" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" style="border-radius: 12px" class="btn btn-danger" name="delete">Delete</button>
                <button type="submit" style="border-radius: 12px" name="update" class="btn btn-primary">Update</button>

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
         page_span.innerHTML = "0" + "/" + "0";
        if (page < 1) page = 1;
        if (page > numPages()) page = numPages();

        listing_table.innerHTML = "";

        for (let i = (page - 1) * records_per_page; i < (page * records_per_page) && i < objJson.length; i++) {

            listing_table.innerHTML += '<div id=\'sementic\'><p id=\'paragraph\' type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].data + ' </p><p id=\'id_hidden\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].id + ' </p><p id=\'hidden_category_tmp\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].category + ' </p></div>';
        }


           if (objJson.length >0){
               console.log(objJson.length)
               page_span.innerHTML = page + "/" + numPages();

               if (page == 1) {

                   btn_prev.style.visibility = "visible";
               } else {
                   btn_prev.style.visibility = "visible";
               }

               if (page == numPages()) {
                   btn_next.style.visibility = "visible";
               } else {
                   btn_next.style.visibility = "visible";
               }
           }
           else if (objJson.length < 1) {

               // page_span.innerHTML = "0" + "/" + "0";
               if (page == 1) {
                   btn_prev.style.visibility = "visible";
               } else {
                   btn_prev.style.visibility = "visible";
               }

               if (page == numPages()) {
                   btn_next.style.visibility = "visible";
               } else {
                   btn_next.style.visibility = "visible";
               }
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
            console.log(JSON.parse(tmp_category))
            let theDiv = document.getElementById("edit_category_select");
            theDiv.innerHTML += '<option selected value=' + JSON.parse(tmp_category) + '>' + JSON.parse(tmp_category) + '</option>';
            let data = $('#paragraph').text();

            $('#edit_category_select').multiselect({
                columns: 1,
                placeholder: 'Select Category',
            });

            $('#exampleModal').modal('show');
            $('#id_hidden_paginate').val(id);
            $('#edit_text').val(data);




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
    $temp_cat_json=json_encode($category);
//    $insert = mysqli_query($conn,"UPDATE `text_list` SET `data` = '$data',`category` = '$category' WHERE `id`=`$id` ");
    $update = mysqli_query($conn, "update text_list set data='$data', category='$temp_cat_json' where id='$id'");
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