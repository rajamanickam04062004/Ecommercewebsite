<?php 
session_start();
include 'connect.php';

// Update address
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_address'])) {
    $house = $_POST['house_no'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $pin = $_POST['pin'];
    $state = $_POST['state'];
    $district = $_POST['district'];

    $email = $_SESSION['user_email'];

    $stmt = $conn->prepare("UPDATE users SET house_no=?, street=?, city=?, pin=?, state=?, district=? WHERE email=?");
    $stmt->bind_param("sssssss", $house, $street, $city, $pin, $state, $district, $email);
    
    if ($stmt->execute()) {
        echo "<script>alert('Address Updated'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Failed to Update Address');</script>";
    }
    $stmt->close();
}

// Fetch user data
$user = null;
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My E-Commerce</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <style>
    @media (max-width: 600px) {
      .admin a span, .menu a span {
        display: none;
      }

      .admin a i, .menu a i {
        font-size: 25px;
      }

      #searchContainer {
        display: none;
        position: absolute;
        top: 50px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        background: white;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
      }

      #searchIcon {
        font-size: 25px;
        cursor: pointer;
      }
    }

    /* Search Box */
    #searchContainer {
      position: relative;
      width: 300px;
      margin: 20px auto;
    }

    #searchInput {
      padding: 10px 15px;
      width: 100%;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    #suggestions {
      position: absolute;
      top: 100%;
      left: 0;
      width: 100%;
      background: white;
      border: 1px solid #ddd;
      border-top: none;
      max-height: 200px;
      overflow-y: auto;
      z-index: 999;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    #suggestions div {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }

    #suggestions div:hover {
      background: #f1f1f1;
      color: #333;
    }

    /* Menu Toggle Styles */
    #customerDetails {
      display: none;
      position: fixed;
      top: 0;
      right: 0;
      width: 300px;
      height: 100%;
      background: white;
      z-index: 1000;
      padding: 20px;
      box-shadow: -2px 0 5px rgba(0,0,0,0.2);
      overflow-y: auto;
    }
    
    #customerDetails.show {
      display: block;
      animation: slideIn 0.3s forwards;
    }
    
    #customerDetails.hide {
      animation: slideOut 0.3s forwards;
    }
    
    @keyframes slideIn {
      from { transform: translateX(100%); }
      to { transform: translateX(0); }
    }
    
    @keyframes slideOut {
      from { transform: translateX(0); }
      to { transform: translateX(100%); }
    }
    
    #closeMenu {
      position: absolute;
      top: 10px;
      right: 10px;
      background: none;
      border: none;
      font-size: 20px;
      cursor: pointer;
    }
    
    .menu-toggle {
      cursor: pointer;
      padding: 10px;
      background: #007bff;
      color: white;
      border-radius: 5px;
      margin: 10px;
      display: inline-block;
    }
    
    /* Rest of your existing styles */
    .category { 
      position: relative; 
      margin-bottom: 40px; 
      padding: 0 40px;
    }
    
    .category h2 {
      margin-bottom: 15px;
      color: #333;
      font-size: 24px;
    }
    
    .product-container { 
      display: flex; 
      overflow-x: auto; 
      scroll-behavior: smooth;
      gap: 20px;
      padding: 10px 0;
    }
    
    #addressForm { 
      display: none; 
      margin-top: 10px;
      padding: 15px;
      background: #f5f5f5;
      border-radius: 5px;
    }
    
    #addressForm input {
      width: 100%;
      padding: 8px;
      margin: 5px 0;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
  </style>
</head>
<body>

<header>
  <div class="menu-toggle" onclick="toggleCustomerDetails()">
    <i class="fa fa-bars" style="font-size:20px;"></i>&nbsp;Menu
  </div>
  <div class="admin">
    <a href="index.php" title="home"><i class="fa fa-home" style="font-size:25px;"></i>&nbsp;Home</a>
  </div>
  <div class="admin">
    <a href="https://drive.google.com/file/d/1af3fU6AWuE6j8w2TgQ2DMKFnzEQbqADQ/view?usp=drivesdk" title="Government Approved"><i class="fa fa-institution" style="font-size:20px;"></i>&nbsp;<span>Government Approved</span></a>
  </div>
  <div class="admin">
    <a href="https://drive.google.com/file/d/1af3fU6AWuE6j8w2TgQ2DMKFnzEQbqADQ/view?usp=drivesdk" title="Admin Details"><i class="fa fa-vcard-o" style="font-size:20px;"></i>&nbsp;<span>Admin Details</span></a>
  </div>
  <div class="admin">
    <a href="myorder.php" title="my orders"><i class="fa fa-envelope-o" style="font-size:25px;"></i>&nbsp;<span>my orders</span></a>
  </div>
  
  <center>
    <div id="searchContainer">
      <input type="text" id="searchInput" placeholder="Search Product..." autocomplete="off">
      <div id="suggestions"></div>
    </div>
  </center>
  
  <div class="signup">
    <?php if (isset($_SESSION['user_name'])): ?>
      <div class="user-status">
        <i class="fa fa-user" style="font-size:20px;"></i>&nbsp;<?php echo $_SESSION['user_name']; ?>
        <form action="logout.php" method="post" style="display:inline;">
          <button type="submit" class="logout-btn">Logout</button>
        </form>
      </div>
    <?php else: ?>
      <i class="fa fa-user-secret" style="font-size:20px;"></i>&nbsp;Account
      <div id="signlist">
        <a href="register.php">Sign Up</a>
        <a href="login.php">Login</a>
      </div>
    <?php endif; ?>
  </div>
</header>

<div id="menulist"></div>

<div class="product-container">
  <div class="product-list" id="productList">
    <div class="menu" id="menuBtn"><a href="trendproduct.php" title="products" ><i class="fa fa-ellipsis-v" style="font-size:20px;"></i>&nbsp;<span class="hide">tools & kit set</span></a></div>
  </div>
  <div class="logo">
    <h1>UDYAM MANUFACTURING</h1>
  </div>
</div>

<div class="content">
  <iframe src="http://localhost:8080/storewebsite/productlist.php"></iframe>
  <style>
    iframe {
      width: 100%;
      height: 700px;
      border: none;
      overflow: hidden;
    }
  </style>
</div>

<div id="customerDetails">
  <button id="closeMenu" onclick="toggleCustomerDetails()">×</button>
  
  <h3><i class="fa fa-user-circle-o" style="font-size:20px;color:red"></i>&nbsp;Customer Details</h3>
  <ul>
    <?php if (isset($_SESSION['user_name'])) { ?>
      <li>Name: <?php echo $_SESSION['user_name']; ?></li>
      <li>Phone: <?php echo $_SESSION['user_mobile'] ?? 'Stored Securely'; ?></li>
      <li>Email: <?php echo $_SESSION['user_email']; ?></li>
    <?php } else { ?>
      <li>Name: Guest User</li>
      <li>Phone: Not logged in</li>
      <li>Email: Not logged in</li>
    <?php } ?>
  </ul>

  <h3><i class="fa fa-cab" style="font-size:20px;color:red"></i>&nbsp;Address</h3>
  <ul>
    <?php if ($user) { ?>
      <li>House/Building: <?php echo $user['house_no'] ?? 'Not provided'; ?></li>
      <li>Street: <?php echo $user['street'] ?? 'Not provided'; ?></li>
      <li>City/Town: <?php echo $user['city'] ?? 'Not provided'; ?></li>
      <li>Pin Number: <?php echo $user['pin'] ?? 'Not provided'; ?></li>
      <li>State: <?php echo $user['state'] ?? 'Not provided'; ?></li>
      <li>District: <?php echo $user['district'] ?? 'Not provided'; ?></li>
    <?php } else { ?>
      <li>Please login to view your address</li>
    <?php } ?>
  </ul>

  <?php if (isset($_SESSION['user_email'])) { ?>
    <button onclick="document.getElementById('addressForm').style.display='block'" style="margin-top: 10px;">Update Address</button>
    <form id="addressForm" method="POST">
      <input type="text" name="house_no" placeholder="House/Building No" value="<?php echo $user['house_no'] ?? ''; ?>" required><br>
      <input type="text" name="street" placeholder="Street" value="<?php echo $user['street'] ?? ''; ?>" required><br>
      <input type="text" name="city" placeholder="City/Town" value="<?php echo $user['city'] ?? ''; ?>" required><br>
      <input type="text" name="pin" placeholder="Pin Number" value="<?php echo $user['pin'] ?? ''; ?>" required><br>
      <input type="text" name="state" placeholder="State" value="<?php echo $user['state'] ?? ''; ?>" required><br>
      <input type="text" name="district" placeholder="District" value="<?php echo $user['district'] ?? ''; ?>" required><br>
      <button type="submit" name="update_address">Update</button>
    </form>
  <?php } ?>
  
  <h3>Shop by Category</h3>
  <ul>
    <li>mobile phones</li>
    <li>computers</li>
    <li>tv fride</li>
  </ul>
  
  <h3>Help & Settings</h3>
  <ul>
    <li><a href="myaccount.php">Your Account</a></li>
    <li><a href="customer_service.php">Customer Service</a></li>
    <?php if (!isset($_SESSION['user_name'])): ?>
      <li><a href="login.php">Sign in</a></li>
    <?php endif; ?>
  </ul>
</div>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-row">
      <div class="footer-col">
        <h3>Get to Know Us</h3>
        <ul>
          <li><a href="#">About Amazon</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press Releases</a></li>
        </ul>
      </div>
      
      <div class="footer-col">
        <h3>Connect with Us</h3>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Twitter</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
      
      <div class="footer-col">
        <h3>Make Money with Us</h3>
        <ul>
          <li><a href="#">Sell on Amazon</a></li>
          <li><a href="#">Sell under Amazon</a></li>
          <li><a href="#">Accelerator</a></li>
          <li><a href="#">Protect and Build Your Brand</a></li>
          <li><a href="#">Amazon Global Selling</a></li>
          <li><a href="#">Supply to Amazon</a></li>
          <li><a href="#">Become an Affiliate</a></li>
        </ul>
      </div>
      
      <div class="footer-col">
        <h3>Let Us Help You</h3>
        <ul>
          <li><a href="myaccount.php">Your Account</a></li>
          <li><a href="#">Returns Centre</a></li>
          <li><a href="#">Recalls and Product Safety Alerts</a></li>
          <li><a href="#">100% Purchase Protection</a></li>
          <li><a href="#">Amazon App Download</a></li>
          <li><a href="complaint.php">Help</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<script>
  // Toggle customer details panel
  function toggleCustomerDetails() {
    const details = document.getElementById('customerDetails');
    if (details.classList.contains('show')) {
      details.classList.add('hide');
      setTimeout(() => {
        details.classList.remove('show', 'hide');
      }, 300);
    } else {
      details.classList.add('show');
    }
  }

  // Close panel when clicking outside
  document.addEventListener('click', function(event) {
    const details = document.getElementById('customerDetails');
    const menuBtn = document.querySelector('.menu-toggle');
    if (!details.contains(event.target) && event.target !== menuBtn && !menuBtn.contains(event.target)) {
      if (details.classList.contains('show')) {
        details.classList.add('hide');
        setTimeout(() => {
          details.classList.remove('show', 'hide');
        }, 300);
      }
    }
  });

  // Enhanced Search functionality with individual product pages
  const products = [
    { name: "iPhone 14 Pro", page: "iphone.php" },
    { name: "Samsung Galaxy S23", page: "samsung.php" },
    { name: "OnePlus 11R", page: "oneplus.php" },
    { name: "Sony Headphones", page: "sony.php" },
    { name: "Dell Inspiron Laptop", page: "dell.php" },
    { name: "HP Pavilion Laptop", page: "hp.php" },
    { name: "Apple Watch Series 9", page: "applewatch.php" },
    { name: "Realme Buds Wireless", page: "realme.php" },
    { name: "Boat Airpods", page: "boat.php" },
    { name: "Canon DSLR Camera", page: "canon.php" }
  ];

  const input = document.getElementById('searchInput');
  const suggestionBox = document.getElementById('suggestions');

  input.addEventListener('input', function() {
    const query = this.value.toLowerCase();
    suggestionBox.innerHTML = '';

    if (query.length === 0) return;

    const filtered = products.filter(p => 
      p.name.toLowerCase().includes(query)
    );
    
    if (filtered.length === 0) {
      const noResults = document.createElement('div');
      noResults.innerText = 'No products found';
      suggestionBox.appendChild(noResults);
      return;
    }

    filtered.forEach(product => {
      const div = document.createElement('div');
      div.innerText = product.name;
      div.style.cursor = 'pointer';
      div.style.padding = '10px';
      div.onclick = () => {
        // Redirect to the specific product page
        window.location.href = product.page;
      };
      suggestionBox.appendChild(div);
    });
  });

  document.addEventListener('click', function(e) {
    if (!document.getElementById('searchContainer').contains(e.target)) {
      suggestionBox.innerHTML = '';
    }
  });
</script>
</body>
</html>