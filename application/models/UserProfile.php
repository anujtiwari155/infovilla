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
class UserProfile extends ActiveRecord\Model {

    //put your code here
    static $belongs_to = array(
    	'user'
    );

}
