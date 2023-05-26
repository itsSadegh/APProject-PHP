<link rel="stylesheet" href="assets/css/Basket.css">

<?php
session_start();

if (isset($_POST["add_to_basket"])) {
    $product_name = $_POST["product_name"];
    $product_brand = $_POST["product_brand"];
    $product_price = $_POST["product_price"];
    $product_row = $_POST["product_row"];

    // Store the product information in the session
    $_SESSION["basket"][$product_row] = array(
        "name" => $product_name,
        "brand" => $product_brand,
        "price" => $product_price,
        "row" => $product_row
    );
}
?>

<html>
<body>

<?php if (isset($_SESSION["basket"])) { ?>
    <div class="cart">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($_SESSION["basket"] as $product) { 
                $total_cost += $product["price"];
                ?>
                    <tr>
                        <td><img src="assets/img/12 Pro Max .jpg" alt=""></td>
                        <td><?= $product["name"] ?></td>
                        <td><?= $product["brand"] ?></td>
                        <td><?= $product["price"] ?></td>
                        <td>
                        </td>
                        <td>
                            <form action="remove_from_basket.php" method="post">
                                <input type="hidden" name="product_row" value="<?= $product["row"] ?>">
                                <button class="btn" type="submit" name="remove_from_basket" value="1">Remove</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                    <tr>
                        <td><p> total cost: </p></td>
                        <td><?= $total_cost ?></td>
                    </tr>
                
            </tbody>
        </table>
    </div>
<?php } ?>

    <a class="backToMainPageLink" href="index.php">back to main page</a>


</body>
</html>

