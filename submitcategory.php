
<?php

include "config.php";

   $data= $_POST['data'];
  
   $length = count($data);
for ($i = 0; $i < $length; $i++) {
    if ($data[$i]==''){

    }
    else{

        $results = mysqli_query($conn, "SELECT * FROM category_list WHERE category ='$data[$i]'");
        $rows = mysqli_num_rows($results);
         if($rows === 0) { 
        $insert = mysqli_query($conn, "INSERT INTO `category_list`(`category`) VALUES ('$data[$i]')"); 
        }
      
       else{
           echo $query;
           
       }
  }
   
}
    


mysqli_close($conn); // Close connection
?>
