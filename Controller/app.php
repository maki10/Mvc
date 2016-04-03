<?php

class App
{
	
	public function __construct()
	{
		error_reporting(E_ALL & ~E_NOTICE ^ E_DEPRECATED);
		session_start();ob_start();
		$url = $_GET['url'];
		if(empty($url)){
			$url = 'index';
		}
		$url = rtrim($url, '/');
		$url = explode('/',$url);
		$url[0] = strtolower($url[0]);
		
		/*
		* HEADER INCLUDE
		*/
		require "view/header.html";
		
		$file = 'Controller/' . $url[0] . '.php';
		if(file_exists($file)){
			require "view/navigation.html";
			require $file;		
		}else{
			require "Controller/error.php";
			$err = new error();
			return false;
		}
				
		$cont = new $url[0];
		/*
		*SESSION SET UP
		*/
		include "Controller/session.php";
		$sess = new session();

		if(isset($url[2])){
			$multy = strpos($url[2], ',');
			if($multy==false){
				$cont->{$url[1]}($url[2]);
			}else{
				$mul = explode(',', $url[2]);
				$cont->{$url[1]}($mul[0],$mul[1],$mul[2],$mul[3]);
			}
		}else{
			if(isset($url[1])){
				$cont->{$url[1]}();
			}
		}
		
		/*
		* FOOTER INCLUDE
		*/
		require "view/footer.html";
	}
	
}