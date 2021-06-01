	<!-- E-shop Nabytok.sk -->
	<!-- Vytvoril Peter Huňady & Jakub Šepeľa -->
	<!-- 1.6.2021 -->
<!DOCTYPE html>
<html>
<head>

<?php
//výpis splnenia objednávky
session_start();
if(isset($_SESSION['send']))
if($_SESSION['send']==true){
	echo "<script>alert('Objednávka prebehla úspešne')</script>";
	session_destroy();
}
//import tried a kofiguračných údajov
include_once('Classes.php');
$config = json_decode(file_get_contents("config.json"));

//pripojenie na databázu
$mysqli = new mysqli($config->servername,$config->username,$config->password,$config->database);


?>


	<!-- Title s názvom stránky -->
	<title>Nabytok.sk</title>
	<!-- Font awesome -->
	<link rel="stylesheet" type="text/css" href="CSS/all.min.css">
	<link rel="stylesheet" type="text/css" href="CSS/fontawesome.min.css">
	
	<!-- Reset CSS -->
	<link rel="stylesheet" type="text/css" href="CSS/reset.css">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="CSS/style.css">

	<!-- Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8">
</head>
<body class="main">

	<!-- Hlavička -->
	<header>
		<!-- Názov stránky -->
		<h1 class="nadpis">Nábytok.sk</h1>
	</header>

	<article>
		<!-- Logo, popis E-shopu -->
		<nav>
			<!-- Logo -->
			<img src="img/chair.png" class="logo">

			<!-- Popis E-shopu-->
			<div class="popisStranky">
				<h1>Internetový obchod</h1>
				<p>Predaj nábytku a dekorácii najlepšej kvality.</p>
			</div>
		</nav>

		<!-- Kontaktné údaje -->
		<div class="kontakt">

			<!-- Telefónne číslo -->
			<div class="phone">
				<p><i class="fas fa-phone-alt"></i> 0969 420 069</p>
			</div>

			<!-- E-mail -->
			<div class="email">
				<p><i class="fas fa-paper-plane"></i> eshopnabytok@gmail.com</p>
			</div>
		</div>

		<div class="produkty">
			<p class=>Všetky produkty</p>
		</div>

		<!-- Zoznam všetkých produktov -->
		<section>

			<!-- Riadky s produktami -->
			<div class="row">
			
			
	
<?php

$items_array = array();
$result = $mysqli->query("SELECT * FROM items");

if ($result->num_rows > 0) {
  // uloženie dát dát z každéhp riadka
  while($row = $result->fetch_assoc()) {
    array_push($items_array,new Items($row));
  }
} else {
  echo "Obchod je prázdny";
}
//výpis každej položky z items
$row = 0;
foreach($items_array as $item){
  $data = $item->getDataArray();

	if($data[2]!=0)
  echo '<div class="item" data-count="'.$data[2].'" data-id="'.$data[0].'">
    <img src="img/'.$data[0].'.jpg">

    <h2>'.$data[1].'</h2>
    <p>'.$data[3].'€</p>
      <div class="kosik">
        <i class="fas fa-shopping-cart"></i>
      </div>
  </div>';
  	else
 	 $row--;

  if(++$row%4==0)
  echo '</div><div class="row">';
}

?>
</div>
		</section>
	</article>

	<!-- Ikona košíka v pravo dole na stránke, po kliknutí sa otvorí košík -->
	<div class="cart" onclick="openCart()">
		<i class="fas fa-shopping-cart"></i>
	</div>

	<!-- Po kliknutí na ikony košíka pod produktom sa otvorí tento overlay -->
	<div id="myNav" class="overlay">
		<!-- Tlačidlo X na zatvorenie overlayu -->
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

		<!-- Obsah overlayu -->
 		 <div class="overlay-content">

 		 	<!-- Obrázok produktu, ktorý chcete pridať do košíka -->
 		 	<div class="obrazokKosik">
 		 		<img src="" id="img">
 		 	</div>

 		 	<div id="info">
 		 		<!-- Názov produktu, ktorý chcete pridať do košíka -->
 		 		<h2 id="name"></h2>

 		 		<!-- Cena za kus produktu, ktorý chcete pridať do košíka -->
 		 		<span>Cena za kus:</span>
 		 		<p id="cena"></p>
 		 		<!-- Počet kusov, ktoré chcete pridať do košíka -->
 		 		<label for="pKusov">Počet kusov:</label>
 		 		
				<br><br><br>
 		 		
 		 		<!-- Počet kusov produktu na sklade -->
				  <span>Skladom:</span>
 		 		<p id="skladom"> </p>

 		 		<!-- Potvrdiť svoj výber a pridať produkt do košíka -->
 		 		<input type="submit" value="PRIDAŤ" id="pridat">
 		 	</div>
  		</div>
	</div>

	<!-- Overlay košíka -->
	<div id="shoppingCart" class="overlay">

		<!-- Obsah overlayu košíka -->
		<div class="cartContent">
			<!-- Tlačidlo X na zatvorenie overlayu -->
			<a href="javascript:void(0)" class="closeX" onclick="closeNav()">&times;</a>

			<h1>Tvoj košík:</h1>

			<!-- Vysvetlivky v košíku -->
			<div class="infoCart">
				<div class="pom"></div>

				<p>Názov</p>
				<p>Počet ks</p>
				<p>Cena</p>
			</div>

			<!-- Div, do ktorého sa ukladajú produkty po pridaní do košíka -->
			<div id="kosikObalovac">
			</div>

			<div class="obalovac">
				<!-- Celková cena všetkých produktov -->
				<div class="celkovaCena">
					
				</div>

				<!-- Tlačidlo pokračovať, presunie nás smerom na objednávku, kde budeme zadávať svoje údaje -->
				<div id="objednat" onclick="closeNav(), openObjednavka()">
					<p>Pokračovať</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Overlay formulára, kde zadávame svoje osobné údaje -->
	<div id="objednavka" class="overlay">
		<div class="cartContent">
			<!-- Tlačidlo X na zatvorenie overlayu -->
			<a href="javascript:void(0)" class="closeX" onclick="closeNav()">&times;</a>

			<h1>Objednávka</h1>

			<!-- Formular -->
			<form action="shop.php" method="POST">

				<div class="menoPriezvisko">
					<!-- Meno -->
					<div class="meno">
						<label for="name">Meno:</label><br>
  						<input type="text" name="name" placeholder="Meno" required maxlength="40" minlength="2">
					</div>
  				
  					<!-- Priezvisko -->
  					<div class="priezvisko">
  						<label for="surname">Priezvisko:</label><br>
  						<input type="text" name="surname" placeholder="Priezvisko" required maxlength="40" minlength="2">
  					</div>
				</div>

				<div class="cisloEmail">
					<!-- Telefónne číslo -->
					<div class="cislo">
						<label for="tel_num">Tel. číslo:</label>
						<input type="tel" name="tel_num" pattern="[0-9]{10}" placeholder="0912312312" required>
					</div>

					<div class="eemail">
						<!-- E-mail -->
						<label for="email">E-mail:</label>
						<input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}" placeholder="you@something.com" required>
					</div>
				</div>

				<div class="adresaMestoPSC">
					<!-- Adresa -->
					<div class="adresa">
						<label for="address">Adresa:</label>
  						<input type="text" name="address" placeholder="Adresa 12" required minlength="2" maxlength="255">
					</div>

					<!-- Mesto -->
					<div class="mesto">
						<label for="city">Mesto:</label>
  						<input type="text" name="city" placeholder="Mesto" required minlength="2" maxlength="255">
					</div>

					<!-- PSČ -->
					<div class="psc">
						<label for="PS">PSČ:</label>
  						<input type="text" name="PS" placeholder="01234" required pattern="[0-9]{5}" maxlength="5">
					</div>
				</div>

				<!-- Tlačídlo submit na potvrdenie objednávky -->
				<div class="objednatTovar">
					<input type="submit" value="OBJEDNAŤ">
				</div>

			</form>
		</div>
	</div>

	<!-- Pätička s informáciami o autoroch a právach -->
	<footer>
		<p>Vytvoril: Peter Huňady & Jakub Šepeľa</p>
		<p>©Všetky práva vyhradené</p>
	</footer>



	<script type="text/javascript">
		//JavaScript
		var shoppingcart = {};
		var shoppingItems = document.getElementsByClassName("kosik");

		//Cyklus pomocou ktorého vieme pridávať produkty do košíka, vybrať obrázok, názov a cenu.
		for(i = 0;i < shoppingItems.length;i++){
    		shoppingItems[i].addEventListener('click',function(){
			
			document.getElementById("info").querySelector("label").after(document.createElement("input"));
			setAttributes(document.getElementById("info").querySelector("input"),{"id":"pKusov", "type":"number", "name":"pocetKusov", "min":"0", "id":"pKusov", "value":"0", "onKeyDown":"return false"});
      		document.getElementById("myNav").style.width = "100%";
    		var image = this.parentElement.children[0].src;
    		var name = this.parentElement.children[1].innerHTML;
    		var price = this.parentElement.children[2].innerText;
			var count = this.parentElement.getAttribute("data-count");
			var id = this.parentElement.getAttribute("data-id");

    		document.getElementById("img").src = image;
    		document.getElementById("name").innerHTML = name;
    		document.getElementById("cena").innerText = price;
			document.getElementById("skladom").innerText = count;

			if(shoppingcart.hasOwnProperty(id)){
				document.getElementById("pKusov").setAttribute("value",shoppingcart[id]);
			}else{
				document.getElementById("pKusov").setAttribute("value",0);
			}
			
			document.getElementById("pKusov").setAttribute("max",count);
			document.getElementById("info").setAttribute("data-id",id);

			
  			});
		}

		//Funkcia, ktorá nám odstráni znak € z ceny
		function removeEuro(text){
			var newNumber = "";

			for (var i = 0; i < text.length-1; i++) {
				newNumber+=text[i];
			}
			return newNumber;
		}

		var button = document.getElementById("pridat");

		//Keď klikneme na tlačidlo pridať do košíka, vyberie sa obrázok, počet kusov, cena a názov produktu, ktorý sa vloží do košíka 
		button.addEventListener('click',function(){
			var pkusov =parseInt(document.getElementById("pKusov").value);
			closeNav();
			if (pkusov==0)
				delete shoppingcart[document.getElementById("info").getAttribute("data-id")];
			else
				shoppingcart[document.getElementById("info").getAttribute("data-id")] = pkusov ;
			
		});

		//Funkcia, ktorá nam po stlačení X tlačidla zavrie overlaye
		function closeNav() {
			document.getElementsByClassName("celkovaCena")[0].innerHTML="";
			console.log("vymzane");
  			document.getElementById("myNav").style.width = "0%";
  			document.getElementById("shoppingCart").style.width = "0%";
  			document.getElementById("objednavka").style.width="0%";
			  var element = document.getElementById("pKusov");
			  if(typeof(element) != 'undefined' && element != null)
				element.remove();
			document.getElementById("kosikObalovac").innerHTML="";
			

			
				

		}

		//Funkcia, ktorá nám otvorí overlay nákupného košíka
		function openCart(){
			if(Object.keys(shoppingcart).length===0){
				alert("Košik je prázdny");
				return;
			}
				var dokopyCena=0;
			for (const key in shoppingcart){
				if(shoppingcart.hasOwnProperty(key)){
				//Vytvorí sa nový div, do ktorého budeme vkladať produkty
				
				var element = document.createElement("div");
				document.getElementById("kosikObalovac").appendChild(element);
				element.setAttribute("id", "contentInCart");
			
				//Vyberanie obrázka, názvu, počtu kusov a ceny
				var item = document.querySelectorAll('[data-id="'+key+'"]')[0];
				var obrazokProdukt = "img/"+key+".jpg";
				var nazov = item.querySelectorAll('h2')[0].innerText;
				var pocetKusov = shoppingcart[key];
				var cenaProdukt = removeEuro(item.querySelectorAll('p')[0].innerText)*pocetKusov;
				dokopyCena = dokopyCena+cenaProdukt;
			
				//vytvorenie obrázka produktu v overlayu košíka
				var img= document.createElement("img");
				img.setAttribute("src", obrazokProdukt);

				//vytvorenie názvu produktu v overlayu košíka
				var nzv = document.createElement("p");
				var text = document.createTextNode(nazov);
				nzv.appendChild(text);

				//vytvorenie počtu kusov produktu v overlayu košíka
				var pk = document.createElement("p");
				var pktext = document.createTextNode(pocetKusov);
				pk.appendChild(pktext);

				//vytvorenie ceny produktu v overlayu košíka
				var cp = document.createElement("p");
				var cptext = document.createTextNode(cenaProdukt.toFixed(2)+"€");
				cp.appendChild(cptext);


			//Pridanie jednotlivých elementov do košíka;
			element.appendChild(img);
			element.appendChild(nzv);
			element.appendChild(pk);
			element.appendChild(cp);
			
			
				}
					
			}
			var p =document.createElement("p");
			p.innerHTML="Dokopy: "+dokopyCena.toFixed(2)+"€";
			document.getElementsByClassName("celkovaCena")[0].appendChild(p);
			document.getElementById("shoppingCart").style.width = "100%";
		}

		//Funkcia, ktorá nám otvorí overlay objednávky s formulárom
		function openObjednavka(){
			element = document.getElementById("hiddenInput");
			if(typeof(element) != 'undefined' && element != null)
				element.setAttribute("value",JSON.stringify(shoppingcart));
			else{
				var hiddenInput = document.createElement("input");
				setAttributes(hiddenInput,{"name":"jsonId","id":"hiddenInput","type":"hidden","value":JSON.stringify(shoppingcart)});
				document.getElementsByClassName("cartContent")[1].querySelectorAll("form")[0].append(hiddenInput);
			}
			
			document.getElementById("objednavka").style.width="100%";
		}

		function setAttributes(el, attrs) {
  			for(var key in attrs) {
   		 	el.setAttribute(key, attrs[key]);
  			}
		}
	</script>
</body>
</html>
