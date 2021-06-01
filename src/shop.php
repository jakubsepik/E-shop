<?php
session_start();
try{
//import tried a kofiguračných údajov
include_once('Classes.php');
$config = json_decode(file_get_contents("config.json"));


$mysqli = new mysqli($config->servername,$config->username,$config->password,$config->database);
//testovanie všetkých inputov z formulára
if(isset($_POST['name'])){
	$error =false;
	$name = trim($_POST['name']);
	if(strlen($name)<2 || strlen($name)>40){
		$error = true;
	}
	$surname = trim($_POST['surname']);
	if(strlen($surname)<2 || strlen($surname)>40){
		$error = true;
	}
	$tel_num = trim($_POST['tel_num']);
	if(preg_match("/[0-9]{10}/",$tel_num)==0){
		$error=true;
	}
	$email = trim($_POST['email']);
	if(preg_match("/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}/",$email)==0){
		$error=true;
	}
	$address = trim($_POST['address']);
	if(strlen($address)<2 || strlen($address)>255){
		$error = true;
	}
	$city = trim($_POST['city']);
	if(strlen($city)<2 || strlen($city)>255){
		$error = true;
	}
	$ps = trim($_POST['PS']);
	if(preg_match("/[0-9]{5}/",$ps)==0){
		$error=true;
	}
	$jsonId = json_decode($_POST['jsonId']);
	foreach ($jsonId as $key=>$value){
		$id_check =  $mysqli->query("SELECT * FROM items WHERE item_id=".$key)->fetch_assoc();
		$count_check = $id_check['count']-$value;
		if($id_check['item_id']=='' || $count_check<0){
			$error=true;
		}
	}
	if($error){
		throw new Exception("Prijaté chybné údaje z formulára");
	}
	//pridanie objednávky
	$orders = new Orders;
	$id = $orders->addOrder($mysqli,$name,$surname,$email,$tel_num,$city,$address,$ps);
	$order_items = new Order_items;
	foreach ($jsonId as $key=>$value){
		//pridanie objednaných itemov
		$price =  $mysqli->query("SELECT price FROM items WHERE item_id=".$key)->fetch_assoc()['price'];
		$order_items->addOrderItem($mysqli,$id,$key,$value,($price*$value));
        $count =  $mysqli->query("SELECT count FROM items WHERE item_id=".$key)->fetch_assoc()['count'];
		$x = $count-$value;
        $mysqli->query("UPDATE items SET count = ".$x." WHERE item_id =".$key);
	}
	$_SESSION['send']=true;
	//presmerovanie naspäť do eshopu
	header('Location: /');
	}
} catch (Exception $e) {
	//odchytanie chýb a výpis na obrazovku
        echo "<h2>Nastala serverová chyba</h2>";
        echo "<div>Prosím kontaktujte správcu.</div>";
        echo "<div>Výpis chyby:</div>";
        echo "<div>".$e->getMessage()."</div>";
    }
	

	
  