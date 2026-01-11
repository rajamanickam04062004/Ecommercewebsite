<?php
session_start();
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (fullname, email, mobile) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $mobile);
    
    if ($stmt->execute()) {
        // Set session variables consistently with login.php
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_mobile'] = $mobile;
        
        // Also set the 'customer' session for backward compatibility
        $_SESSION['customer'] = [
            'fullname' => $name,
            'email' => $email,
            'mobile' => $mobile
        ];
        
        echo "<script>alert('Registration Successful'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Registration Failed');</script>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>Flipkart</h1>
  <div id="cen">
    <h2>Register</h2>
    <form method="POST">
      <input type="text" name="fullname" placeholder="Full Name" required autocomplete="off"><br>
      <input type="email" name="email" placeholder="Email" required autocomplete="off"><br>
      <input type="text" name="mobile" placeholder="Mobile Number" required autocomplete="off"><br>
      <button type="submit">Submit</button>
    </form>
    <a href="login.php">I already have an account</a>
  </div>
</body>
</html>

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
    padding:20px;
  }
  
  #cen {
    border: 1px solid white;
    width: 40%;
    max-width: 400px;
    padding: 20px;
    border-radius: 10px;
    transition: 0.5s;
    text-align: center;
    background: rgba(0, 0, 0, 0.6);
  }
  
  #cen:hover {
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
    width: 90%;
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
    
    #cen {
      margin-left:10%;
      width: 90%;
      padding: 15px;
    }

    input, button {
      width: 90%;
      font-size: 14px;
    }
  }
</style>
