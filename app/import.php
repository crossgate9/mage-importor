<?php
	session_start();
	set_time_limit(0);
	ini_set('max_execution_time',18000);
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
	 	//根据属性id拿到属性设置，判断是否为global和is_configurable
	 	$attrs = $client->call($sessionId,"product_attribute.info",$attr_id);
	 	if($attrs['scope']=='global'&&$attrs['is_configurable']=='1'&&$attrs['frontend_input']=='select'){
	 		$config_attr[]=$attrs;
	 	}
	 }
	 //将csv文件中select boolean 形式的label改为对应的value
	 $attr= array_combine($attr_id_code,$results);
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
			//获取已有的产品信息,判断是创建还是更新
			$products_info = $client->call($sessionId, 'catalog_product.list');
			$product_skus = array();
			foreach($products_info as $products_info_key=> $product ){
				$product_skus[$product['product_id']] = $product['sku'];
			}
			//判断是否是产品更新
			if(in_array($csv_data['sku'],$product_skus)){
				$product_sku_key = array_keys($product_skus,$csv_data['sku']);
				$product_id = $product_sku_key['0'];
				$result = $client->call($sessionId,'catalog_product.update', array($product_id,$csv_data) );
			}else{
				//判断是不是可配置产品
				if($csv_data['type']=="configurable"){
					//创建可配置产品的价格
					foreach($config_attr as $attr_key =>$scope_attr){
						$scope_attr_values = explode(';',$csv_data[$scope_attr['attribute_code']]);
						foreach ($scope_attr_values as $key => $scope_attr_value) {
							$scope_attr_value_arrays[] = explode(':', $scope_attr_value);
						}
						foreach($scope_attr_value_arrays as $k=> $scope_attr_value_array){
							$scope_attr_value_result[$scope_attr_value_array['0']]= $scope_attr_value_array['1'];
							}
							$scope_attr_value_scope[$scope_attr['attribute_code']] = $scope_attr_value_result;
					}
					
					$csv_data['price_changes'] = $scope_attr_value_scope;
					$csv_data['associated_skus'] = explode(",",$csv_data['associated_skus']);
				}
				$result = $client->call($sessionId, 'catalog_product.create', array($csv_data['type'], $set['set_id'],$csv_data['sku'],$csv_data,$csv_data['store_id']));
				$images = array('image'=>$csv_data['image'],'small_image'=>$csv_data['small_image'],'thumbnail'=>$csv_data['thumbnail']);

		        //判断图片是否设置
				foreach($images as $image_index => $image){
			        //判断是否设置产品图片路径
			            if($csv_data[$image_index]==""){
			                break;
			            }else{
			            	//判断是否有多张图片
			            	if(strstr($image,";")===false){
			            		$imagePath = $_SESSION['baseurl']."/media/import".$image;
			            		$label_index = $image_index."_label";
			            		if(!isset($csv_data[$label_index])){
			            			$csv_data[$label_index] = "";
					            }
					        $newImage = array(
					            'file' => array(
					                'name' => getImageName($image),
					                'content' => base64_encode(file_get_contents($imagePath)),
					                'mime' => getMime($image)
					            ),
					            'label' => $csv_data[$label_index],
					            'types' => array($image_index),
					            'exclude' => 0
					        );
							//使用 Api创建产品图片
							$imageFilename = $client->call($sessionId, 'product_media.create', array($result, $newImage));
					        }else{//多张图片
					        	$mult_images = explode(";", $image);
						        	foreach($mult_images as $mult_img){
					            		$imagePath = $_SESSION['baseurl']."/media/import".$mult_img;
					            		$label_index = $image_index."_label";
					            		if(!isset($csv_data[$label_index])){
					            			$csv_data[$label_index] = "";
							            }
								        $newImage = array(
								            'file' => array(
								                'name' => getImageName($mult_img),
								                'content' => base64_encode(file_get_contents($imagePath)),
								                'mime' => getMime($mult_img)
								            ),
								            'label' => $csv_data[$label_index],
								            'types' => array($image_index),
								            'exclude' => 0
								        );
										//使用 Api创建产品图片
									$imageFilename = $client->call($sessionId, 'product_media.create', array($result, $newImage));
						        	}
					        	}
		         			}
					}
				}
	}
	echo "Products Import Success!";
	session_destroy();
?>