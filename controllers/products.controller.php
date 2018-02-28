<?php

class ProductsController extends Controller{

    public function __construct($data = array())
    {
        parent::__construct($data);
    }

    public function index(){

        $attrs = Shop::getAttributesByGroupID(1);

        $this->data['selected_filters'] = (isset($_REQUEST['filter']) && is_array($_REQUEST['filter'])) ? $_REQUEST['filter'] : null;



        if (!empty($attrs)){
            foreach($attrs as $row){
                $attr_result[$row['attr_title']][$row['attr_val_id']] = $row['value'];
            }
        }

        $selected_attrs_array = $attr_result;
        foreach($selected_attrs_array as $group_key => $attr_group){
            foreach($attr_group as $key => $value){
                if(!in_array($key, $this->data['selected_filters'])){
                   unset($selected_attrs_array[$group_key][$key]);
                }
            }
        }



        $filtered_product_ids = Shop::filter($selected_attrs_array);



        $this->data['products'] = Shop::getProductsListByIds($filtered_product_ids);



        $this->data['attr_result'] = $attr_result;

    }

}