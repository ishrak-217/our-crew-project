<?php
    include("header.php");

    if(isset($_GET['update']) && $_GET['update'] != NULL){
        $updateId = $_GET['update'];

        $data = file($filename);

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])){
            if($_SESSION['userRole'] == "Admin"){
                $data[$updateId] = "{$_POST['role']},{$_POST['firstName']},{$_POST['lastName']},{$_POST['userName']},{$_POST['mailAddress']},{$_POST['userPassword']}";
            } else{
                $data[$updateId] = "User,{$_POST['firstName']},{$_POST['lastName']},{$_POST['userName']},{$_POST['mailAddress']},{$_POST['userPassword']}";
            }
            
            $result = file_put_contents($filename, $data);
            if($result !== false){
                if($updateId != $_SESSION['userId']){
                    echo "<script>alert('User Role Updated Successfuly!')</script>";
                    echo "<script>window.location='admin_home.php'</script>";
                } else{
                    echo "<script>alert('Profile Updated Successfuly!')</script>";
                    echo "<script>window.location='admin_home.php'</script>";
                }
            } else{
                echo "<script>alert('Something wend wrong!')</script>";
            }
        }
    } else{
        if($_SESSION['userRole'] == "User"){
            echo"<script>window.location='user_home.php'</script>";
        } else{
            echo"<script>window.location='admin_home.php'</script>";
        }
    }

      if($_SESSION['userRole'] == "User" && $updateId != $_SESSION['userId']){
        echo"<script>window.location='user_home.php'</script>";
      }
?>

    <div class="container-fluid content-body">
      <div class="row d-flex justify-content-center min-vh-100 m-1">
        <div class="col-12 p-2">
          <div class="card rounded overflow-hidden">
              <div class="card-header text-white fw-bold p-3">
                <?php if($updateId == $_SESSION['userId']){ ?>
                    <h5 class="card-title mb-0 text-uppercase">
                        <?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName']; ?>
                    </h5>
                    <p class="m-0 text-uppercase">
                        <?php echo $_SESSION['userRole']; ?>
                    </p>
                <?php } else{ ?>
                    <h5 class="card-title p-2 mb-0 text-uppercase">Update user</h5>
                <?php } ?>
              </div>

              <div class="card-body p-3">
                  <form action="" method="POST">
                    <div class="row justify-content-center fs-5">
                    <?php
                    if(isset($_GET['update']) && $_GET['update'] != NULL){
                      for($i = 0; $i < count($data); $i++){
                        if($i == $updateId){
                            $singleUserData = explode(",", $data[$i]);
                    ?>
                        <div class="col-12 mb-2">
                            <label for="firstName">First Name</label>
                            <input type="text" <?php if($updateId != $_SESSION['userId']) { ?> readonly <?php } ?> name="firstName" value="<?php echo $singleUserData[1]; ?>" class="form-control fs-5">
                        </div>
                        
                        <div class="col-12 mb-2">
                            <label for="lastName">Last Name</label>
                            <input type="text" <?php if($updateId != $_SESSION['userId']) { ?> readonly <?php } ?> name="lastName" value="<?php echo $singleUserData[2]; ?>" class="form-control fs-5">
                        </div>

                        <div class="col-12 mb-2">
                            <label for="userName">Username</label>
                            <input type="text" <?php if($updateId != $_SESSION['userId']) { ?> readonly <?php } ?> name="userName" value="<?php echo $singleUserData[3]; ?>" class="form-control fs-5">
                        </div>

                        <div class="col-12 mb-2">
                            <label for="mailAddress">Email</label>
                            <input type="text" <?php if($updateId != $_SESSION['userId']) { ?> readonly <?php } ?> name="mailAddress" value="<?php echo $singleUserData[4]; ?>" class="form-control fs-5">
                        </div>
                        
                        <?php if($_SESSION['userRole'] == "Admin") { ?>
                        <div class="col-12 mb-2">
                          <label for="role">Role</label>
                          <select name="role" class="form-select fs-5">
                            <option value="Admin" <?php if($singleUserData[0] == "Admin"){ echo "selected"; } ?> >Admin</option>
                            <option value="User" <?php if($singleUserData[0] == "User"){ echo "selected"; } ?> >User</option>
                          </select>
                        </div>
                        <?php } ?>

                        <input type="hidden" name="userPassword" value="<?php echo $singleUserData[5]; ?>">
                        
                        <div class="col-12 mt-5">
                            <input class="btn btn-primary shadow-none text-white w-100 fs-5" type="submit" name="update" value="Save">
                        </div>
                    <?php } } } ?>
                    </div>
                </form>
              </div>
          </div>
        </div>
      </div>
    </div>

<?php
  include("footer.php");
?>