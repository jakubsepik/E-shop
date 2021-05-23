<?php
include_once("Classes.php");

if(isset($_POST['name'])){
  echo $_POST['name'];
  echo print_r($_SESSION['items']);
}
$config = json_decode(file_get_contents("config.json"));

$mysqli = new mysqli($config->servername,$config->username,$config->password,$config->database);


$items_array = array();
$result = $mysqli->query("SELECT * FROM items");

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    array_push($items_array,new Items($row));
  }
} else {
  echo "Shop is empty";
}

foreach($items_array as $item){
  echo print_r($item->getDataArray());
  $data = $item->getDataArray();
  echo "<div>
  <h3>".$data[1]."</h3>
  <p>".$data[2]."->".$data[3]."</p>
  </div>";

}


?>


<form action="shop.php" method="POST">
<input type="text" name="name" placeholder="Your name">
<input type="text" name="surname">
<input type="email" name="email">
<input type="tel" name="tel_num" pattern="^[0-9]{4} ?[0-9]{3} ?[0-9]{3}$" title="Write your number in pattern: XXXX XXX XXX">
<input type="text" name="address">
<input type="hidden" name="items">
<input type="submit" value="Submit">

</form>

