<?php

class session
{


	public function __construct()
	{
		if(isset($_SESSION['error'])){
			echo $_SESSION['error'];
			unset($_SESSION['error']);
		}
		
		if(!isset($_SESSION['login'])){
			require "View/login.html";
		}
		
		if(isset($_SESSION['true'])){
			echo $_SESSION['true'];
			unset($_SESSION['true']);
		}

	}


}