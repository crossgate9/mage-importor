<?php
    function createTierPrice($product_value){
        if(isset($product_value['customer_group_id'])){
            $customer_group_id =explode(',',$product_value['customer_group_id']); 
            $tier_price_website =explode(',',$product_value['tier_price_website']); 
            $tier_price_qty =explode(',',$product_value['tier_price_qty']);
            $tier_price_price =explode(',',$product_value['tier_price_price']);

                foreach($customer_group_id as $key =>$tier_value){

                    $product_value['tier_price'][]=array(
                        'website' =>$tier_price_website[$key],
                        'customer_group_id' =>$tier_value,
                        'qty' =>$tier_price_qty[$key],
                        'price' =>$tier_price_price[$key],
                        );
                } 
                return $product_value['tier_price'];
        }
    }
?>