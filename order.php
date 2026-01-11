<?php
session_start();
include 'connect.php';

// Check if user is logged in (using both formats for compatibility)
if (!isset($_SESSION['user_email']) && !isset($_SESSION['customer']['email'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

// Get user email (prefer new format, fall back to old)
$user_email = $_SESSION['user_email'] ?? $_SESSION['customer']['email'];

// Check if product details are provided
if (!isset($_GET['name']) || !isset($_GET['price']) || !isset($_GET['img'])) {
    echo "<script>alert('Invalid product details!'); window.location.href='index.php';</script>";
    exit;
}

$product_name = $_GET['name'];
$product_price = $_GET['price'];
$product_img = $_GET['img'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insert order details into the database
    $stmt = $conn->prepare("INSERT INTO orders (user_email, product_name, product_price, product_img) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_email, $product_name, $product_price, $product_img);
    
    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully'); window.location.href='myorder.php';</script>";
    } else {
        echo "<script>alert('Failed to place order');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Base Styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f5f5f5;
            padding: 15px;
            color: #333;
        }
        
        .order-container {
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        h2 {
            color: #2874f0;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        img { width: 150px; height: 150px; object-fit: cover; }
        
        h3 {
            margin: 10px 0;
            font-size: 1.2rem;
            color: #333;
        }
        
        p {
            margin: 8px 0;
            font-size: 1rem;
            color: #555;
        }
        
        /* Button Styles */
        button {
            background-color: #2874f0;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 20px;
            min-width: 120px;
            min-height: 44px;
            transition: background 0.3s;
        }
        
        button:hover {
            background-color: #1a5cb0;
        }
        
        /* Responsive Styles */
        @media (max-width: 600px) {
            .order-container {
                padding: 15px;
                margin: 15px auto;
            }
            
            h2 {
                font-size: 1.3rem;
            }
            
            h3 {
                font-size: 1.1rem;
            }
            
            p {
                font-size: 0.95rem;
            }
            
            button {
                padding: 10px 20px;
                font-size: 0.95rem;
                min-width: 110px;
            }
        }
        
        @media (max-width: 380px) {
            body {
                padding: 10px;
            }
            
            .order-container {
                padding: 12px;
            
            }
            
            h2 {
                font-size: 1.2rem;
                margin-bottom: 15px;
            }
            
            img {
                margin: 10px 0;
                max-width: 300px;
            }
            
            h3 {
                font-size: 1rem;
            }
            
            p {
                font-size: 0.9rem;
            }
            
            button {
                padding: 10px 16px;
                font-size: 0.9rem;
                min-width: 100px;
                min-height: 40px;
                margin-top: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="order-container">
        <h2>Order Summary</h2>
        <?php if (!empty($product_img)): ?>
            <img src="<?php echo $product_img; ?>" alt="<?php echo $product_name; ?>">
        <?php endif; ?>
        
        <?php if (!empty($product_name)): ?>
            <h3><?php echo $product_name; ?></h3>
        <?php endif; ?>
        
        <?php if (!empty($product_price)): ?>
            <p>Price: ₹<?php echo $product_price; ?></p>
        <?php endif; ?>
        
        <?php if (!empty($user_email)): ?>
            <p>Ordered by: <?php echo $user_email; ?></p>
        <?php endif; ?>
        
        <form method="POST">
            <button type="submit">Place Order</button>
        </form>
    </div>
</body>
</html>