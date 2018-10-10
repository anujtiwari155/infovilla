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
class Attribute extends ActiveRecord\Model {

    static $has_many = array(
       //array('childs', 'class_name' => 'Menu', 'foreign_key' => 'parent_id')
       array('attribute_values')
   );

}
