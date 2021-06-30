<!DOCTYPE html>
<html lang="en">
<?php include"assets/include_header/header.php"?>
<body>
<div id="main_container">
    <!--          <div id="edit">-->

    <!--Add few elements to the form-->
    <div id="show_box" class="show_box_index">
         <h3 style=" color: #9e9e9e;font-family: monospace; margin-left: 177px; font-weight: 700;">Life Rotator<h3>
                 <br>
                 <br>
            <?php
            include "config.php";


            $query = "SELECT * FROM category_list";
            $result = mysqli_query($conn, $query);

            if (!$result) {
                die('Query Failed' . mysqli_error());
            }
            while ($row = mysqli_fetch_assoc($result)) {

                $category = $row['category'];
                echo "<button id='category_shown_index' type='button' onclick=document.location='paginate.php' class='btn btn-primary' >$category</button><br><br>";
            }
            mysqli_close($conn);
            ?>
                 <br>
                 <br>

                 <input type="button" id="bt_add_index" onclick="document.location='add.php'" class="button_radius" value="+"/>
<!--                 <button class="btn-info" id="add_button">-->
<!--      <span onclick="document.location='add.php'">-->
<!--           +-->
<!--      </span>-->
<!--                 </button>-->
<!--        <button id='add_button' type='button' class='btn-info'  onclick="document.location='add.php'"> + </button>-->

    </div>

    <!--        </div>-->
    


<!-- Modal -->



</body>
<script>


</script>


</html>
