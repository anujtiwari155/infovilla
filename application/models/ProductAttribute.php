<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lead
 *
 * @author raakesh
 */
class ProductAttribute extends ActiveRecord\Model {

    static $belongs_to = array(
       array('attributes', 'class_name' => 'AttributeValue', 'foreign_key' => 'attribute_value_id')
       //array('attribute_values')
   );

}
