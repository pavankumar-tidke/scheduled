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
            header('location: ../../manager/?time&date=add');
        }
        







        
        $add_msg = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Meeting added!</strong> Your Meeting scheduld has been added successfully !
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

        // header('location: ../../manager/');
    }






?>