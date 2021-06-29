<!DOCTYPE html>
<html>
<?php include"assets/include_header/header.php"?>
<body>
<div id="main_container">

    <!--Add few elements to the form-->
    <div class="margin_category" id="show_box">
        <form method="POST">
            <textarea class="specific_text" id="text" name="text" required placeholder="Enter Category ..."></textarea>

            <br>
            <br>
            <div style="  margin-left: 10px;">

                <button type="submit" id="add" name="submit" class="btn btn-primary" >Add Category</button>
                <br>
                <br>
                <br>
                <a href="paginate.php">Cancel</a>

            </div>
    </div>
<!--    <div class="margin_list">-->
<!---->
<!--        <table id="myTable">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Index</th>-->
<!--                <th>Category</th>-->
<!--                <th>Action</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!---->
<!--            --><?php
//            include "config.php";
//
//            $query=mysqli_query($conn,"select * from `category_list`");
//            while($row=mysqli_fetch_array($query)){
//                ?>
<!--                --><?php //echo "<tr>" ?>
<!--                <td><span id="id--><?php //echo $row['id']; ?><!--">--><?php //echo $row['id']; ?><!--</span></td>-->
<!--                <td><span id="category--><?php //echo $row['id']; ?><!--">--><?php //echo $row['category']; ?><!--</span></td>-->
<!--                <td><button type="button" class="btn btn-success edit" style="border-radius: 13px" value="--><?php //echo $row['id']; ?><!--"><span class="glyphicon glyphicon-edit"></span> Edit</button>-->
<!---->
<!--                </td>-->
<!--                --><?php //echo "</tr>" ?>
<!--                --><?php
//            }
//            ?>
<!---->
<!---->
<!--                      <td>$3</td>>-->
<!---->
<!--            </tbody>-->
<!---->
<!--        </table>-->
<!--    </div>-->


<!--    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"-->
<!--         aria-hidden="true">-->
<!--        <div class="modal-dialog" role="document">-->
<!--            <div class="modal-content">-->
<!--                <div class="modal-header">-->
<!---->
<!--                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>-->
<!--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                        <span aria-hidden="true">&times;</span>-->
<!--                    </button>-->
<!--                </div>-->
<!--                <div class="modal-body" id="expand_data">-->
<!---->
<!--                    <div class="form-outline">-->
<!---->
<!--                        <label class="form-label" for="edit_text">Your Category</label>-->
<!--                        <textarea class="form-control" name="edit_text_category" id="edit_text_category" rows="4"></textarea>-->
<!--                        <textarea class="form-control" hidden name="id_category_hidden" id="id_category_hidden"></textarea>-->
<!--                        <br>-->
<!--                    </div>-->
<!---->
<!---->
<!--                </div>-->
<!--                <div class="modal-footer">-->
<!--                    <button type="button" style="border-radius: 12px" class="btn btn-secondary" data-dismiss="modal">Close</button>-->
<!--                    <button type="submit" style="border-radius: 12px" name="update" class="btn btn-primary">Update</button>-->
<!--                    <button type="submit" style="border-radius: 12px" class="btn btn-danger" name="delete">Delete</button>-->
<!--                    </form>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</body>

<?php

include "config.php";

if(isset($_POST['update']))
{

    $id=$_POST['id_category_hidden'];
    $data=$_POST['edit_text_category'];



    $update=mysqli_query($conn,"update category_list set category='$data' where id='$id'");
    if(!$update)
    {

        echo 'failed';
        die();
//         echo mysqli_error();
    }
    else
    {
        echo "<script>window.open('category.php','_self')</script>";
    }
}
elseif (isset($_POST['delete'])){
    $id = $_POST['id_category_hidden']; // get id through query string

    $del = mysqli_query($conn,"delete from category_list where id = '$id'");
    if(!$del)
    {
        echo 'failed';
        die();
//         echo mysqli_error();
    }
    else
    {
        echo "<script>window.open('category.php','_self')</script>";
    }
}


elseif(isset($_POST['submit']))
{
//
    $category = $_POST['text'];

    $insert = mysqli_query($conn,"INSERT INTO `category_list`(`category`) VALUES ('$category')");

    if(!$insert)
    {
        echo $insert;
//         echo mysqli_error();
    }
    else
    {
        echo "<script>window.open('category.php','_self')</script>";
    }
}


mysqli_close($conn); // Close connection
?>
<script>

    $('#myTable').DataTable(
        {
            "lengthChange": false
        }
    );


    $(document).ready(function(){
        $(document).on('click', '.edit', function(){

            let id=$(this).val();

            let temp_id=$('#id'+id).text();
            let category=$('#category'+id).text();


            $('#exampleModal').modal('show');
            $('#id_category_hidden').val(id);

            $('#edit_text_category').val(category);

        });

    });



</script>
</html>
