<?php
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Gallery</title>
    <style>
        .category { margin-bottom: 20px; }
        .product-container { display: flex; overflow-x: auto; white-space: nowrap; }
        .product { display: inline-block; text-align: center; padding: 10px; }
        img { width: 150px; height: 150px; object-fit: cover; }
    </style>
</head>
<body>
    <h1>Product Gallery</h1>
    
    <?php
    $categories = [
        'Electronics' => [
            ['img' => 'images/electronics1.jpg', 'name' => 'Smartphone', 'price' => '299.99'],
            ['img' => 'images/electronics2.jpg', 'name' => 'Laptop', 'price' => '799.99'],
            ['img' => 'images/electronics3.jpg', 'name' => 'Headphones', 'price' => '99.99'],
            ['img' => 'images/electronics4.jpg', 'name' => 'Smartwatch', 'price' => '199.99'],
            ['img' => 'images/electronics5.jpg', 'name' => 'Camera', 'price' => '499.99']
        ],
        'Fashion' => [
            ['img' => 'images/fashion1.jpg', 'name' => 'T-Shirt', 'price' => '19.99'],
            ['img' => 'images/fashion2.jpg', 'name' => 'Jeans', 'price' => '49.99'],
            ['img' => 'images/fashion3.jpg', 'name' => 'Jacket', 'price' => '79.99'],
            ['img' => 'images/fashion4.jpg', 'name' => 'Shoes', 'price' => '59.99'],
            ['img' => 'images/fashion5.jpg', 'name' => 'Hat', 'price' => '14.99']
        ]
    ];
    
    foreach ($categories as $category => $products) {
        echo "<div class='category'>";
        echo "<h2>$category</h2>";
        echo "<div class='product-container'>";
        
        foreach ($products as $product) {
            echo "<div class='product'>";
            echo "<img src='{$product['img']}' alt='{$product['name']}'><br>";
            echo "<b>{$product['name']}</b><br>";
            echo "<b>Price: $ {$product['price']}</b><br>";
            echo "<a href='order.php?name={$product['name']}&price={$product['price']}&img={$product['img']}'><button>Buy Now</button></a>";
            echo "</div>";
        }
        
        echo "</div></div>";
    }
    ?>
</body>
</html>
