<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Brand
 *
 * @author Abhishek
 */
class Group extends ActiveRecord\Model {

    //put your code here
    static $has_many = array(
        array('users_groups'),
        array('users', 'through' => 'users_group'),
    );

}
