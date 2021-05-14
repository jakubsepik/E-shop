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

    public function addOrder($mysqli,$name,$surname,$email,$tel_num,$city,$address,$ps,$status)
    {
        $code = "INSERT INTO `orders` (`order_id`, `name`, `surname`, `email`, `tel_num`, `address`, `status`) VALUES (NULL, $name, $surname, $email, $tel_number, $address, $status);";
        $mysqli->query($code) or die("Something went wrong");
    }

}

class Order_items{
    public function addOrderItem($mysqli,$order_id,$item_id,$count,$price)
    {
        $code = "INSERT INTO `order_items` (`order_id`, `item_id`, `count`, `price`) VALUES ($order_id, $item_id, $count, $price);";
        $mysqli->query($code) or die("Something went wrong");
    }
}
?>