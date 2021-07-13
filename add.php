<html>
<?php include "assets/include_header/header.php" ?>

<body>
    <div id="main_container">

        <!--Add few elements to the form-->
        <div class="show_box" id="show_box">
            <form method="POST">
                <textarea required id="text" class="specific_text" name="text" placeholder="Write Some Text ..." required></textarea>


                <div class="show_box">

                    <select required style="width: 40pc; font-weight: 500" class="another" name="basic[]" id="mutiple_select" multiple="multiple" data-live-search="true">

                        <?php
                        include "config.php";


                        $query = "SELECT  DISTINCT category FROM category_list";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            die('Query Failed' . mysqli_error());
                        }
                        while ($row = mysqli_fetch_assoc($result)) {
                            $category = $row['category'];
                            echo "<option name='$id'  value='$category'>$category</option>";
                        }
                        mysqli_close($conn);
                        ?>


                    </select>
                    <!-- <input type="text" name="custom" id="custom"/> -->
                </div>


                <div class="div_specific" style="margin-left: 4px;">

                    <button type="submit" id="add" name="submit" class="btn btn-primary" onclick="multiply()">Add</button>
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
    let adddata = [];
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
            if (e.params.data.isNew) {
                adddata.push(e.params.data.text);
                console.log(adddata);
                $(this).find('[value="' + e.params.data.id + '"]').replaceWith('<option selected value="' + e.params.data.id + '">' + e.params.data.text + '</option>');
            }

        }).on('select2:unselect', function (e) {
            let temp_remove = e.params.data.text;
            $(this).find('[value="' + e.params.data.id + '"]').remove();
            removeData(temp_remove);
        });

    });

    function multiply() {
        console.log("here in ajax")

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
// Using database connection file here
include "config.php";
if (isset($_POST['submit'])) {
    //    $data = $_POST['text'];
    $data = mysqli_real_escape_string($conn, $_POST['text']);
    $category = $_POST['basic'];
    $temp_cat_json = json_encode($category);
    $insert = mysqli_query($conn, "INSERT INTO `text_list`(`data`, `category`) VALUES ('$data','$temp_cat_json')");

    if (!$insert) {
        echo $insert;
        echo mysqli_error();
    } else {
        echo "<script>window.open('paginate.php','_self')</script>";
    }
}

mysqli_close($conn); // Close connection
?>