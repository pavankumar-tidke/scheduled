<?php

session_start();
require '../../vendor/autoload.php';
    $con = new MongoDB\Client( 'mongodb://localhost:27017' );
    $db = $con->php_mongo; 


    if(isset($_POST['add_e_meeting'])) {

        // echo $_POST['meeting_date'];
        $st = strval($_POST['meeting_time']);
        echo '<br>';

    
        $collection = $db->manager;
        $record = $collection->findOne();
        $datetime = iterator_to_array( $record['datetime'] );

        $isTimeSame = false;
        
        foreach($datetime as $date_key=>$val) {
            foreach($val as $index=>$v) {
                if($v === $_POST['meeting_time']) {
                    $isTimeSame = true;
                    header('location: ../../employee/?e=sametm');
                    exit();
                }
            }    
        }

        
        if($isTimeSame == false) {
            $collection = $db->employee;
            // $record = $collection->find();
            // $datetime = iterator_to_array( $record['datetime'] );

            // print_r($record['1@gmail.com']['datetime']);

            // $isTimeSameE = false;

            // foreach($datetime as $date_key=>$val) {
            //     foreach($val as $index=>$v) {
            //         if($v === $_POST['meeting_time']) {
            //             header('location: ../../employee/?e=samete');
            //             exit();
            //         }
            //     }    
            // }

            $collection = $db->employee;
            $record = $collection->findOne( [ 'email' =>$_SESSION['email']] );
            $datetime = iterator_to_array( $record['datetime'] );

            // if($isTimeSameE == false) {
                $isTimeInsert = false;
                foreach($datetime as $date_key=>$val) {
                    if($date_key === $_POST['meeting_date']) {
                        $k = count( $datetime[$date_key] );
                        foreach($val as $index=>$v) {
                            if($v === $_POST['meeting_time']) {
                                echo 'time equal';
                                header('location: ../../employee/?time=equal');
                                exit();
                            }
                        }    
                        $r = $collection->updateOne(
                            ['email' => $_SESSION['email']],
                            ['$push' =>['datetime.'.$date_key => $_POST['meeting_time']]]
                        );
                        $isTimeInsert = true;
                        header('location: ../../employee/?time=add');
                        exit();
                    }
                }
                if($isTimeInsert) {
                    header('location: ../../employee/');
                }
                else {
                    $r = $collection->updateOne(
                        ['email' => $_SESSION['email']],
                        ['$push' =>['datetime.'.$_POST['meeting_date'] => $_POST['meeting_time']]]
                    );
                    header('location: ../../employee/?date=add');
                }
            // }
            
        }
        


        // header('location: ../../manager/');
    }
    else if(isset($_POST['next_date'])) {
        $date = $_POST['date'];
        // echo $date;
        
        $collection = $db->employee;
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