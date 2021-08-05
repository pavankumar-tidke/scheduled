<?php

session_start(); 
require '../../vendor/autoload.php';
    $con = new MongoDB\Client( 'mongodb://localhost:27017' );
    $db = $con->php_mongo; $collection = $db->manager;


    if(isset($_POST['add_m_meeting'])) {

        // echo $_POST['meeting_date'];
        $st = strval($_POST['meeting_time']);
        echo '<br>';
    
        // $cursor = $collection->find(array(["datetime"=>"2021-08-04"]), ['email' => $_SESSION['email']]);
        // var_dump(count(iterator_to_array($r)));

        $record = $collection->findOne( [ 'email' =>$_SESSION['email']] );
        $datetime = iterator_to_array( $record['datetime'] );

        $isTimeInsert = false;


        foreach($datetime as $date_key=>$val) {
            if($date_key === $_POST['meeting_date']) {
                $k = count( $datetime[$date_key] );
                foreach($val as $index=>$v) {
                    if($v === $_POST['meeting_time']) {
                        echo 'time equal';
                        header('location: ../../manager/?time=equal');
                        exit();
                    }
                }    
                $r = $collection->updateOne(
                    ['email' => $_SESSION['email']],
                    ['$push' =>['datetime.'.$date_key => $_POST['meeting_time']]]
                );
                $isTimeInsert = true;
                header('location: ../../manager/?time=add');
                exit();
            }
        }
    
        // $date_key = $datetime=> $_POST['meeting_date'];

        if($isTimeInsert) {
            header('location: ../../manager/');
        }
        else {
            $r = $collection->updateOne(
                ['email' => $_SESSION['email']],
                ['$push' =>['datetime.'.$_POST['meeting_date'] => $_POST['meeting_time']]]
            );
            header('location: ../../manager/?date=add');
        }
        






    }
    else if(isset($_POST['next_date'])) {
        $date = $_POST['date'];
        // echo $date;

        $record = $collection->findOne( [ 'email' =>$_SESSION['email']] );
        $datetime = iterator_to_array( $record['datetime'] );

        foreach($datetime as $date_key=>$val) {
            if($date_key === $date) {

                    echo "<div class='morning my-5 d-flex'>
                                <i class='bi bi-brightness-alt-high text-secondary my-auto'></i>
                                <p class='text-secondary my-auto px-3'>Morning</p>
                                <div class='d-flex justify-content-start'>";
                        // foreach ( $time_arr as $key ) {
                                foreach ( $val as $k ) {
                                    if ( $k < '12:00' ) {
                                        echo "<button class='btn btn-sm btn-primary-outline border border-primary text-primary mx-3'>". $k ."</button>";
                                    }
                                }
                            // break;
                        // }
                        echo "</div>
                            </div>";
                        
                            echo "<div class='afternoon my-5 d-flex'>
                                <i class='bi bi-brightness-high text-secondary my-auto'></i>
                                <p class='text-secondary my-auto px-3'>Afternoon</p>
                                <div class='d-flex justify-content-start'>";
                        // foreach ( $time_arr as $key ) {
                                foreach ( $val as $k ) {
                                    if ( $k >= '12:00' && $k < '17:00' ) {
                                        echo "<button class='btn btn-sm btn-primary-outline border border-primary text-primary mx-3'>". $k ."</button>";
                                    }
                                }
                            // break;
                        // }
                        echo "</div>
                            </div>";

                            echo "<div class='evening my-5 d-flex'>
                            <i class='bi bi-moon text-secondary my-auto'></i>
                            <p class='text-secondary my-auto px-3'>Evening</p>
                            <div class='d-flex justify-content-start'>";
                    // foreach ( $time_arr as $key ) {
                            foreach ( $val as $k ) {
                                if ( $k >= '17:00') {
                                    echo "<button class='btn btn-sm btn-primary-outline border border-primary text-primary mx-3'>". $k ."</button>";
                                }
                            }
                        // break;
                    // }
                    echo "</div>
                        </div>";
            }
        }



    }






?>