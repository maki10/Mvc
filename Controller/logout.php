<?php

class logout
{


	public function __construct()
	{
		unset($_SESSION['login']);
		unset($_SESSION['user']);
		unset($_SESSION['basket']);
		unset($_SESSION['money']);
		session_destroy();
		header("Location:index");
	}


}