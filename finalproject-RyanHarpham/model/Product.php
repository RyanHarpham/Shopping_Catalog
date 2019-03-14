<?php
class Product {
    private $productID;
    private $image;
    private $productName;
    private $productDescription;
    private $price;
    
        function __construct($productID, $image, $productName, $productDescription, $price) {
        $this->productID = $productID;
        $this->image = $image;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->price = $price;
    }
    function getProductID() {
        return $this->productID;
    }
    function getImage() {
        return $this->image;
    }
    function getProductName() {
        return $this->productName;
    }
    function getProductDescription() {
        return $this->productDescription;
    }
    function getPrice() {
        return $this->price;
    }
    function setImage($image) {
        $this->image = $image;
    }
    function setProductName($productName) {
        $this->productName = $productName;
    }
    function setProductDescription($productDescription) {
        $this->productDescription = $productDescription;
    }
    function setPrice($price) {
        $this->price = $price;
    }
    function getPriceFormatted(){
        return '$' . $this->price;
    }
}
