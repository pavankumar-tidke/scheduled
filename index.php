<?php
    error_reporting(0);
    session_start();
    require './vendor/autoload.php';
    $con = new MongoDB\Client( 'mongodb://localhost:27017' );
    $db = $con->php_mongo;
    $auth_msg = ''; 
    
    if($_GET['auth'] == 'failed') {
        $auth_msg = '<div class="alert alert-danger alert-dismissible fade show " role="alert">
                        <strong>Wrong Credentials !</strong> Please try again.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }
    else if($_GET['login'] == 'now') {
        $auth_msg = '<div class="alert alert-success alert-dismissible fade show " role="alert">
                        <strong>Your account created successfully !</strong> Login Now !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
    }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="./image/favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Scheduld yourself !</title>
</head>

<body >

    <?php echo $auth_msg; ?>


        <div class="container d-flex justify-content-center align-middle text-center flex-column" style="margin-top: 65px;">
                <h1 class="text-center text-uppercase fw-bold font-monospace">Dashboard</h1>

                <div class="d-flex justify-content-center mt-5">
                <div class="border shadow manager bg-light w-25 pb-4 rounded-3" style="margin-right: 25px;">
                        <p class="bg-primary text-center p-2 text-light rounded-top fw-bold">Manager</p>
                        <button type="button" class="btn btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#manager_signup">Sign Up</button><br>
                        <button type="button" class="btn btn-outline-primary mt-3 px-4" data-bs-toggle="modal" data-bs-target="#manager_login">Login</button>
                  </div>

                  <div class="border shadow manager w-25 bg-light pb-4 rounded-3">
                        <p class="bg-primary text-center p-2 text-light rounded-top fw-bold">Employee</p>
                        <button type="button" class="btn btn-outline-primary px-3" data-bs-toggle="modal" data-bs-target="#employee_signup">Sign Up</button><br>
                        <button type="button" class="btn btn-outline-primary mt-3 px-4" data-bs-toggle="modal" data-bs-target="#employee_login">Login</button>
                  </div>
                </div>
                </div>
 
    <!-- modals -->

    <!-- sign up Modal -->
    <div class="modal fade" id="employee_signup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">
                    <form class="container" action="./controller/php/signup.php" method="POST">
                        <div class="mb-3">
                            <label for="number" class="form-label ">Employee ID</label>
                            <input type="number" name="empid" class="form-control" id="empsid" aria-describedby="empid">
                            <small class="small" id="empsid_small"></small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="empsemail" aria-describedby="email">
                            <small class="small" id="empsemail_small"></small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control" id="empspass" aria-describedby="password">
                            <small class="small" id="empspass_small"></small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="empsconf_pass" aria-describedby="password">
                            <small class="small" id="empsconf_pass_small"></small>
                        </div>
                        <div class="d-grid gap-2 my-3">
                            <button type="submit" name="employee_signup" class="btn btn-primary py-2">Create Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--Login Modal -->
    <div class="modal fade" id="employee_login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Log In as Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body e-log">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="./image/default_user.png" height="70" alt="">
                    </div>
                    <form class=" container e_log_form" action="./controller/php/login.php" method="POST">
                        <div class="mb-3">
                            <label for="number" class="form-label">Employee ID</label>
                            <input type="number" name="empid" class="form-control" id="log_empid"
                                aria-describedby="empid">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control" id="log_pass"
                                aria-describedby="password">
                        </div>
                        <div class="d-grid gap-2 my-5">
                            <button type="submit" class="btn btn-primary py-2" name="employee_login">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>










    <!-- manager modals -->
    <!-- sign up Modal -->
    <div class="modal fade" id="manager_signup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Your Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body container">
                    <form class="container" action="./controller/php/signup.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" id="msemail" aria-describedby="email">
                            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass" id="mspass"
                                aria-describedby="password">
                        </div>
                        <!-- <div class="mb-3">
                          <label for="password" class="form-label">Confirm Password</label>
                          <input type="password" class="form-control" name="conf_pass" id="conf_pass" aria-describedby="password">
                      </div> -->
                        <div class="d-grid gap-2 my-3">
                            <button type="submit" class="btn btn-primary py-2" name="manager_signup">Create
                                Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--Login Modal -->
    <div class="modal fade" id="manager_login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Log In as Manager</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body e-log">
                    <div class="d-flex justify-content-center mb-4">
                        <img src="./image/default_user.png" height="70" alt="">
                    </div>
                    <form class="container e_log_form" action="./controller/php/login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" id="log_empid"
                                aria-describedby="empid">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="pass" class="form-control" id="log_pass"
                                aria-describedby="password">
                        </div>
                        <div class="d-grid gap-2 my-5">
                            <button type="submit" class="btn btn-primary py-2" name="manager_login">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="./controller/js/index.js"></script>
</body>

</html>