<?php
//trieda na vytvaranie objektov na items
class Items{
    private $item_id;
    private $name;
    private $count;
    private $price;

    public function __construct($row) {
       $this->item_id = $row["item_id"];
       $this->name = $row["name"];
       $this->count = $row["count"];
       $this->price = $row["price"];
    }
    //vratenie array z parametrov v arrayi
    public function getDataArray(){
        return array($this->item_id,$this->name,$this->count,$this->price);
    }

}
//trieda na pridávanie objednávok
class Orders{

    public function addOrder($mysqli,$name,$surname,$email,$tel_num,$city,$address,$ps)
    {
        $code = "INSERT INTO `orders` (`order_id`, `name`, `surname`, `email`, `tel_num`, `address`, `status`, `ps`, `city`) VALUES (?,?,?,?,?,?,?,?,?);";
        $array = array(NULL, $name, $surname, $email, $tel_num, $address,'PENDING',$ps,$city);
        return preventSQLInjection($code,$mysqli,$array,true);
    }

}
//trieda na pridávanie objednáných položiek
class Order_items{
    public function addOrderItem($mysqli,$order_id,$item_id,$count,$price)
    {

        $code = "INSERT INTO `order_items` (`order_id`, `item_id`, `count`, `price`) VALUES (?,?,?,?);";
        $array= array($order_id, $item_id, $count, $price);
        preventSQLInjection($code,$mysqli,$array);
    }
}
//funkcia na prevenciu sql insertion
function preventSQLInjection($code, $mysqli, $array,$getId=false){
    $stmt  = $mysqli->prepare($code); 
    $types = str_repeat('s', count($array)); 
    $stmt->bind_param($types, ...$array); 
    $stmt->execute();
    if($getId==true)
     return $mysqli->insert_id;
}
