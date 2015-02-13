<?php
    session_start();
    if(!empty($_POST['baseurl']) && preg_match('/^(http|https):\/\/[\w-_.]+(\/[\w-_]+)*/', $_POST['baseurl'])){
        if(!empty($_POST['username']) && !empty($_POST['key'])){
            $_SESSION['baseurl'] = $_POST['baseurl'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['key'] = $_POST['key'];
            echo "Save Success.";
        }else{
            echo "ApiUser and ApiKey cannot be empty.";
        }
       
    }else{
        echo "Baseurl invalid.";
    }

?>