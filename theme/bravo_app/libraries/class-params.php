<?php
/**
 * Created by PhpStorm.
 * User: me664
 * Date: 4/5/16
 * Time: 9:41 PM
 */
if(!class_exists('Bravo_Params')){

	class Bravo_Params{

		static $all;


		static function set($a,$b){
			self::$all[$a]=$b;
		}

		static function get($a){
			return isset(self::$all[$a])?self::$all[$a]:false;
		}
	}
}