<?php

require '../../vendor/autoload.php';

$con = new MongoDB\Client( 'mongodb://localhost:27017' );
$db = $con->php_mongo;

if(isset($_POST['manager_login'])) {
    $collection = $db->manager;

    $email = $_POST['email'];
    $pass = $_POST['pass'];

    $record = $collection->findOne( [ 'email' =>$email ]);  

    if($record) {
        if(password_verify( $pass, $record['password'])) {
            session_start();
            $_SESSION['email'] = $record['email'];
            header('location: ../../manager/');
            exit();
        }
        else {
            header('location: ../../?auth=failed');
        }
    }
    else {
        header('location: ../../?auth=failed');
    }


    // password_verify( $password, $row['Password']);

    // $collection->insertOne( ['email' =>$_POST['email'], 'password' =>$hash] );
    
    
 
}
else if(isset($_POST['employee_login'])) {
    $collection = $db->employee;

    $empid = $_POST['empid'];
    $pass = $_POST['pass'];

    $record = $collection->findOne( [ 'empid' =>$empid ]);  

    if($record) {
        if(password_verify( $pass, $record['password'])) {
            session_start();
            $_SESSION['email'] = $record['email'];
            header('location: ../../employee/');
            exit();
        }
        else {
            header('location: ../../?auth=failed');
        }
    }
    else {
        header('location: ../../?auth=failed');
    }


    // password_verify( $password, $row['Password']);

    // $collection->insertOne( ['email' =>$_POST['email'], 'password' =>$hash] );
    
    

}






?>