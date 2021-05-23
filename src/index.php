<!DOCTYPE html>
<html>
<head>
	<title>nabytok.sk</title>
	<link rel="stylesheet" type="text/css" href="CSS/reset.css">
	<link rel="stylesheet" type="text/css" href="CSS/style.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">

	<script src="https://kit.fontawesome.com/f40ecbd809.js" crossorigin="anonymous"></script>
</head>
<body class="main">

	<header>
		<h1 class="nadpis">Nábytok.sk</h1>
	</header>


	<article>
		<nav>
			<img src="img/chair.png" class="logo">

			<div class="idk">
				<h1>Internetový obchod</h1>
				<p>Predaj nábytku a dekorácii najlepšej kvality.</p>
			</div>
		</nav>


		<div class="kontakt">
			<div class="phone">
				<p><i class="fas fa-phone-alt"></i> 0969 420 069</p>
			</div>

			<div class="email">
				<p><i class="far fa-paper-plane"></i> eshopnabytok@gmail.com</p>
			</div>
		</div>

		<div class="produkty">
			<p class=>Všetky produkty</p>
		</div>



		<section>
			<div class="row">
				

			
			
	
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
$row = 0;
foreach($items_array as $item){
  $data = $item->getDataArray();


  echo '<div class="item">
    <img src="img/'.$data[0].'.jpg">

    <h2>'.$data[1].'</h2>
    <p>'.$data[3].'</p>
    <a href="">
      <div class="kosik">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </a>
  </div>';

  if(++$row%4==0)
  echo '</div><div class="row">';
}


?>
</div>
	</section>
	</article>


	<footer>
		<p>Vytvoril: Peter Huňady, Jakub Šepeľa</p>
		<p>©Všetky práva vyhradené</p>
	</footer>

</body>
</html>

<form action="shop.php" method="POST">
<input type="text" name="name" placeholder="Your name">
<input type="text" name="surname">
<input type="email" name="email">
<input type="tel" name="tel_num" pattern="^[0-9]{4} ?[0-9]{3} ?[0-9]{3}$" title="Write your number in pattern: XXXX XXX XXX">
<input type="text" name="address">
<input type="hidden" name="items">
<input type="submit" value="Submit">

</form>

