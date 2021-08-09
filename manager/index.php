<?php

    use MongoDB\Model\BSONArray;
    use MongoDB\Operation\Find;

    error_reporting(0);
    session_start();
    require '../vendor/autoload.php';
    if($_SESSION['email'] == '') {
        header('location: ../index.php');
    }
    $con = new MongoDB\Client( 'mongodb://localhost:27017' );
    $db = $con->php_mongo;
    $collection = $db->manager;
    $msg = '';
    // $_GET['time'] = '';

    if($_GET['time'] == 'equal') {
        $msg = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>The selected time meeting has been already scheduled!</strong> Please pick up another time scheduled.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    else if($_GET['time'] == 'add' || $_GET['time'] == 'add') {
        $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your meeting scheduled has been saved !</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } 
    else if($_GET['date'] == 'add') {
        $msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Your meeting scheduled has been saved !</strong> 
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } 


    $record = $collection->findOne( [ 'email' =>$_SESSION['email']] );
    $datetime = iterator_to_array( $record['datetime'] );

    $date_arr = [];
    $time_arr = [];

    foreach($datetime as $date_key=>$val) {
        $date_arr[] = $date_key;
        foreach($val as $index=>$v) {
            $time_arr[$date_key][] = $v;
        }    
    }
    $k = count( $date_arr );

?>

<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <link rel='shortcut icon' href='../image/favicon.ico' type='image/x-icon'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet'
        integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css'>
    <link rel='stylesheet' href='../style.css'>
    <title>Manager | Dashboard</title>
</head>

<body>

    <!-- navbar -->
    <nav class='navbar navbar-expand-lg  px-5'>
        <div class='container-fluid px-5'>
            <a class='navbar-brand fw-bold text-dark fs-3 font-monospace' href='../index.php'>Manager Dashboard</a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse'
                data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false'
                aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse d-flex flex-row-reverse' id='navbarSupportedContent'>
           
            <form action='../controller/php/logout.php' method='POST' >
                <button type='submit' name='logout' class='btn btn-outline-danger px-4 mx-5'>Log Out</button>
            </form>

             <button class='btn btn-outline-primary py-2' type='button' data-bs-toggle='modal'
                data-bs-target='#add_meeting'>schedueld Meeting</button>
            
            </div>
        </div>
    </nav>

    <?php echo $msg; ?>

    <div class='container d-flex justify-content-center shadow w-50 py-5 mt-5 bg-light'>
        <div class='slider-container'>
            <div class='slider-main d-flex justify-content-center'>
                <i class='bi bi-chevron-left text-center my-auto rounder-circle'></i>
                <div class='slider d-flex'>
                    <?php
                        
                        if($k == '') {
                            $next_date_index = 0;
                            echo '<h5 class="text-primary text-center mx-5">No meeting scheduelds</h5>';
                        }
                        else {
                            $next_date_index = $k++;
                            $d = date( 'Y-m-d' );
                            $nd = ++$d; $c = 1;
                            foreach ( $time_arr as $key=>$val ) {
                                // echo $key;
                                $d = strval($key);
                                $c_date = count($time_arr[$key]);
                                echo '<button class="btn btn-dates px-5" id="param_btn'.$c.'" onclick="display('.$c.')">
                                        <input type="date" id="param_date'.$c.'" hidden value='.$d.'>';
                                if ( $key == date( 'Y-m-d' )  ) {
                                    echo '<h5 class="text-center text-nowrap">Today</h5>';
                                    echo '<small class="text-center text-sucess text-nowrap">'. $c_date .' Slots schedule</small>';
                                } else if ( $key == $nd ) {
                                    echo '<h5 class="text-center text-nowrap">Tomorrow</h5>';
                                    echo '<small class="text-center text-sucess">'. $c_date    .' Slots schedule</small>';
                                } else {
                                    $timestamp = strtotime( $key );
                                    $day = date( 'D, d M', $timestamp );
                                    echo '<h5 class="text-center text-nowrap">'. $day .'</h5>';
                                    echo '<small class="text-center  text-sucess text-nowrap">'. $c_date .' Slots schedule</small>';
                                }
                                echo '</button>';
                                $c++;
                            }
                        }
                    ?>
                       
                </div>
                <i class='bi bi-chevron-right  text-center my-auto'></i>
            </div>
           
            <div class='detail-main d-flex justify-content-start'>
                <div class='detail' id="details">
                    <?php
                        $t = date( 'H' );
                        $timezone = date( 'e' );
                        $w = count($time_arr); $count = 0;

                            echo "<div class='morning my-5 d-flex'>
                                    <i class='bi bi-brightness-alt-high-fill  my-auto'></i>
                                    <p class=' my-auto px-3'>Morning </p>
                                    <div class='d-flex justify-content-start'>";
                            foreach ( $time_arr as $key ) {
                                    foreach ( $key as $k=>$v ) {
                                        if ( $key[$k] < '12:00' ) {
                                            echo "<button class='btn btn-sm btn-outline-success text-sucess fw-bold mx-3'>". $key[$k] ."</button>";
                                        }
                                    }
                                break;
                            }
                            echo "</div>
                                </div>";
                            
                                echo "<div class='afternoon my-5 d-flex'>
                                    <i class='bi bi-brightness-high-fill  my-auto'></i>
                                    <p class=' my-auto px-3'>Afternoon</p>
                                    <div class='d-flex justify-content-start'>";
                            foreach ( $time_arr as $key ) {
                                    foreach ( $key as $k=>$v ) {
                                        if ( $key[$k] >= '12:00' && $key[$k] < '17:00' ) {
                                            echo "<button class='btn btn-sm btn-outline-success text-sucess fw-bold mx-3'>". $key[$k] ."</button>";
                                        }
                                    }
                                break;
                            }
                            echo "</div>
                                </div>";
    
                                echo "<div class='evening my-5 d-flex'>
                                <i class='bi bi-moon-fill  my-auto'></i>
                                <p class=' my-auto px-3'>Evening</p>
                                <div class='d-flex justify-content-start'>";
                        foreach ( $time_arr as $key ) {
                                foreach ( $key as $k=>$v ) {
                                    if ( $key[$k] >= '17:00') {
                                        echo "<button class='btn btn-sm btn-outline-success text-sucess fw-bold mx-3'>". $key[$k] ."</button>";
                                    }
                                }
                            break;
                        }
                        echo "</div>
                            </div>";

                        

                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- add meeting -->
    <div class='modal fade' id='add_meeting' tabindex='-1' data-bs-backdrop='static' aria-labelledby='exampleModalLabel'
        aria-hidden='true'>
        <div class='modal-dialog  '>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='exampleModalLabel'>Add Meeting Details</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body'>
                    <form action='../controller/php/add_m.php' method='POST'>
                        <div class='my-3'>
                            <label for='' class='form-label'>Meeting Date</label>
                            <input type='date' name='meeting_date' class='form-control' id='meet_date'>
                        </div>
                        <div class='my-3'>
                            <label for='' class='form-label'>Choose Time for Meeting</label>
                            <input type='time' name='meeting_time' class='form-control' id='meet_time'>
                        </div>
                        <div class='modal-footer d-flex justify-content-between'>
                            <button type='submit' class=' btn btn-primary text-light px-3 ' name='add_m_meeting'>Add
                                Meeting</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM' crossorigin='anonymous'>
    </script>
    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
    <script src='../controller/js/manager.js'></script>
    <script>

        var date, next_date;

        function display(ind) {
            date = $(`#param_date${ind}`).val();

            let other_data = true;
            var xhr = new XMLHttpRequest();

            var url = '../controller/php/add_m.php';

            xhr.open("POST", url, true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            
            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    $('#details').html(xhr.responseText);
                }
            };

            xhr.send(`next_date=${next_date}&date=${date}`);

        }
    </script>

</body>

</html>