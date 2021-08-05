<?php

require '../../vendor/autoload.php';

$con = new MongoDB\Client( 'mongodb://localhost:27017' );
$db = $con->php_mongo; 

if(isset($_POST['manager_signup'])) {
    $collection = $db->manager;

    $pass = $_POST['pass'];
    $hash = password_hash( $pass, PASSWORD_DEFAULT );

    $collection->insertOne( ['email' =>$_POST['email'], 'password' =>$hash] );
    
    header('location: ../../index.php?s=login=now');
    // echo 'Account created success';

}
else if(isset($_POST['employee_signup'])) {
    $collection = $db->employee;

    $pass = $_POST['pass'];
    $hash = password_hash( $pass, PASSWORD_DEFAULT );
    $datetime= (Object)[];

    $collection->insertOne( ['empid' =>$_POST['empid'], 'email' =>$_POST['email'], 'password' =>$hash, 'datetime'=> $datetime] );
    
    header('location: ../../index.php?s=login=now');
    // echo 'Account created success';

}
// $record = $collection->find( [ 'email' =>'Peter@gmail.com'] );

// foreach ( $record as $manager ) {
//     echo $manager['email'], ': ', $manager['password'].'<br>';
// }

?>