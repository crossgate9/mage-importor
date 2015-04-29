<?php
    session_start();
    $_result = null;
    if(!empty($_POST['baseurl']) && preg_match('/^(http|https):\/\/[\w-_.]+(\/[\w-_]+)*/', $_POST['baseurl'])){
        if(!empty($_POST['username']) && !empty($_POST['key'])){
            $_SESSION['baseurl'] = $_POST['baseurl'];
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['key'] = $_POST['key'];
            $_result = array(
                'success' => true,
                'message' => "Save Success.",
            );
        }else{
            $_result = array(
                'success' => false,
                'message' => "ApiUser and ApiKey cannot be blank.",
            );
        }
       
    }else{
        $_result = array(
            'success' => false,
            'message' => "Baseurl is invalid.",
        );
    }
    echo json_encode($_result);

?>