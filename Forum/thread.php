<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />

    <title>Welcome to Forum</title>
    <style>
    #cont2 {
        min-height: 433px;
    }
    </style>
</head>

<body>
    <?php include "partials/_header.php";?>
    <?php include "partials/_dbconnect.php";?>
    <?php
    $id= $_GET['threadid'];
    $sql="SELECT * FROM `threads` WHERE thread_id=$id";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        $title=$row['thread_title'];
        $desc=$row['thread_desc'];
        $thread_user_id=$row['thread_user_id'];
        $sql2 = "SELECT user_email FROM `users` WHERE user_id = $thread_user_id ";
        $result2 = mysqli_query($conn,$sql2);
        $row2 = mysqli_fetch_assoc($result2);
        $posted_by = $row2['user_email'];
     }
    ?>

    <!-- saving comment in database -->
    <?php
    $method= $_SERVER['REQUEST_METHOD'];
    $showAlert=false;
    if($method=='POST'){
        //incert into db
        $comment= $_POST['comment'];
        $comment = str_replace("<","&lt","$comment"); 
        $comment = str_replace(">","&gt","$comment"); 
        $user_id= $_POST['user_id']; 
        $sql="INSERT INTO `comments` ( `comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$user_id', current_timestamp())";
        $result = mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your comment hase been added.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <!-- category container starts here  -->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"> <?php echo $desc;?> </p>
            <p> posted by <?php echo $posted_by;?> </p>
            <hr class="my-4">
        </div>
    </div>
    <div class="container" id="cont2">
        
   <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
echo'<h1 class="py-2">Post a comment</h1>

<div class="container my-3">
    <form action="'.$_SERVER["REQUEST_URI"].'" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">type a comment</label>
            <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
            <input type="text" class="form-control" name="comment" id="comment" aria-describedby="emailHelp">
            <button type="submit" class="btn btn-primary">Post</button>
        </div>

    </form>
</div>';
}
else{
echo
'<h1 class="py-2">Post a comment</h1>
<p class="lead">please logIn to start a discussion</p>';
}
?>
        <div class="container" id="cont2">
            <?php
        
        $id= $_GET['threadid'];
        $sql="SELECT * FROM `comments` WHERE thread_id=$id";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
     while($row = mysqli_fetch_assoc($result)){
         $noResult = false;
         $id=$row['comment_id'];
         $content=$row['comment_content'];
         $comment_time=$row['comment_time'];
         $thread_user_id=$row['comment_by'];

         $sql2 = "SELECT user_email FROM `users` WHERE user_id = $thread_user_id ";
         $result2 = mysqli_query($conn,$sql2);
         $row2 = mysqli_fetch_assoc($result2);
    
        echo'<div class="media my-3 d-flex">
  <img src="img/user.png" width ="60px" height ="60px" class="mr-3" alt="...">
  <div class="media-body ">
     <p>'.$row2['user_email'] .' at '. $comment_time .'</p>
     <b>'.$content.'</b>
  </div>
</div>';
}
    if($noResult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <h1 class="display-6">No result found</h1>
          <p class="lead">Be the first person to ask question on this topic.</p>
        </div>
      </div>';
    }
    ?>


        </div>
    </div>
    <?php include "partials/_footer.php"?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script>
    -->
</body>

</html>