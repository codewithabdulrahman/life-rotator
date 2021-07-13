<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include "assets/include_header/header.php" ?>

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

                    $queryText = "SELECT  DISTINCT category FROM text_list";
                    $query = "SELECT DISTINCT category FROM category_list";

                    $result = mysqli_query($conn, $query);
                    $textResult = mysqli_query($conn, $queryText);

                    if (!$result) {
                        die('Query Failed' . mysqli_error());
                    }

                    if (!$textResult) {
                        die('Query Failed' . mysqli_error());
                    }

                    $categories = array();
                    while ($category =  mysqli_fetch_assoc($result)) {
                        $categories[] = $category;
                    }

                    $texts = array();
                    while ($t =  mysqli_fetch_assoc($textResult)) {
                        $texts[] = $t;
                    }

                    // echo '<br><pre>$categories: '.print_r($categories,true).'</pre><br>';
                    // echo '<br><pre>$texts: '.print_r($texts,true).'</pre><br>';

                    foreach ($categories as $val) {

                        $category = $val['category'];

                        $found = 0;

                        foreach ($texts as $t) {

                            $cat = json_decode($t['category'], true);

                            if (count($cat) > 0) {
                                foreach ($cat as $c) {

                                    if (trim($c) == trim($category)) {
                                        $found = 1;
                                    }
                                }
                            }
                        }

                        // echo $found;
                        if ($found == 1) {
                            echo "<button id='category_shown_index' type='button' onclick=document.location='paginate.php?temp=$category' class='btn btn-primary' >$category</button><br><br>";
                        }
                    }

                    // mysqli_close($conn);
                    ?>
                    <br>
                    <br>

                    <input type="button" id="bt_add_index" onclick="document.location='add.php'" class="button_radius" value="+" />
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