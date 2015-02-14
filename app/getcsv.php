<?php
    function getcsv($fileName){
        $file = $_FILES[$fileName];
        $fileType = substr(strstr($file['name'],'.'),1);
        if($fileType!= 'csv'){
            echo "File type invalid.";
            exit;
        }
        $handle = fopen($file['tmp_name'],'r');
            while($data = fgetcsv($handle)){
                if(count(array_filter($data))!="0"){
                    $datas[]=$data;
                }
            }
             for($i=1;$i<count($datas);$i++){
                $product_info[]= array_combine($datas[0],$datas[$i]);
            }
            return $product_info;
    }
 