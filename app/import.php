<?php
	session_start();
	set_time_limit(0);
	require_once "getcsv.php";
	require_once "stock_data.php";
	require_once "tier_price.php";
	require_once "Image.php";
	//连接magento api
	$url = $_SESSION['baseurl']."/index.php/api/soap/?wsdl";
	$apiUser = $_SESSION['username'];
	$apiKey = $_SESSION['key'];
	$client = new SoapClient($url);
	$sessionId = $client->login($apiUser,$apiKey);
	//获取csv文件的数据
	$csv_datas = getcsv('csv_products');
	var_dump($csv_datas);exit;
	//获取magento属性集
	$attributeSets = $client->call($sessionId,'product_attribute_set.list');
	//拿到与上传数据对应属性集的id
	foreach($attributeSets as $key=> $attributeSet){
		if($csv_datas['0']['attribute_set']==$attributeSet['name']){
			$set = $attributeSets[$key];
		}
	}
	//获取属性id 属性类型 code 
	$attributes = $client->call($sessionId,'product_attribute.list',$set['set_id']);
	
	foreach($attributes as $attribute){
		//将type为boolean 或者select的属性组装数组
		if($attribute['type']=='boolean'||$attribute['type']=='select'){
			$attr_id_code[$attribute['attribute_id']]=$attribute['code'];
		}
	}
	foreach($attr_id_code as $attr_id=>$attr_code){
	 	//根据属性id拿到属性value和label
	 	$results[] = $client->call($sessionId,"product_attribute.options",$attr_id);
	 	}

	$attr= array_combine($attr_id_code,$results);
	//将csv文件中select boolean 形式的label改为对应的value
	foreach ($csv_datas as $csv_key => $csv_data) {
	 		$websites = explode(",",$csv_data['websites']);
			$csv_data['websites'] = $websites;
			$categorys = explode(',',$csv_data['category_ids']);
			$csv_data['category_ids'] = $categorys;
			foreach($csv_data as $csv_header=>&$csv_value){
				if(in_array($csv_header,array_keys($attr))){
						foreach($attr[$csv_header] as $attr_value){
							if($csv_value==$attr_value['label']){
							    $csv_value=$attr_value['value'];
							}
						}
				}
			}
		//stock_data
			$csv_data['stock_data'] = createStockData($csv_data);

		//tier_price
			$csv_data['tier_price'] = createTierPrice($csv_data);


	 	$result = $client->call($sessionId, 'catalog_product.create', array($csv_data['type'], $set['set_id'],$csv_data['sku'],$csv_data,$csv_data['store_id']));

		$images = array('image'=>$csv_data['image'],'small_image'=>$csv_data['small_image'],'thumbnail'=>$csv_data['thumbnail']);

        //判断图片是否设置
		foreach($images as $image_index => $image){
			$label_index = $image_index."_label";
			//判断是否设置label值
				if(!isset($csv_data[$label_index])){
	            	$csv_data[$label_index] = "";
	            }
	        //判断是否设置产品图片路径
	            if($csv_data[$image_index]==""){
	                $imagePath = $_SESSION['baseurl']."/skin/frontend/base/default/images/catalog/product/placeholder/".$image_index.".jpg";
	            }else{
	                $imagePath = $_SESSION['baseurl']."/media/import/".$image;
	            }
	        $newImage = array(
	            'file' => array(
	                'name' => getImageName($image),
	                'content' => base64_encode(file_get_contents($imagePath)),
	                'mime' => getMime($image)
	            ),
	            'label' => $csv_data[$label_index],
	            'types' => array($image_index)
	        );
			//使用 Api创建产品图片
			$imageFilename = $client->call($sessionId, 'product_media.create', array($result, $newImage));
		}

	}
	echo "Products Uploaded Success.";
	 session_destroy();
?>