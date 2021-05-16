<?php
session_start();
if(isset($_POST['name'])){
    echo $_POST['name'];
    echo print_r($_SESSION['items']);
  }
  

?>