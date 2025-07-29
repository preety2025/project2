<?php
session_start();
require __DIR__ . '/api/config.php';

$currentUser = null;
if (isset($_SESSION['user_id'])) {
  $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get user's cart items
$stmt = $pdo->prepare("
  SELECT c.id, c.product_id, c.quantity, p.name, p.price
  FROM cart c
  JOIN products p ON p.id = c.product_id
  WHERE c.user_id = ?
");
$stmt->execute([$_SESSION['user_id']]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cartItems as $item) {
  $total += $item['price'] * $item['quantity'];
}

// Insert into orders table (optional) and clear cart
$stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (?, ?)");
$stmt->execute([$_SESSION['user_id'], $total]);
$orderId = $pdo->lastInsertId();

// Insert order items
$stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($cartItems as $item) {
  $stmtItem->execute([
    $orderId, $item['product_id'], $item['quantity'], $item['price']
  ]);
}

// Clear cart
$pdo->prepare("DELETE FROM cart WHERE user_id = ?")->execute([$_SESSION['user_id']]);

?>
<?php include 'partials/header.php'; ?>
<main class="payment-confirmation">
  <h2>✅ Order Placed Successfully!</h2>
  <p>Your order ID is <strong>#<?= $orderId ?></strong></p>
  <p>Total paid: ₹<?= $total ?></p>
  <a href="index.php" class="btn">Go to Home</a>
</main>
<?php include 'partials/footer.php'; ?>
