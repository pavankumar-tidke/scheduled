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
            $record = $collection->find();
            // $datetime = iterator_to_array( $record['datetime'] );

            print_r($record['1@gmail.com']['datetime']);

            // $isTimeSameE = false;

            foreach($datetime as $date_key=>$val) {
                foreach($val as $index=>$v) {
                    if($v === $_POST['meeting_time']) {
                        header('location: ../../employee/?e=samete');
                        exit();
                    }
                }    
            }

            // $collection = $db->employee;
            // $record = $collection->findOne( [ 'email' =>$_SESSION['email']] );
            // $datetime = iterator_to_array( $record['datetime'] );

            // if($isTimeSameE == false) {
            //     $isTimeInsert = false;
            //     foreach($datetime as $date_key=>$val) {
            //         if($date_key === $_POST['meeting_date']) {
            //             $k = count( $datetime[$date_key] );
            //             foreach($val as $index=>$v) {
            //                 if($v === $_POST['meeting_time']) {
            //                     echo 'time equal';
            //                     header('location: ../../employee/?time=equal');
            //                     exit();
            //                 }
            //             }    
            //             $r = $collection->updateOne(
            //                 ['email' => $_SESSION['email']],
            //                 ['$push' =>['datetime.'.$date_key => $_POST['meeting_time']]]
            //             );
            //             $isTimeInsert = true;
            //             header('location: ../../employee/?time=add');
            //             exit();
            //         }
            //     }
            //     if($isTimeInsert) {
            //         header('location: ../../employee/');
            //     }
            //     else {
            //         $r = $collection->updateOne(
            //             ['email' => $_SESSION['email']],
            //             ['$push' =>['datetime.'.$_POST['meeting_date'] => $_POST['meeting_time']]]
            //         );
            //         header('location: ../../employee/?time&date=add');
            //     }
            // }
            
        }
        



        






        
        $add_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Meeting added!</strong> Your Meeting scheduld has been added successfully !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

        // header('location: ../../manager/');
    }






?>