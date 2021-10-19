<?php
$showError=false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include '_dbconnect.php';
    $user_email = $_POST['signupEmail'];
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    //cheacking if email already exists
    $exitSql = "select * from `users` where user_email = '$user_email'";
    $result = mysqli_query($conn,$exitSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError = "E-mail already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` ( `user_email`, `user_password`, `timestamp`) VALUES ( '$user_email', '$hash', current_timestamp())";
            $result = mysqli_query($conn,$sql);
            echo "true";
            if($result){
                $showAlert = true;
                header("location: /forum/index.php?signupsuccess=true");
                exit;
            }

        }
        else{
            header("location:/forum/index.php?wpassword");
        }
    }
    header("location:/forum/index.php?signupsuccess=false&error=$showError");
}

?>