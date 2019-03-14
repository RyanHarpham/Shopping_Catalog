<?php

class Order {

    private $productID;
    private $quantity;
    private $timePlaced;
    static $orderID = 0;

    function __construct($productID, $quantity) {
        self::$orderID++;
        $this->productID = $productID;
        $this->quantity = $quantity;
        $this->timePlaced = date("m/d/Y");
    }

    function getOrderID() {
        return self::$orderID;
    }

    function getProductID() {
        return $this->productID;
    }

    function getQuantity() {
        return $this->quantity;
    }

    function getTimePlaced() {
        return $this->timePlaced;
    }

    function setProductID($productID) {
        $this->productID = $productID;
    }

    function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

}
