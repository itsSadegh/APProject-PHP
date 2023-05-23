<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="reset css" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <script type="text/javascript" src="script.js"></script>


    <title>AP-PRJ-01</title>
    
</head>
<body>



<?php 

include "classes.php";
// example 
$manager = new ProductManager("productsAP.xlsx"); 

// Add a new product to the ProductManager and excel source file
// $product1 = new Product("salam", "hello", 10); 
// $manager->addProduct($product1); 


// Delete a product from the ProductManager and excel source file
// $manager->deleteProduct($product1); 

// $products = $manager->getAllProducts(); 
?>


<header>
        <form action="" method="post">

            <div class="searchBox">
                <input type="text" id="navbar-search" name="search" placeholder="Search products...">   
                <button class="btn" type="submit" >Search</button>
                <button class="btn" type="button" onclick="clearSearch()">Clear</button>
            </div>

            <div class="min-max-price">
                <div class="min-max-price-left">
                    <div>
                        <label for="min_price">Min Price:</label>
                        <input type="number" id="min_price" name="min_price" min="0" step="5">
                    </div>
                    <div>
                        <label for="max_price">Max Price:</label>
                        <input type="number" id="max_price" name="max_price" min="0" step="5">
                    </div>
                </div>
                <button class="btn min-max-price-button" type="submit">Filter</button>
            </div>

            <div class="sortByPrice-l2h-and-h2l-Container">
                <a class="sortByPrice-l2h-and-h2l" href="?sort=asc">Sort by Price: Low to High</a>
                <a class="sortByPrice-l2h-and-h2l" href="?sort=desc">Sort by Price: High to Low</a>
            </div>
        
        </form>
</header>

<?php
    $products = $manager->getAllProducts();

// check if search box is submitted
    if (isset($_POST['search'])) {
        $searchTerm = $_POST['search'];
        $products = $manager->getAllProducts($searchTerm);
    } 
    

// check if min and max price inputs are submitted
    if (isset($_POST['min_price']) && isset($_POST['max_price']) && !empty($_POST['min_price']) && !empty($_POST['max_price'])) {
        $minPrice = $_POST['min_price'];
        $maxPrice = $_POST['max_price'];
        // filter products by price range
        $products = array_filter($products, function($product) use ($minPrice, $maxPrice) {
            return $product->getPrice() >= $minPrice && $product->getPrice() <= $maxPrice;
        });
    }
    



// Get the sort parameter from the URL (if any)
    $sort = isset($_GET['sort']) ? $_GET['sort'] : null;

    // Sort the products by price if the sort parameter is set
    if ($sort === 'asc') {
    usort($products, function($a, $b) {
        return $a->getPrice() - $b->getPrice();
    });
    } else if ($sort === 'desc') {
    usort($products, function($a, $b) {
        return $b->getPrice() - $a->getPrice();
    });
    }
?>

<div class="products grid">
    <?php foreach ($products as $key => $product) { ?>
        <div class="card col-3">
            <img src="assets/img/12 Pro Max .jpg" alt="">
            <p type></p>
            <p><?= $product->getName() ?></p>
            <p><?= $product->getBrand() ?></p>
            <p>$ <?= $product->getPrice() ?></p>
            <form action="Basket.php" method="post">     
                <input type="hidden" name="product_name" value="<?= $product->getname() ?>" >
                <input type="hidden" name="product_brand" value="<?= $product->getBrand() ?>" >
                <input type="hidden" name="product_price" value="<?= $product->getprice() ?>" >
                <input type="hidden" name="product_row" value="<?= $key + 1 ?>" >
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                <button type="submit" name="add_to_basket" value="1">Add to basket</button>   
            </form>
        </div>
    <?php } ?>
</div>
</body>
</html>

