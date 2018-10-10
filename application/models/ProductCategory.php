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
class ProductCategory extends ActiveRecord\Model {

    static $belongs_to = array(
       array('category', 'class_name' => 'Category', 'foreign_key' => 'category_id')
       //array('attribute_values')
   );

}
