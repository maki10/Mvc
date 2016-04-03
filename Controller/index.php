<?php

class index
{
	
	public function __construct()
	{
		if(isset($_SESSION['login'])){
			$this->index();
		}
	}
	
	public function index()
	{
		require "Controller/item.php";
		require "View/all_item.html";
	}

}