<?php

class login
{
	
	public function check()
	{
		require_once "Model/Database.php";
		$DB = new Database();
		$query = $DB->query("select * from users where mail='".$_POST['email']."' and pass='".$_POST['password']."'");
		
		if($DB->number()>=1){
			foreach($DB->result() as $login){
				$_SESSION['login'] = $login['id'];
				$_SESSION['user'] = $login['mail'];
				$_SESSION['money'] = $login['money'];
			}
			header("Location:../index");
		}else{
			$_SESSION['error'] = "<script>alert('Wrong username and password combination. Please try again.')</script>";
			header("Location:../index");
		}
	}

}