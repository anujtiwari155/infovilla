<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lead
 *
 * @author Abhishek
 */
class ProductImage extends ActiveRecord\Model {

    // static $has_one = array(
    // 	array('image')
    // );
    static $belongs_to = array(
    	array('product_image', 'class_name' => 'Image', 'foreign_key' => 'image_id'),
    );
}
