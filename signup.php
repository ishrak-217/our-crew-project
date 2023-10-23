<?php
    session_start();

    if(isset($_SESSION["userSignin"]) && $_SESSION["userSignin"] === true){
        if ($_SESSION["userRole"] == "Admin") {
            header('Location: admin_home.php');
        } else {
            header('Location: user_home.php');
        }
    }

    $filename = "data/user.txt";
    $fp = fopen($filename, "a+");

    $message = "";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])){
        $firstName    = $_POST['firstName'];
        $lastName     = $_POST['lastName'];
        $userName     = $_POST['userName'];
        $userEmail    = $_POST['userEmail'];
        $userPassword = $_POST['userPassword'];
        $userRole     = "User"; 

        if(empty($firstName) || empty($lastName) || empty($userName) || empty($userEmail) || empty($userPassword)){
            $message = "<div class='alert alert-danger m-3'><strong>Error! </strong>Missing Sufficient Information</div>";
        } elseif(strlen(trim($userName)) < 4){
            $message = "<div class='alert alert-danger m-3'><strong>Error! </strong>Username is too short</div>";
        } elseif(!filter_var(trim($userEmail), FILTER_VALIDATE_EMAIL)){
            $message = "<div class='alert alert-danger m-3'><strong>Error! </strong>Invalid Email Address</div>";
        } elseif(strlen(trim($userPassword)) < 8){
            $message = "<div class='alert alert-danger m-3'><strong>Error! </strong>Password should be at least 8 characters long</div>";
        } else{
            $userPassword = md5($userPassword); 
            $userDetails = [
                "userRole"     => $userRole,
                "firstName"    => $firstName,
                "lastName"     => $lastName,
                "userName"     => $userName,
                "userEmail"    => $userEmail,
                "userPassword" => $userPassword,
            ];
        
            $result = fputcsv($fp, $userDetails, ",");

            if($result !== false){ ?>
                <script>window.location='signin.php'</script>
            <?php }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Authentication and Role Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row d-flex justify-content-center min-vh-100 m-5">
            <div class="col-lg-8 col-md-8 col-12 p-2">
            <div class="card rounded">
                <div class="card-header text-white fw-bold">
                    <h3 class="card-title p-3 m-auto text-center">Create New Account for a Crew</h3>
                </div>
                
                <?php
                    if(!empty($message)){
                        echo $message;
                    }
                ?>

                <div class="card-body p-3">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="row justify-content-center fs-5">
                            <div class="col-12 m-2">
                                <input type="text" name="firstName" placeholder="First Name" class="form-control fs-5">
                            </div>
                            
                            <div class="col-12 m-2">
                                <input type="text" name="lastName" placeholder="Last Name" class="form-control fs-5">
                            </div>

                            <div class="col-12 m-2">
                                <input type="text" name="userName" placeholder="Username" class="form-control fs-5">
                            </div>

                            <div class="col-12 m-2">
                                <input type="email" name="userEmail" placeholder="Email" class="form-control fs-5">
                            </div>

                            <div class="col-12 m-2">
                                <input type="password" name="userPassword" placeholder="Password" class="form-control fs-5">
                            </div>
                            
                            <div class="col-12 mt-5">
                                <button class="btn btn-primary shadow-none text-white w-100 fs-5" type="submit" name="signup">Sign Up</button>
                            </div>

                            <div class="col-12 mt-5">
                                <p class="text-center">Already a member? <a href="signin.php" class="text-decoration-none fw-bold">Login</a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>