<Html lang="en">
<?php include "assets/include_header/modal_header.php" ?>

<body>

<div id="main_container">
    <div class="show_box">
        <!--            data-target="#exampleModal"-->
        <div><button type="button" id="page" class="btn btn-secondary" data-dismiss="modal"></button>
            <input type="button" id="btn_prev" onclick="prevPage()" class="button_radius" value="⬅" />

            <input type="button" id="btn_next" onclick="nextPage()" class="button_radius" value="Next➞" />
 
          <?php

            if (empty($_GET['temp'])) {
                $data = "No_Data";
            } else {
                $data = $_GET['temp'];
            }
            ?>
            <input type="button" id="bt_categories" onclick="document.location='index.php'" class="button_radius" value="Categories" />
            <input type="button" id="bt_shuffle" onclick="document.location='shuffle.php?temp=<?php echo $data?>'" class="button_radius" value="Shuffle" />
            <input type="button" data-toggle="modal"  id="bt_edit" class="button_radius edit" onclick="loadData()" value="Edit" />
            <input type="button" id="bt_add" onclick="document.location='add.php'" class="button_radius" value="+" />


        </div>
    </div>

    <div id="show_box" class="show_box">
        <form method="post">
            <div id="listingTable" class="show_box"></div>


    </div>
    <br>
    <br>
    
    <div id="dom-target" style="display: block;">

    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">
                <label class="form-label" for="edit_text">Your text</label>
                <textarea class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 358px; " name="edit_text" id="edit_text" rows="4"></textarea>
                <textarea class="form-control" name="id_hidden_paginate" hidden id="id_hidden_paginate"></textarea>
                <br>
                <label class="form-label" for="edit_category_select">Your Category</label>


                <select style="width: 40pc; font-weight: 500" class="another" id="edit_category_select"
                        name="edit_category_select[]" multiple="multiple">
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" style="border-radius: 12px" class="btn btn-secondary" id="close"
                        data-dismiss="modal">Close
                </button>
                <button type="submit" style="border-radius: 12px" class="btn btn-danger" name="delete">Delete</button>
                <button type="submit" style="border-radius: 12px" name="update" class="btn btn-primary"
                        onclick="multiply()">Update
                </button>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
<script>
 let category_get = <?php

        if (empty($_GET['temp'])) {
            $data = "No_Data";
        } else {
            $data = $_GET['temp'];
        }
        echo json_encode($data) ?>;
    let adddata = [];
    let test_data = <?php
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
    if (category_get===null||category_get===undefined||category_get==="No_Data"){
        for (let i=0; i < test_data.length; i++) {
            let item = test_data[i];
            objJson.push(item);
        }
    }
    else {
        for (const [key, value] of Object.entries(test_data)) {
            let cat = JSON.parse(value.category);
            let found = 0;
            cat.forEach(function (v, k) {
                if (v == category_get) {
                    found = 1;
                    objJson.push(test_data[key]);
                }
            });
        }
    }

    objJson = objJson.map(e => e['id']).map((e, i, final) => final.indexOf(e) === i && i).filter((e) => objJson[e]).map(e => objJson[e]);


    for (i = 0; i < objJson.length - 1; i++) {
        let j = i + Math.floor(Math.random() * (objJson.length - i));

        let temp = objJson[j];
        objJson[j] = objJson[i];
        objJson[i] = temp;
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

            listing_table.innerHTML += '<div id=\'sementic\'><textarea class="form-control"  style="margin-top: 0px; margin-bottom: 0px; height: 358px; background-color: white " readonly name="edit_text" id=\'paragraph\' rows="4">' + objJson[i].data + '</textarea><p id=\'id_hidden\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].id + ' </p><p id=\'hidden_category_tmp\' hidden type=\'text\' class=\'specific_text\'  value=> ' + objJson[i].category + ' </p></div>';
        }


        if (objJson.length > 0) {
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
        } else if (objJson.length < 1) {

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

    window.onload = function() {

        changePage(1);

    };

    $(document).ready(function() {

        $('.another').select2({
            placeholder: "Select Category",
            tags: true,
            tokenSeparators: [",", " "],
            createTag: function(tag) {
                return {
                    id: tag.term,
                    text: tag.term,
                    isNew: true
                };
            }
        }).on("select2:select", function(e) {
            if (e.params.data.text===null || e.params.data.text ===undefined|| e.params.data.text ==="") {
                $(this).find('[value="' + e.params.data.id + '"]').remove();
            }
            else {
                adddata.push(e.params.data.text);
                $(this).find('[value="' + e.params.data.id + '"]').replaceWith('<option selected value="' + e.params.data.id + '">' + e.params.data.text + '</option>');

            }

        }).on('select2:unselect', function (e) {
            let temp_remove = e.params.data.text;
            $(this).find('[value="' + e.params.data.id + '"]').remove();
            removeData(temp_remove);
        });

    });


    function multiply() {

        $.ajax({
            type: "POST",
            url: "submitcategory.php",
            data: {
                data: adddata,
            },
            cache: false,
            success: function(data) {
                // alert(data);
            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });

    }
    function loadData() {
        const text = document.getElementById("id_hidden").textContent;

        $.ajax({
            type: "GET",
            url: "loaddata.php",
            data: {
                id: text,
            },
            cache: false,
            success: function(data) {
                let item=[];
                item.push(JSON.parse(data));

                let temp_category=[];
                temp_category.push(JSON.parse(item[0].category));
                let lose=temp_category.join().split(",");
                let theDiv = document.getElementById("edit_category_select");
                $(theDiv).empty();
                for (let i=0;i<lose.length;i++) {
                    theDiv.innerHTML += '<option selected value=' + lose[i] + '>' + lose[i] + '</option>';

                }
                let temp_category_data = <?php
                    include "config.php";
                    $sql_data = "SELECT  DISTINCT category FROM category_list";
                    $result_data = mysqli_query($conn, $sql_data);

                    $row = mysqli_fetch_all($result_data, MYSQLI_ASSOC);



                    $temp_encode = json_encode($row);
                    echo $temp_encode;
                    ?>;
                let push_all=[];
                for (let m=0;m<temp_category_data.length;m++){
                    push_all.push(temp_category_data[m].category)
                }

                for (let i=0;i<push_all.length;i++) {

                    theDiv.innerHTML += '<option  value=' + push_all[i] + '>' + push_all[i] + '</option>';
                }
                let usedNames = {};
                $("select > option").each(function () {
                    if (usedNames[this.value]) {
                        $(this).remove();
                    } else {
                        usedNames[this.value] = this.text;
                    }
                });

                $('#exampleModal').modal('show');
                $('#id_hidden_paginate').val(item[0].id);
                $('#edit_text').val(item[0].data);

            },
            error: function(xhr, status, error) {
                console.error(xhr);
            }
        });

    }

    $(document).ready(function(){

        $('#exampleModal').modal({
            backdrop: 'static',
            show:false
        });



    });

function removeData(data) {


        $.ajax({
            type: "POST",
            url: "removecategory.php",
            data: {
                data: data,
            },
            cache: false,
            success: function (data) {
                console.log(data)
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });

    }
</script>

</html>
<?php
?>
<?php
include "config.php";
if (isset($_POST['update'])) {

    //    $data = $_POST['text'];
    $id = $_POST['id_hidden_paginate'];
    $data = mysqli_real_escape_string($conn, $_POST['edit_text']);
    $category = $_POST['edit_category_select'];
    $temp_cat_json = json_encode($category);
    //    $insert = mysqli_query($conn,"UPDATE `text_list` SET `data` = '$data',`category` = '$category' WHERE `id`=`$id` ");
    $update = mysqli_query($conn, "update text_list set data='$data', category='$temp_cat_json' where id='$id'");
    if (!$update) {
        echo 'failed';
        die();
        //         echo mysqli_error();
    } else {
        echo "<script>window.open('shuffle.php','_self')</script>";
    }
} elseif (isset($_POST['delete'])) {
    $id = $_POST['id_hidden_paginate']; // get id through query string

    $del = mysqli_query($conn, "delete from text_list where id = '$id'");
    if (!$del) {
        echo 'failed';
        die();
        //         echo mysqli_error();
    } else {
        echo "<script>window.open('shuffle.php','_self')</script>";
    }
}
mysqli_close($conn); // Close connection
?>