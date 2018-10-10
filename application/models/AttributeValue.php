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
class AttributeValue extends ActiveRecord\Model {

  static $belongs_to = array(
      array('parent_attr', 'class_name' => 'Attribute', 'foreign_key' => 'attribute_id'),
      array('attribute')
  );

}
