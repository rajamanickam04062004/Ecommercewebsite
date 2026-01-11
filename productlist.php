<?php
include 'connect.php';

function displayCategory($category, $products) {
    echo "<div class='category'>";
    echo "<h2>$category</h2>";
    echo "<div class='product-container' id='$category'>";

    foreach ($products as $product) {
        echo "<div class='product'>";
        echo "<img src='{$product['img']}' alt='{$product['name']}'><br>";
        echo "<b>{$product['name']}</b><br>";
        echo "<b>Price: ₹ {$product['price']}</b><br>";
        echo "<a href='order.php?name={$product['name']}&price={$product['price']}&img={$product['img']}'><button>Buy Now</button></a>";
        echo "</div>";
    }

    echo "</div>";
    echo "<button class='scroll-left' data-category='" . htmlspecialchars($category, ENT_QUOTES) . "'>&lt;</button>";
    echo "<button class='scroll-right' data-category='" . htmlspecialchars($category, ENT_QUOTES) . "'>&gt;</button>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 15px;
            background-color: #f5f5f5;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .category { 
            position: relative; 
            margin-bottom: 30px; 
            overflow: hidden; 
        }
        
        .category h2 {
            margin-left: 10px;
            color: #2874f0;
            font-size: 20px;
        }
        
        .product-container { 
            display: flex; 
            overflow-x: auto; 
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
            gap: 15px;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .product-container::-webkit-scrollbar { 
            display: none; 
        }
        
        .scroll-left, .scroll-right {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            font-size: 20px;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .scroll-left { left: 10px; }
        .scroll-right { right: 10px; }
        
        .product { 
            scroll-snap-align: start;
            flex: 0 0 auto;
            text-align: center; 
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 300px;
        }
        
        img { 
            width: 100%; 
            height: 150px; 
            object-fit: contain; 
            margin-bottom: 10px;
        }
        
        button {
            background-color: #28a745;
            color: #fff;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            width: 100%;
            white-space: nowrap;
        }
        
        button:hover {
            background-color: #218838;
        }
        
        /* 600px Breakpoint */
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            h1 {
                font-size: 22px;
                margin-bottom: 15px;
            }
            
            .category h2 {
                font-size: 18px;
            }
            
            .product {
                width: 160px;
                padding: 10px;
            }
            
            img {
                height: 130px;
            }
            
            .product-container {
                padding: 10px;
                gap: 10px;
            }
            
            .scroll-left, .scroll-right {
                width: 35px;
                height: 35px;
                font-size: 18px;
            }
            
            button {
                padding: 7px 12px;
                font-size: 13px;
            }
        }
        
        /* 380px Breakpoint */
        @media (max-width: 380px) {
            body {
                padding: 8px;
            }
            
            h1 {
                font-size: 20px;
            }
            
            .category h2 {
                font-size: 16px;
                margin-left: 5px;
            }
            
            .product {
                width: 200px;
                padding: 8px;
            }
            
            img {
                height: 110px;
            }
            
            .product b {
                font-size: 13px;
            }
            
            .product-container {
                padding: 12px;
                gap: 8px;
            }
            
            button {
                padding: 6px 10px;
                font-size: 12px;
            }
            
            .scroll-left, .scroll-right {
                width: 30px;
                height: 30px;
                font-size: 16px;
            }
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".scroll-left").forEach(button => {
                button.addEventListener("click", function () {
                    let category = this.getAttribute("data-category");
                    let container = document.getElementById(category);
                    let productWidth = container.querySelector(".product").offsetWidth;
                    if (container) {
                        container.scrollLeft -= productWidth;
                    }
                });
            });

            document.querySelectorAll(".scroll-right").forEach(button => {
                button.addEventListener("click", function () {
                    let category = this.getAttribute("data-category");
                    let container = document.getElementById(category);
                    let productWidth = container.querySelector(".product").offsetWidth;
                    if (container) {
                        container.scrollLeft += productWidth;
                    }
                });
            });
        });
    </script>
</head>
<body>
    
    <?php
    $categories = [
        'Cable Cutters' => [
            ['img' => 'pimg/cc1.jpeg', 'name' => 'Multifunction wire splitting pliers', 'price' => '445'],
            ['img' => 'pimg/cc2.jpeg', 'name' => 'cable stripping', 'price' => '300'],
            ['img' => 'pimg/cc3.jpeg', 'name' => 'Wire plier tool', 'price' => '399'],
            ['img' => 'pimg/cc4.jpeg', 'name' => 'Stripper wire', 'price' => '299'],
            ['img' => 'pimg/cc5.jpeg', 'name' => 'Durable wire stripper', 'price' => '380'],
            ['img' => 'pimg/cc6.jpeg', 'name' => 'Electrician pliers', 'price' => '386'],
            ['img' => 'pimg/cc7.jpeg', 'name' => 'Proskit 8pk', 'price' =>'780'],
            ['img' => 'pimg/cc8.jpeg', 'name' => 'Cheferyn wire stripper', 'price' => '390'],
            ['img' => 'pimg/cc9.jpeg', 'name' => 'Mlti-function tool', 'price' => '599'],
            ['img' => 'pimg/cc10.jpeg', 'name' => 'Cable stripper', 'price' => '299'],
        ],
        'Hand tool kit' => [
            ['img' => 'pimg/ht1.jpeg', 'name' => 'VDNSI 46 in 1', 'price' => '447'],
            ['img' => 'pimg/ht2.jpeg', 'name' => 'Meswan pruner saw', 'price' => '397'],
            ['img' => 'pimg/ht3.jpeg', 'name' => 'Inditrust 8 pcs', 'price' => '473'],
            ['img' => 'pimg/ht4.jpeg', 'name' => 'Inditrust Hand tool', 'price' => '599'],
            ['img' => 'pimg/ht5.jpeg', 'name' => 'AEGON 7 Pcs', 'price' => '561'],
            ['img' => 'pimg/ht6.jpeg', 'name' => 'QXORE 32 IN 1mini', 'price' => '699'],
            ['img' => 'pimg/ht7.jpeg', 'name' => 'PRSVIKE Steel saw', 'price' => '899'],
            ['img' => 'pimg/ht8.jpeg', 'name' => 'PR Creation multimeter', 'price' => '264'],
            ['img' => 'pimg/ht9.jpeg', 'name' => 'Republic AC DCVoltage meter', 'price' => '255'],
            ['img' => 'pimg/ht10.jpeg', 'name' => 'SG Flash MT87', 'price' => '451'],
            ['img' => 'pimg/ht11.jpeg', 'name' => 'Duty Multimeter', 'price' => '399'],
          
        ],
        'Multimeter' => [
            ['img' => 'pimg/m1.jpeg', 'name' => 'DT-830D', 'price' => '225'],
            ['img' => 'pimg/m2.jpeg', 'name' => 'SG Flash MT87', 'price' => '451'],
            ['img' => 'pimg/m3.jpeg', 'name' => 'Multimeter wire', 'price' => '199'],
            ['img' => 'pimg/m4.jpeg', 'name' => 'Digitak multimeter ', 'price' => '399'],
            ['img' => 'pimg/m5.jpeg', 'name' => 'Voltmeter AC DC', 'price' => '417'],
            ['img' => 'pimg/m6.jpeg', 'name' => 'Digital Clamp Ampere ', 'price' => '599'],
            ['img' => 'pimg/m7.jpeg', 'name' => 'MAS830L', 'price' => '399'],
            ['img' => 'pimg/m8.jpeg', 'name' => 'Multimeter test leads', 'price' => '299'],
            ['img' => 'pimg/m9.jpeg', 'name' => 'SAMAES', 'price' => '199'],
           
        ],
        'Circuit tester' => [
            ['img' => 'pimg/ct1.jpeg', 'name' => 'ATOZTOOLS', 'price' => '281'],
            ['img' => 'pimg/ct2.jpeg', 'name' => 'NITYA pen', 'price' => '299'],
            ['img' => 'pimg/ct3.jpeg', 'name' => 'voltage circuit tester', 'price' => '299'],
            ['img' => 'pimg/ct4.jpeg', 'name' => 'Carlight Circuit', 'price' => '499'],
            ['img' => 'pimg/ct5.jpeg', 'name' => 'Xsentuals DC6V', 'price' => '399'],
            ['img' => 'pimg/ct6.jpeg', 'name' => 'Gadariya king 20 PCS', 'price' => '399'],
            ['img' => 'pimg/ct7.jpeg', 'name' => 'FICKIT ', 'price' => '399'],
            ['img' => 'pimg/ct8.jpeg', 'name' => 'A&S Toolshop', 'price' => '499'],
            ['img' => 'pimg/ct9.jpeg', 'name' => 'Digital Voltage tester', 'price' => '199'],
            ['img' => 'pimg/ct10.jpeg', 'name' => 'VoltageAlarm ', 'price' => '399'],
           
        ],
        'Bulb holder' => [
            ['img' => 'pimg/bh1.jpeg', 'name' => 'SHAFIRE Screw', 'price' => '215'],
            ['img' => 'pimg/bh2.jpeg', 'name' => 'JELECTRICALS Holder', 'price' => '199'],
            ['img' => 'pimg/bh3.jpeg', 'name' => 'Hiru bulb holder', 'price' => '199'],
            ['img' => 'pimg/bh4.jpeg', 'name' => 'Vergin 1029', 'price' => '299'],
            ['img' => 'pimg/bh5.jpeg', 'name' => 'M2 LOOK Holder', 'price' => '199'],
            ['img' => 'pimg/bh6.jpeg', 'name' => 'JELECTRICALS 2 ', 'price' => '199'],
            ['img' => 'pimg/bh7.jpeg', 'name' => 'Fancy bulb holder', 'price' => '299'],
            ['img' => 'pimg/bh8.jpeg', 'name' => 'ASCENSION 1B22', 'price' => '199'],
            ['img' => 'pimg/bh9.jpeg', 'name' => 'SVDK bulb holder', 'price' => '399'],
            ['img' => 'pimg/bh10.jpeg', 'name' => 'HI-PLASST Core holder', 'price' => '399'],
           
        ],
        'Drill machine' => [
            ['img' => 'pimg/dm1.jpeg', 'name' => 'Sauran 5KG Hammer Drill', 'price' => '4,205'],
            ['img' => 'pimg/dm2.jpeg', 'name' => 'Sauren Hammer Drill 20mm', 'price' => '2,198'],
            ['img' => 'pimg/dm3.jpeg', 'name' => '1500 W corede Hammer', 'price' => '7,999'],
            ['img' => 'pimg/dm4.jpeg', 'name' => 'INGCO RGH6528', 'price' => '3,389'],
            ['img' => 'pimg/dm5.jpeg', 'name' => '1200 W Hammer Drill 26mm', 'price' => '4,999'],
            ['img' => 'pimg/dm6.jpeg', 'name' => 'INGCO RGH9028', 'price' => '4500'],
            ['img' => 'pimg/dm7.jpeg', 'name' => 'Hilgrove Electric Hammer', 'price' => '1,999'],
            ['img' => 'pimg/dm8.jpeg', 'name' => 'Sauren 26mm Reverse Hammer', 'price' => '2,884'],
            ['img' => 'pimg/dm9.jpeg', 'name' => 'iBELL Hammer', 'price' => '6,999'],
            ['img' => 'pimg/dm10.jpeg', 'name' => 'Sauren 10mm Hammer', 'price' => '5,999'],
           
        ],
        'Metal screw' => [
            ['img' => 'pimg/ms1.jpeg', 'name' => ' metal screw pack of-1000', 'price' => '399'],
            ['img' => 'pimg/ms2.jpeg', 'name' => 'Mushroom setscrew pack of-50', 'price' => '799'],
            ['img' => 'pimg/ms3.jpeg', 'name' => 'Drywall screw pack of-350', 'price' => '272'],
            ['img' => 'pimg/ms4.jpeg', 'name' => 'Iron Bugle pack of-100', 'price' => '400'],
            ['img' => 'pimg/ms5.jpeg', 'name' => 'Rab Nickel pack of-1000', 'price' => '499'],
            ['img' => 'pimg/ms6.jpeg', 'name' => 'Smart shophar', 'price' => '199'],
            ['img' => 'pimg/ms7.jpeg', 'name' => 'Metal screw', 'price' => '399'],
            ['img' => 'pimg/ms8.jpeg', 'name' => 'BIT Steel Screw pack of-100' , 'price' => '196'],
            ['img' => 'pimg/ms9.jpeg', 'name' => 'Metal screw pack of-200', 'price' => '399'],
            ['img' => 'pimg/ms10.jpeg', 'name' => 'Steel screw pack of-20', 'price' => '159'],
           
        ]
    ];

    foreach ($categories as $category => $products) {
        displayCategory($category, $products);
    }
    ?>
</body>
</html>
