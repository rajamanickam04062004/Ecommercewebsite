<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['customer']['email'])) {
    echo "<script>alert('Please login first!'); window.location.href='login.php';</script>";
    exit;
}

// Get the logged-in user's email
$user_email = $_SESSION['customer']['email'];

// Fetch only the logged-in user's orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_email = ? ORDER BY order_date DESC");
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .order-container {
            width: 40%;
            float: left;
            margin:40px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #f9f9f9;
            position: relative;
            overflow: hidden;
        }
        .order-item-container {
            display: flex;
            overflow-x: scroll;
            white-space: nowrap;
            scrollbar-width: none;
        }
        .order-item-container::-webkit-scrollbar {
            display: none;
        }
        .order-item {
            display: inline-block;
            width: 250px;
            margin-right: 10px;
            text-align: center;
            padding: 10px;
        }
        img { width: 150px; height: 150px; object-fit: cover; }
        .order-item h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .order-item p {
            font-size: 16px;
            margin: 5px 0;
        }
        .scroll-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px;
            font-size: 20px;
            z-index: 10;
            cursor: pointer;
        }
        .scroll-left {
            left: 0;
        }
        .scroll-right {
            right: 0;
        }
         /* Media Queries for Responsiveness */
         @media (max-width: 780px) {
            .order-container {
                width: 60%;
                margin: 20px auto;
            }
        }

        @media (max-width: 600px) {
            .order-container {
                width: 70%;
                margin: 40px;
            }
            .order-item {
                width: 200px;
            }
        }

        @media (max-width: 480px) {
            .order-container {
                width: 90%;
                margin: 10px auto;
            }
            .order-item {
                width: 150px;
            }
            .order-item h3 {
                font-size: 16px;
            }
            .order-item p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<h1>My Orders</h1>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='order-container'>";
        echo "<div class='order-item'>";
        echo "<img src='{$row['product_img']}' alt='{$row['product_name']}'>";
        echo "<h3>{$row['product_name']}</h3>";
        echo "<p>Price: ₹{$row['product_price']}</p>";
        echo "<p>Ordered on: {$row['order_date']}</p>";
        echo "</div></div>";
    }
} else {
    echo "<p>No orders yet!</p>";
}
?>

</body>
</html>
