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
    $id= $_GET['catid'];
     $sql="SELECT * FROM `categories` WHERE category_id =$id";
     $result = mysqli_query($conn,$sql);
     while($row = mysqli_fetch_assoc($result)){
       $catname=$row['category_name'];
       $catdesc=$row['category_description'];
     }
    ?>
    <?php
    $method= $_SERVER['REQUEST_METHOD'];
    $showAlert=false;
    if($method=='POST'){
        //incert into db
        $th_title= $_POST['title'];

        //replacing "<" and ">" so that string incerction is not possible
        $th_title = str_replace("<","&lt","$th_title"); 
        $th_title = str_replace(">","&gt","$th_title"); 
        $th_desc= $_POST['desc'];

        //replacing "<" and ">" so that string incerction is not possible
        $th_desc = str_replace("<","&lt","$th_desc"); 
        $th_desc = str_replace(">","&gt","$th_desc"); 
        $user_id= $_POST['user_id'];
        $sql="INSERT INTO `threads` ( `thread_title`,`thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ( '$th_title', '$th_desc', '$id', '$user_id', current_timestamp())";
        $result = mysqli_query($conn,$sql);
        $showAlert=true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread hase been added please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>


    <!-- category container starts here  -->
    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> Forum</h1>
            <p class="lead"> <?php echo $catdesc;?> </p>
            <hr class="my-4">
            <p>It is a peer to peer forum to share knowlege with each other.</p>
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="container" id="cont2">
        <h1 class="py-2">Browse Questions</h1>
        
        <?php    
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
       echo'<div class="container my-3">
            <form action="' . $_SERVER["REQUEST_URI"].'" method="post">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Problem Title</label>
            <input type="text" class="form-control" name="title" id="exampleInputEmail1" aria-describedby="emailHelp">
            <label for="exampleInputEmail1" class="form-label">Enter your concern</label>
            <input type="hidden" name="user_id" value="'.$_SESSION['user_id'].'">
            <input type="text" class="form-control" name="desc" id="exampleInputEmail1" aria-describedby="emailHelp">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>

        </form>
    </div>';
    }
    else{
        echo
    '<div class="container">please log in to post.</div>';
    }
    ?>

    <?php
        
        $id= $_GET['catid'];
        $sql="SELECT * FROM `threads` WHERE thread_cat_id=$id";
        $result = mysqli_query($conn,$sql);
        $noResult = true;
     while($row = mysqli_fetch_assoc($result)){
         $noResult = false;
         $title=$row['thread_title'];
         $desc=$row['thread_desc'];
         $tid=$row['thread_id'];
         $thread_time=$row['timestamp'];
         $thread_user_id=$row['thread_user_id'];
         $sql2 = "SELECT user_email FROM `users` WHERE user_id = $thread_user_id ";
         $result2 = mysqli_query($conn,$sql2);
         $row2 = mysqli_fetch_assoc($result2);
    
        echo'<div class="media my-3 d-flex">
  <img src="img/user.png" width ="60px" height ="60px" class="mr-3" alt="...">
  <div class="media-body">
    <h5 class="mx-0"><a class="text-dark" href="thread.php?threadid='.$tid.'">'.$title.'</a></h5>
    '.$desc.'
    <p><b>'.$row2['user_email'] .'</b> at '.$thread_time.'</p>
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