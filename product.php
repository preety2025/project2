<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blinkit – Groceries in Minutes</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Header … same as before … -->
  <section class="products">
    <div class="container">
      <div class="section-header">
        <h2>Popular Products</h2>
        <div class="delivery-badge">
          <span class="clock-icon">🕐</span>
          <span>Delivery in 8 minutes</span>
        </div>
      </div>

      <!-- ← EMPTY container for JS to fill -->
      <div class="products-grid" id="products-grid"></div>

    </div>
  </section>
  <script src="js/main.js"></script>
</body>
</html>