<?php

class item
{


	public function __construct()
	{
		require_once "Model/Database.php";
		$DB = new Database();
		$query = $DB->query("select type from items");
		
			if($DB->number()>=1){
					echo "<option value=\"NONE\">~~SELECT~~</option>";
					echo "<option value=\"\">ALL</option>";
			foreach($DB->unique_result() as $drop){
				echo "<option value=".$drop['type'].">". $drop['type'] . "</option>";
			}
		}
	}

	public function avabile_item($type=false)
	{
		require_once "Model/Database.php";
		$DB = new Database();
		
			if($type==false){
				$DB->query("select * from items");
			}else{
				$items = $DB->query("select * from items where type='".$type."'");
			}
			
			if($DB->number()>=1){
				foreach($DB->result() as $item){
					echo "<tr>";
					echo "<td>".$item['name']."</td>";
					echo "<td>".$item['price']."</td>";
					echo "<td>".$item['type']."</td>";
					echo "<td>".$item['weight']."</td>";
					echo "<td><a href=\"card/add/".$item['id'].",".$item['name'].",".$item['price'].",".$item['weight']."\"> + </a></td>";
					echo "</tr>";
				}
			}
	}

}