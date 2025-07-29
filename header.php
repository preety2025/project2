<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blinkit – Groceries in Minutes</title>
  <link rel="stylesheet" href="style.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  </a>
</head>

<body>
  <header class="header">
    <!-- Top Bar -->
    <div class="top-bar">
      <div class="container">
        <div class="top-bar-content">
          <div class="delivery-info">
            <span class="icon">🚚</span>
            <span>Free delivery on orders above ₹199</span>
          </div>
          <div class="security-info">
            <span class="icon">🛡</span>
            <span>100% Safe & Secure</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Header -->
    <div class="main-header">
      <div class="container">
        <div class="header-content">
          <!-- Logo -->
          <div class="logo">
            <a href="index.php" class="logo" title="Go to Home">
              <div class="logo-icon">⚡</div>
              <div class="logo-text">
                <h1>blinkit</h1>
                <p>Groceries in minutes</p>
              </div>
            </a>
          </div>

          <!-- Location -->
          <div class="location">
            <span class="location-icon">📍</span>
            <div class="location-text">
              <p class="delivery-time">Delivery in 8 minutes</p>
              <p class="address">Jamshedpur, Tata</p>
            </div>
            <span class="dropdown-icon">▼</span>
          </div>


          <!-- Search -->
          <div class="search-container">
            <div class="search-box">
              <span class="search-icon">🔍</span>
              <input
                type="text"
                id="search-input"
                placeholder="Search for products..."
                class="search-input"
                autocomplete="off">
            </div>
            <div id="search-results" class="search-results"></div>
          </div>


          <!-- User Actions -->
          <div class="user-actions">
            <?php if ($currentUser): ?>
              <span class="welcome">
                Welcome, <?= htmlspecialchars($currentUser['username']) ?>
              </span>
              <a href="logout.php" class="logout-link">Logout</a>
            <?php else: ?>
              <a href="login.php" class="login-btn">
                <span class="user-icon">👤</span>
                <span>Login</span>
              </a>
              <a href="register.php" class="register-btn">Register</a>
            <?php endif; ?>

            <a href="cart.php" class="cart-btn">
              <span class="cart-icon">🛒</span>
              <span>Cart</span>
              <span class="cart-count">0</span>
            </a>

          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- page‑specific content will follow -->
  <script src="js/main.js"></script>