<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Page extends ActiveRecord\Model{
    
	  static $belongs_to =array(
        array('menu')
    );

}