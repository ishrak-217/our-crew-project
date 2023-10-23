<?php
    session_start();

    if(!isset($_SESSION["userSignin"]) || $_SESSION["userSignin"] != true) {
      echo "<script>window.location='signin.php'</script>";
      exit();
    }

    $filename = "data/user.txt";
    $fp = fopen($filename, "a+");

    if(isset($_GET['action']) && $_GET['action'] == "logout"){
      session_unset();
      session_destroy();
      echo "<script>location='signin.php'</script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
      $path = $_SERVER['SCRIPT_FILENAME'];
      $current = basename($path, ".php");
    ?>
    <title>
      <?php 
        if($current == "admin_home"){
          echo"Admin-";
        } elseif($current == "user_home"){
          echo "Home-";
        } elseif($current == "users"){
          echo "All User-";
        } else{
          echo "Update User-";
        }
      ?>Role Management and User Authentication system
    </title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container-fluid">
      <div class="row">
        <?php
          $path = $_SERVER['SCRIPT_FILENAME'];
          $current = basename($path, ".php");
        ?>
        <nav class="navbar navbar-expand-lg bg-dark shadow-sm fw-bold fixed-top">
          <div class="container-fluid">
            <a class="navbar-brand text-white" href="#"><h3>Role Management and User Authentication System</h3></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav ms-auto text-uppercase">
              <?php if($_SESSION['userRole'] == "Admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link text-white" aria-current="page" href="admin_home.php" <?php if($current == "admin_home"){ ?> id="active" <?php } ?> >Home</a>
                </li>
              <?php } else{ ?>
                <li class="nav-item">
                  <a class="nav-link text-white" aria-current="page" href="user_home.php" <?php if($current == "user_home"){ ?> id="active" <?php } ?> >Home</a>
                </li>
              <?php } ?>
              <?php if($_SESSION['userRole'] == "Admin"){ ?>
                <li class="nav-item">
                  <a class="nav-link text-white" aria-current="page" href="users.php" <?php if($current == "users"){ ?> id="active" <?php } ?> >Users</a>
                </li>
              <?php } ?>
                <li class="nav-item dropdown ms-5">
                  <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user"></i>
                    <?php echo $_SESSION['firstName']. " " .$_SESSION['lastName']; ?>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item logout" href="admin_home.php?action=logout">Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>