<?php
include 'connect.php';
$products = [
    ["img" => "pimg/tk1.jpeg", "name" => "Multi hand tool 4pc", "price" => "297"],
    ["img" => "pimg/tk2.jpeg", "name" => "Hand tool kit-8inch", "price" => "399"],
    ["img" => "pimg/tk3.jpeg", "name" => "TAPARIA 903IBT", "price" => "499"],
    ["img" => "pimg/tk4.jpeg", "name" => "MultipurposeScrew", "price" => "280"],
    ["img" => "pimg/tk5.jpeg", "name" => "TAPARIA CC-06 Cutter", "price" => "567"],
    ["img" => "pimg/tk6.jpeg", "name" => "Screwdrive set ,LED lights", "price" => "499"],
    ["img" => "pimg/tk7.jpeg", "name" => "Multicolor Insulated", "price" => "299"],
    ["img" => "pimg/tk8.jpeg", "name" => "TADMOS TDSK - 4010", "price" => "399"],
    ["img" => "pimg/tk9.jpeg", "name" => "Drill bits", "price" => "399"],
    ["img" => "pimg/tk10.jpeg", "name" => "TPARIA MDT 81 ", "price" => "399"],
    ["img" => "pimg/tk11.jpeg", "name" => "Tester pack of-2", "price" => "299"],
    ["img" => "pimg/tk12.jpeg", "name" => "Mandrel cutting tool", "price" => "399"],
    ["img" => "pimg/tk13.jpeg", "name" => "Screwdriver set", "price" => "499"],
    ["img" => "pimg/tk14.jpeg", "name" => "YOGI - TECH 32in 1 tool kit", "price" => "286"],
    ["img" => "pimg/tk15.jpeg", "name" => "Slotted screwdriver", "price" => "399"],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            padding: 10px;
        }
        
        h1 {
            text-align: center;
            margin: 15px 0;
            font-size: 1.5rem;
            color: #333;
        }
        
        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            padding: 10px;
        }
        
        /* Product Card */
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-3px);
        }
        
        .product-img-container {
            height: 120px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9f9f9;
        }
        
        .product-card img {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 100%;
            padding: 10px;
        }
        
        .product-info {
            padding: 12px;
        }
        
        .product-card h4 {
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: #333;
            height: 40px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .product-price {
            color: #e53935;
            font-weight: bold;
            font-size: 1rem;
            margin: 8px 0;
        }
        
        .buy-btn {
            background: #28a745;
            color: white;
            border: none;
            width: 100%;
            padding: 8px;
            border-radius: 4px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .buy-btn:hover {
            background: #218838;
        }
        
        /* Responsive Adjustments */
        @media (max-width: 600px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }
            
            .product-img-container {
                height: 100px;
            }
            
            .product-card h4 {
                font-size: 0.8rem;
                height: 36px;
            }
            
            .product-price {
                font-size: 0.9rem;
            }
        }
        
        @media (max-width: 380px) {
            .product-grid {
                grid-template-columns: 1fr;
                max-width: 300px;
                margin: 0 auto;
            }
            
            .product-card {
                display: flex;
                align-items: center;
                text-align: left;
            }
            
            .product-img-container {
                width: 120px;
                height: 100px;
                flex-shrink: 0;
            }
            
            .product-info {
                padding: 10px;
                flex-grow: 1;
            }
            
            .product-card h4 {
                height: auto;
                margin-bottom: 5px;
                -webkit-line-clamp: 3;
            }
            
            h1 {
                font-size: 1.3rem;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body>
    <h1>Our Products</h1>
    <div class="product-grid">
        <?php foreach ($products as $p) { ?>
            <div class="product-card">
                <div class="product-img-container">
                    <img src="<?php echo $p['img']; ?>" alt="<?php echo $p['name']; ?>" loading="lazy">
                </div>
                <div class="product-info">
                    <h4><?php echo $p['name']; ?></h4>
                    <p class="product-price">₹<?php echo $p['price']; ?></p>
                    <form action="order.php" method="GET">
                        <input type="hidden" name="name" value="<?php echo $p['name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $p['price']; ?>">
                        <input type="hidden" name="img" value="<?php echo $p['img']; ?>">
                        <button type="submit" class="buy-btn">Buy Now</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>