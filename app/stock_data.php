<?php

    function createStockData($product_value){

        $product_value['stock_data'] = array(
                'qty'=>$product_value['qty'],
                'is_in_stock'=>$product_value['is_in_stock'],
                'use_config_manage_stock'=>$product_value['use_config_manage_stock'],
                'min_qty'=>$product_value['min_qty'],
                'use_config_min_qty'=>$product_value['use_config_min_qty'],
                'is_in_stock'=>$product_value['is_in_stock'],
                'min_sale_qty'=>$product_value['min_sale_qty'],
                'use_config_min_sale_qty'=>$product_value['use_config_min_sale_qty'],
                'max_sale_qty'=>$product_value['max_sale_qty'],
                'use_config_max_sale_qty'=>$product_value['use_config_max_sale_qty'],
                'is_qty_decimal'=>$product_value['is_qty_decimal'],
                'backorders'=>$product_value['backorders'],
                'use_config_backorders'=>$product_value['use_config_backorders'],
                'notify_stock_qty'=>$product_value['notify_stock_qty'],
                'use_config_notify_stock_qty'=>$product_value['use_config_notify_stock_qty']
                );
        return $product_value;
    }
?>