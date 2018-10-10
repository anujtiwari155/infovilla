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
class Inventory extends ActiveRecord\Model {

    //put your code here
    static $belongs_to = array("product",
    	array('pro_vendor', 'class_name' => 'User', 'foreign_key' => 'user_id')
    );

}
