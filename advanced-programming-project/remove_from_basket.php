<?php
session_start();

if (isset($_POST["remove_from_basket"])) {
    $product_row = $_POST["product_row"];

    // Remove the product from the basket
    unset($_SESSION["basket"][$product_row]);
}

header("Location: basket.php");