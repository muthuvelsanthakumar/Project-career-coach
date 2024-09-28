<?php

$conn = mysqli_connect("localhost", "root", "", "career_coach");
         
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. "
                . mysqli_connect_error());
        }
         
        // Taking all 3 values from the form data(input)
        $username =  $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $password =  $_REQUEST['password'];
         
        // Performing insert query execution
        // here our table name is users
        $sql = "INSERT INTO Users  VALUES ('$username', 
            '$email','$password')";
         
        if(mysqli_query($conn, $sql)){
            echo "<script>alert(' you are created a account  successfully.'); </script>" ;
            header("Location: ../mainpages/index1.html");
 
        } else{
            echo "ERROR: Hush! Sorry $sql. "
                . mysqli_error($conn);
                exit();
                
        }
         
        // Close connection
        mysqli_close($conn);
  ?>
