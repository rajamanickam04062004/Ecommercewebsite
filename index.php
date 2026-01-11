<?php 
session_start();
include 'connect.php';

// Initialize $user variable
$user = null;

// Check if user is logged in (check both old and new session formats)
if (isset($_SESSION['user_email'])) {
    // User is logged in, fetch their data from database
    $email = $_SESSION['user_email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} elseif (isset($_SESSION['customer'])) {
    // For backward compatibility, migrate old session format to new
    if (!isset($_SESSION['user_email'])) {
        $_SESSION['user_name'] = $_SESSION['customer']['fullname'] ?? '';
        $_SESSION['user_email'] = $_SESSION['customer']['email'] ?? '';
        $_SESSION['user_mobile'] = $_SESSION['customer']['mobile'] ?? '';
    }
    
    // Fetch user data again after migration
    $email = $_SESSION['user_email'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
}

// Check for protected pages
$current_page = basename($_SERVER['PHP_SELF']);
$protected_pages = ['myaccount.php', 'myorder.php', 'checkout.php'];

if (!isset($_SESSION['user_email']) && in_array($current_page, $protected_pages)) {
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>My E-Commerce</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body>

<header class="main-header">
  <div class="header-container">
    <!-- Mobile menu toggle -->
    <div class="menu-toggle" onclick="toggleCustomerDetails()">
      <i class="fa fa-bars"></i>
    </div>
    
    <!-- Search bar - visible on all devices -->
    <div class="search-container">
      <input type="text" id="searchInput" placeholder="Search products..." autocomplete="off" style="padding:6px 20px;border-radius:15px">
      <div id="suggestions"></div>
    </div>
    
    <!-- Navigation icons -->
    <nav class="nav-icons">
      <a href="index.php" class="nav-icon" title="Home">
        <i class="fa fa-home" style="font-size:25px"></i>
      </a>
      
      <a href="https://drive.google.com/file/d/1af3fU6AWuE6j8w2TgQ2DMKFnzEQbqADQ/view?usp=drivesdk" class="nav-icon" title="Government Approved">
        <i class="fa fa-institution"></i>
      </a>
      
      <a href="https://drive.google.com/file/d/1af3fU6AWuE6j8w2TgQ2DMKFnzEQbqADQ/view?usp=drivesdk" class="nav-icon" title="Admin Details">
        <i class="fa fa-vcard-o"></i>
      </a>
      
      <a href="myorder.php" class="nav-icon" title="My Orders">
        <i class="fa fa-envelope-o"></i>
      </a>
      
      <div class="nav-icon account-icon" title="Account">
        <?php if (isset($_SESSION['user_name'])): ?>
          <i class="fa fa-user"></i>
          <div class="account-dropdown">
            <div class="user-info">
              <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </div>
            <form action="logout.php" method="post">
              <button type="submit" class="logout-btn">Logout</button>
            </form>
          </div>
        <?php else: ?>
          <i class="fa fa-user-secret"></i>
          <div class="account-dropdown">
            <a href="register.php">Sign Up</a>
            <a href="login.php">Login</a>
          </div>
        <?php endif; ?>
      </div>
    </nav>
  </div>
</header>

<div id="customerDetails">
  <button id="closeMenu" onclick="toggleCustomerDetails()" style="background-color:lightblue">×</button>
  
  <h3><i class="fa fa-user-circle-o" style="font-size:20px;color:red"></i>&nbsp;Customer Details</h3>
  <ul>
    <?php if (isset($_SESSION['user_name'])) { ?>
      <li>Name: <?php echo htmlspecialchars($_SESSION['user_name']); ?></li>
      <li>Phone: <?php echo isset($_SESSION['user_mobile']) ? htmlspecialchars($_SESSION['user_mobile']) : 'Stored Securely'; ?></li>
      <li>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></li>
    <?php } else { ?>
      <li>Name: Guest User</li>
      <li>Phone: Not logged in</li>
      <li>Email: Not logged in</li>
    <?php } ?>
  </ul>

  <h3><i class="fa fa-cab" style="font-size:20px;color:red"></i>&nbsp;Address</h3>
  <ul>
    <?php if ($user !== null) { ?>
      <li>House/Building: <?php echo isset($user['house_no']) ? htmlspecialchars($user['house_no']) : 'Not provided'; ?></li>
      <li>Street: <?php echo isset($user['street']) ? htmlspecialchars($user['street']) : 'Not provided'; ?></li>
      <li>City/Town: <?php echo isset($user['city']) ? htmlspecialchars($user['city']) : 'Not provided'; ?></li>
      <li>Pin Number: <?php echo isset($user['pin']) ? htmlspecialchars($user['pin']) : 'Not provided'; ?></li>
      <li>State: <?php echo isset($user['state']) ? htmlspecialchars($user['state']) : 'Not provided'; ?></li>
      <li>District: <?php echo isset($user['district']) ? htmlspecialchars($user['district']) : 'Not provided'; ?></li>
    <?php } else { ?>
      <li>Please login to view your address</li>
    <?php } ?>
  </ul>

  <?php if (isset($_SESSION['user_email'])) { ?>
    <button onclick="document.getElementById('addressForm').style.display='block'" style="margin-top: 10px;">Update Address</button>
    <form id="addressForm" method="POST" action="update_address.php" style="display:none;">
      <input type="text" name="house_no" placeholder="House/Building No" value="<?php echo isset($user['house_no']) ? htmlspecialchars($user['house_no']) : ''; ?>" required><br>
      <input type="text" name="street" placeholder="Street" value="<?php echo isset($user['street']) ? htmlspecialchars($user['street']) : ''; ?>" required><br>
      <input type="text" name="city" placeholder="City/Town" value="<?php echo isset($user['city']) ? htmlspecialchars($user['city']) : ''; ?>" required><br>
      <input type="text" name="pin" placeholder="Pin Number" value="<?php echo isset($user['pin']) ? htmlspecialchars($user['pin']) : ''; ?>" required><br>
      <input type="text" name="state" placeholder="State" value="<?php echo isset($user['state']) ? htmlspecialchars($user['state']) : ''; ?>" required><br>
      <input type="text" name="district" placeholder="District" value="<?php echo isset($user['district']) ? htmlspecialchars($user['district']) : ''; ?>" required><br>
      <button type="submit" name="update_address">Update</button>
    </form>
  <?php } ?>
  
  <h3>Popular</h3>
  <ul>
    <li><a href="trendproduct.php">Tools sets</a></li>
  </ul>
  
  <h3>Nav Menu</h3>
  <ul>
    <li><a href="trendproduct.php">Goverment Approved</a></li>
    <li><a href="trendproduct.php">Admin Details</a></li>
    <li><a href="myorder.php">My Orders</a></li>
  </ul>

  <h3>Help & Settings</h3>
  <ul>
    <li><a href="myorder.php">Your Account</a></li>
    <li><a href="customer_service.php">Customer Service</a></li>
    <?php if (!isset($_SESSION['user_name'])): ?>
      <li><a href="login.php">Sign in</a></li>
    <?php endif; ?>
    <li><a href="logout.php">sign out</a></li>
  </ul>
</div>

<div class="content">
  <iframe src="productlist.php"></iframe>
  <style>
    iframe {
      width: 100%;
      height: 700px;
      border: none;
      overflow: hidden;
    }
  </style>
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
    { name: "Cable Cutters", page: "CableCutter.php" },
    { name: "Hand tool kit", page: "Handtoolkit.php" },
    { name: "Multimeter", page: "Multimeter.php" },
    { name: "Circuit tester", page: "Circuittester.php" },
    { name: "Bulb holder", page: "Bulbholder.php" },
    { name: "Drill machine", page: "Drillmachine.php" },
    { name: "Metal screw", page: "Metalscrew.php" },
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

  // Toggle account dropdown
  const accountIcon = document.querySelector('.account-icon');
  if (accountIcon) {
    accountIcon.addEventListener('click', function(e) {
      e.stopPropagation();
      this.classList.toggle('active');
    });
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function() {
    if (accountIcon) {
      accountIcon.classList.remove('active');
    }
  });
</script>
</body>
</html>