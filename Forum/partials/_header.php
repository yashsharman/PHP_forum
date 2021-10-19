<?php
session_start();

echo'<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum">Forum</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      </ul>';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo'<form class="d-flex" method="get" action="/forum/search.php">
          <input class="form-control me-1 p-0 m-0" type="search" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
          <p class="text-light text-center my-0 px-2 py-2">'.$_SESSION['useremail'].'</p>
          </form>
          <a href="partials/_logout.php" class="btn btn-outline-success">Log Out</a>';

      }
      else{
      echo'<form class="d-flex" method="get" action="/forum/search.php">
          <input class="form-control me-1 p-0 m-0" type="search" name="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-success" type="submit">Search</button>
          </form>
        <div class="mx-2">
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#loginModal">LogIn</button>
            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>';

          }
echo'</div>
    </div>
  </div>
</nav>';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';
if(isset($_GET['signupsuccess'])&& $_GET['signupsuccess']=='true'){
echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
<strong>Success!</strong> Your account have been created please login.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
else{
if(isset($_GET['signupsuccess'])){
  echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> Your password doesnot match.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
}
?>