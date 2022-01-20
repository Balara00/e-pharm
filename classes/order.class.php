<?php

abstract class Order {
    // private $orderNow_model;

    // public function __construct() {

    // }

    abstract public function process($orderNow_model);

    abstract public function setOrderCustomer($orderNow_model, $orderID);
}