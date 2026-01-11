<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $order_id = $_POST['order_id'];
    $message = $_POST['message'];

    $sql = "INSERT INTO complaints (name, email, order_id, message) VALUES ('$name', '$email', '$order_id', '$message')";
    if ($conn->query($sql)) {
        echo "<script>alert('Complaint submitted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to submit complaint!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Complaint Form</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
    }

    .container {
      max-width: 400px;
      background: #fff;
      margin: 50px auto;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    h2 {
      text-align: center;
      color: #2874f0;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    input, textarea {
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 10px;
      outline: none;
    }

    input:focus, textarea:focus {
      border-color: #2874f0;
    }

    textarea {
      resize: none;
      height: 100px;
    }

    button {
      padding: 12px;
      background: #2874f0;
      color: #fff;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.3s;
    }

    button:hover {
      background: #1a5ed0;
    }

    /* 600px Breakpoint */
    @media (max-width: 600px) {
      .container {
        max-width: 90%;
        margin: 30px auto;
        padding: 25px;
      }
      
      h2 {
        font-size: 22px;
        margin-bottom: 15px;
      }
      
      input, textarea, button {
        padding: 10px;
        margin: 8px 0;
      }
      
      textarea {
        height: 90px;
      }
    }

    /* 380px Breakpoint */
    @media (max-width: 380px) {
      .container {
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
      }
      
      h2 {
        font-size: 20px;
        margin-bottom: 12px;
      }
      
      input, textarea, button {
        padding: 8px;
        margin: 6px 0;
        border-radius: 8px;
      }
      
      textarea {
        height: 80px;
      }
      
      button {
        padding: 10px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Customer Complaint Form</h2>
    <form method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <input type="text" name="order_id" placeholder="Order ID (Optional)">
      <textarea name="message" placeholder="Write your complaint..." required></textarea>
      <button type="submit" name="submit">Submit Complaint</button>
    </form>
  </div>
</body>
</html>