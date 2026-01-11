<?php
session_start();
include 'connect.php';

// If already logged in, redirect to index
if (isset($_SESSION['user_email'])) {
    header("Location: index.php?from_login=1");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT fullname, email, mobile FROM users WHERE fullname = ? AND email = ?");
    $stmt->bind_param("ss", $fullname, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Set session variables
        $_SESSION['user_name'] = $user['fullname'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_mobile'] = $user['mobile'];
        $_SESSION['customer'] = [
            'fullname' => $user['fullname'],
            'email' => $user['email'],
            'mobile' => $user['mobile']
        ];
        
        // Redirect to original page or index.php with refresh parameter
        $redirect_url = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : 'index.php?from_login=1';
        unset($_SESSION['redirect_url']);
        header("Location: $redirect_url");
        exit;
    } else {
        $error = "Invalid Full Name or Email";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      background-image: url('img/bg.jpg'); 
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: Arial, sans-serif;
      width: 90%;
      height: 97vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    
    h1 {
      font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
      color: antiquewhite;
      text-align: center;
    }
    
    .container {
      border: 1px solid white;
      width: 40%;
      max-width: 400px;
      padding: 20px;
      border-radius: 10px;
      transition: 0.5s;
      text-align: center;
      background: rgba(0, 0, 0, 0.6);
    }
    
    .container:hover {
      border: 1px dotted saddlebrown;
    }
    
    h2, form, a {
      color: white;
      font-family: 'Times New Roman', Times, serif;
      line-height: 25px;
    }
    
    input {
      padding: 12px 20px;
      margin: 10px 0;
      border-radius: 10px;
      font-size: medium;
      color: red;
      font-weight: bold;
      width: 80%;
      border: none;
      outline: none;
    }
    
    button {
      padding: 12px 20px;
      border-radius: 10px;
      cursor: pointer;
      transition: 0.5s;
      width: 100%;
      background: #007bff;
      color: white;
      border: none;
      font-size: 16px;
    }
    
    button:hover {
      background-color: green;
      transition: 0.5s;
    }

    a {
      display: block;
      margin-top: 10px;
      color: lightblue;
    }

    /* Responsive Design for Screens <= 600px */
    @media (max-width: 600px) {
      body {
        padding: 10px;
      }
      
      .container {
        width: 90%;
        padding: 15px;
      }

      input, button {
        width: 90%;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <h1>Flipkart</h1>
  <div class="container">
    <h2>Login</h2>
    <form method="POST">
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">Login</button>
    </form>
    <a href="register.php">Create new account</a>
  </div>
</body>
</html>
