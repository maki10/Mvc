<?php

class card
{

	public function __construct()
	{
		require_once "view/card.html";
	}

	private $__weight;
	private $__price;
	
	public function cards()
	{
		foreach($_SESSION['basket'] as $buy)
		{
			echo "<tr>";
			echo "<td>".$buy['name']."</td>";
			echo "<td>".$buy['price']."</td>";
			echo "<td>".$buy['kol']."</td>";
			echo "<td><a href='card/remove/".$buy['id']."' id='remove'> - </a></td>";
			echo "</tr>";
			
			if(!isset($this->__weight))
			{
				$this->__weight = $buy['weight'] * $buy['kol'];
			}
			else{
				$this->__weight = $this->__weight + $buy['weight'] * $buy['kol'];
			}
			if(!isset($this->__price))
			{
				$this->__price = $buy['price'] * $buy['kol'];
			}
			else{
				$this->__price = $this->__price + $buy['price'] * $buy['kol'];
			}
		}
	}

	private $__ship;
	
	public function shiping()
	{
		if($this->__weight<=10)
		{
			$this->__ship = 0;
			return $this->__ship;
		}elseif($this->__weight<20)
		{
			$this->__ship = 5;
			return $this->__ship;
		}
		else{
			$this->__ship = 10;
			return $this->__ship;
		}
	}
	
	private $__fullPrice;
	
	public function full_price()
	{
		$this->__fullPrice = $this->__price + $this->__ship;
		return $this->__fullPrice;
	}
	
	private $__leftMoney;
	
	public function cash_out()
	{
		$this->cards();$this->shiping();
		$price = $this->full_price();
		
			if($price > $_SESSION['money'])
			{	
				$_SESSION['error'] = "<script>alert('You dont have enough of money to buy these items. Please remove something from the Cart.')</script>";
				header("Location: ../card");	
			}
			else{	
				$this->__leftMoney = $_SESSION['money'] - $price;
				require_once "Model/Database.php";
				$DB = new Database();
					$DB->query("UPDATE users SET money='".$this->__leftMoney."' where id='".$_SESSION['login']."'");
					$_SESSION['true'] = "<script>alert('Items bought!')</script>";
					unset($_SESSION['basket']);
					$_SESSION['money'] = $this->__leftMoney;
					header("Location: ../index");
			}
	}
	
	public function add($id,$name,$price,$weight)
	{
		if(empty($name) && empty($price)){
			$_SESSION['error'] = "Something gone wrong!";
			header("Location:../../index");
		}
		
		if(!isset($_SESSION['basket'][$id]))
		{
			$kol = 1;
			$_SESSION['basket'][$id] = [
			    'id'    => $id,
				'kol' 	=> $kol,
				'name'  => $name,
				'price' => $price,
				'weight' => $weight,
			];
		}
		else{
			$kol = $_SESSION['basket'][$id]['kol'] + 1;
				$replace = ['kol' => $kol];
				$_SESSION['basket'][$id] = array_replace($_SESSION['basket'][$id], $replace);
		}
		$_SESSION['true'] = "<script>alert('Item added to Card!')</script>";
		header("Location:../../index");
	}

	
	public function remove($id)
	{
		$new_kol = $_SESSION['basket'][$id]['kol'] - 1;
		
			if($new_kol<=0)
			{
				unset($_SESSION['basket'][$id]);
			}
			else{
				$replace = ['kol' => $new_kol];
				$_SESSION['basket'][$id] = array_replace($_SESSION['basket'][$id], $replace);
			}
		$_SESSION['true'] = "<script>alert('Item removed from Card!')</script>";
		
			if(empty($_SESSION['basket']))
			{
				unset($_SESSION['basket']);
				header("Location:../../index");
			}
			else{
				header("Location:../../card");
			}
		
	}
	
	
}