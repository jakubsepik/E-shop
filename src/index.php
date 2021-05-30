<?php
include_once('Classes.php');
$config = json_decode(file_get_contents("config.json"));

$mysqli = new mysqli($config->servername,$config->username,$config->password,$config->database);

if(isset($_POST['name'])){
	
	$orders = new Orders;
	$orders->addOrder($mysqli,$_POST['name'],"surname","email","tel_num","address","PENDING","ps","city");
	$result = $mysqli->query("SELECT max(order_id) FROM orders");
	print_r($result);
	echo $mysqli->insert_id;

	exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>nabytok.sk</title>
	<link rel="stylesheet" type="text/css" href="CSS/all.min.css">
	<link rel="stylesheet" type="text/css" href="CSS/fontawesome.min.css">
	
	<link rel="stylesheet" type="text/css" href="CSS/reset.css">
	<link rel="stylesheet" type="text/css" href="CSS/style.css">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
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
				<p><i class="fas fa-paper-plane"></i> eshopnabytok@gmail.com</p>
			</div>
		</div>

		<div class="produkty">
			<p class=>Všetky produkty</p>
		</div>

		<section>
			<div class="row">
				

			
			
	
<?php




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


  echo '<div class="item" data-count="'.$data[2].'">
    <img src="img/'.$data[0].'.jpg">

    <h2>'.$data[1].'</h2>
    <p>'.$data[3].'€</p>
      <div class="kosik">
        <i class="fas fa-shopping-cart"></i>
      </div>
  </div>';

  if(++$row%4==0)
  echo '</div><div class="row">';
}

?>
</div>
	</section>
	</article>

	<div class="cart" onclick="openCart()">
		<i class="fas fa-shopping-cart"></i>
	</div>


	<div id="myNav" class="overlay">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

 		 <div class="overlay-content">

 		 	<div class="obrazokKosik">
 		 		<img src="" id="img">
 		 	</div>

 		 	<div class="info">
 		 		<h2 id="name"></h2>

 		 		<span>Cena za kus:</span>
 		 		<p id="cena"></p>
 		 		<label for="Pocet kusov">Počet kusov:
 		 			<input type="number" min="1" id="pKusov" value="1" pattern="^[0-9]{4} ?[0-9]{3} ?[0-9]{3}$">
 		 		</label>
 		 		
 		 		<p>Skladom: </p>

 		 	
 		 		<input type="submit" value="PRIDAŤ" id="pridat" onclick="closeNav()">
 		 	</div>
  		</div>
	</div>

	<div id="shoppingCart" class="overlay">
		<div class="cartContent">
			<a href="javascript:void(0)" class="closeX" onclick="closeNav()">&times;</a>
		</div>
	</div>

	<footer>
		<p>Vytvoril: Peter Huňady, Jakub Šepeľa</p>
		<p>©Všetky práva vyhradené</p>
	</footer>




	<script type="text/javascript">
		var shoppingItems = document.getElementsByClassName("kosik");

		for(i = 0;i < shoppingItems.length;i++){
    		shoppingItems[i].addEventListener('click',function(){
      		document.getElementById("myNav").style.width = "100%";
    		var image = this.parentElement.children[0].src;
    		var name = this.parentElement.children[1].innerHTML;
    		var price = this.parentElement.children[2].innerText;

    		document.getElementById("img").src = image;
    		document.getElementById("name").innerHTML = name;
    		document.getElementById("cena").innerText = price;
  			});
		}


		function removeEuro(text){
			var newNumber = "";

			for (var i = 0; i < text.length-1; i++) {
				newNumber+=text[i];
			}
			return newNumber;
		}

		var button = document.getElementById("pridat");

		button.addEventListener('click',function(){
			var pocetKusov = parseInt(document.getElementById("pKusov").value);
			var nazov = document.getElementById("name").innerHTML;
			var cenaProdukt = removeEuro(document.getElementById("cena").innerText);
			var obrazokProdukt = document.getElementById("img").src;

			console.log(pocetKusov);
			console.log(nazov);
			console.log(cenaProdukt);
			console.log(obrazokProdukt);
		});

		function closeNav() {
  			document.getElementById("myNav").style.width = "0%";
  			document.getElementById("shoppingCart").style.width = "0%";
		}

		function openCart(){
			document.getElementById("shoppingCart").style.width = "100%";
		}
	</script>
</body>
</html>

<form action="index.php" method="POST">
<input type="text" name="name" placeholder="Your name">
<input type="text" name="surname">
<input type="email" name="email">
<input type="tel" name="tel_num" pattern="^[0-9]{4} ?[0-9]{3} ?[0-9]{3}$" title="Write your number in pattern: XXXX XXX XXX">
<input type="text" name="address">
<input type="hidden" name="items">
<input type="submit" value="Submit">

</form>

