<?php
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

    public function getDataArray(){
        return array($this->item_id,$this->name,$this->count,$this->price);
    }

}

class Orders{

    public function addOrder($mysqli,$name,$surname,$email,$tel_num,$city,$address,$ps)
    {
        $code = "INSERT INTO `orders` (`order_id`, `name`, `surname`, `email`, `tel_num`, `address`, `status`, `ps`, `city`) VALUES (?,?,?,?,?,?,?,?,?);";
        $array = array(NULL, $name, $surname, $email, $tel_num, $address,'PENDING',$ps,$city);
        preventSQLInjection($code,$mysqli,$array);
    }

}

class Order_items{
    public function addOrderItem($mysqli,$order_id,$item_id,$count,$price)
    {

        $code = "INSERT INTO `order_items` (`order_id`, `item_id`, `count`, `price`) VALUES (?,?,?,?);";
        $array= array($order_id, $item_id, $count, $price);
        preventSQLInjection($code,$mysqli,$array);
    }
}

function preventSQLInjection($code, $mysqli, $array){
    $stmt  = $mysqli->prepare($code); // prepare
    $types = str_repeat('s', count($array)); //types
    $stmt->bind_param($types, ...$array); // bind array at once
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    return $data = $result->fetch_all(MYSQLI_ASSOC); // fetch the data
}
