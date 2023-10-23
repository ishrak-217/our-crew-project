<?php
include "header.php";

$data = file( $filename );

if ( isset( $_GET['delete'] ) && $_GET['delete'] != NULL ) {
    $deleteId = $_GET['delete'];
    unset( $data[$deleteId] );
    file_put_contents( $filename, $data );
}

if ( $_SESSION['userRole'] == "User" ) {
    echo "<script>window.location='user_home.php'</script>";
}

?>

    <div class="container-fluid content-body">
      <div class="row d-flex justify-content-center min-vh-100 m-1">
        <div class="col-12 p-2">

          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Hi <?php echo $_SESSION['firstName']; ?>!</strong> Welcome to your dashboard
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>

          <div class="container-fluid mb-4">
              <div class="row text-uppercase">
                <h2><?php echo $_SESSION['firstName'] . " " . $_SESSION['lastName'] ?></h2>
                <h5><?php echo $_SESSION['userRole']; ?></h5>
              </div>
          </div>

          <div class="container mb-5 mt-5">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-12">
                    <div class="card">
                      <div class="card-body text-center">
                          <h1 class="display-1 fw-bold">
                          <?php
$count = 0;

if ( $data ) {

    for ( $i = 0; $i < count( $data ); $i++ ) {
        $singleUserData = explode( ",", $data[$i] );

        if ( $singleUserData[0] == "User" ) {
            $count++;
        }

    }

    echo $count;
} else {
    echo "0";
}

?>
                          </h1>
                      </div>
                      <div class="card-footer">
                        <p class="m-0 fw-bold">Users</p>
                      </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-12">
                    <div class="card">
                      <div class="card-body text-center">
                          <h1 class="display-1 fw-bold">
                          <?php
$count = 0;

if ( $data ) {

    for ( $i = 0; $i < count( $data ); $i++ ) {
        $singleUserData = explode( ",", $data[$i] );

        if ( $singleUserData[0] == "Admin" ) {
            $count++;
        }

    }

    echo $count;
} else {
    echo "0";
}

?>
                          </h1>
                      </div>
                      <div class="card-footer">
                        <p class="m-0 fw-bold">Admins</p>
                      </div>
                    </div>
                </div>
            </div>
          </div>
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

while ( $user = fgetcsv( $fp ) ) {
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
                    <?php }

?>
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
    </div>
<?php
include "footer.php";
?>