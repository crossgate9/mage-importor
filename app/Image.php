<?php
    //获取文件名
     function getImageName($image){
        $image_arr = explode("/",$image);
        $imageName=end($image_arr);
        return $imageName;
        }
    //获取文件类型
    function getMime($image){
        $mime = "";
        $imageName=getImageName($image);
        $image_exten = explode(".",$imageName);
        $imageExten=end($image_exten);
        switch ($imageExten) {
            case 'jpg':
                $mime = "image/jpeg";
                break;
            case 'gif':
                $mime = "image/gif";
                break;
            case 'png':
                $mime = "image/png";
                break;
            case 'jpeg':
                $mime = "image/jpeg";
        }
        return $mime;
    }

?>