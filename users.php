<?php
    include("header.php");

    $data = file($filename);

    if(isset($_GET['delete']) && $_GET['delete'] != NULL){
      $deleteId = $_GET['delete'];
      unset($data[$deleteId]);
      file_put_contents($filename, $data);
    }

    if($_SESSION['userRole'] == "User"){
      echo"<script>window.location='user_home.php'</script>";
    }

?>
    
    <div class="container-fluid mb-5 content-body">
      <div class="row d-flex justify-content-center min-vh-100 m-1">
        <div class="col-12 p-2">
          <div class="card rounded">
              <div class="card-header text-white fw-bold d-flex">
                  <h5 class="card-title p-1 me-auto mb-0 text-uppercase">Our Users</h5>
              </div>

              <div class="card-body p-3">
                  <table class="table w-100 text-center my-5">
                    <thead>
                        <tr>
                            <th>Serial No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                      $i = 0;
                      while($user = fgetcsv($fp)){
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $user[1] . " " . $user[2] ?></td>
                            <td><?php echo $user[4] ?></td>
                            <td><?php echo $user[0] ?></td>
                            <td>
                              <a href="update_user.php?update=<?php echo $i - 1; ?>"><button class="btn btn-primary">Update</button></a>
                              <a onclick="return confirm('Are you sure to Delete!')" href="?delete=<?php echo $i - 1; ?>"><button class="btn btn-danger">Remove</button></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
    </div>
<?php
  include("footer.php");
?>