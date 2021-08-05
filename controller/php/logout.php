<?php

    if(isset($_POST['logout'])) {
        
        session_start();
        unset($_SESSION['email']);
        session_unset();
        session_destroy(); 
        header("location: ../../index.php");
        exit();

    }


?>