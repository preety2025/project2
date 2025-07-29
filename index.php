<?php
// index.php
// — bring in your PDO connection
session_start();
require __DIR__ . '/api/config.php';
$currentUser = null;
if (!empty($_SESSION['user_id'])) {
  $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
  $stmt->execute([ $_SESSION['user_id'] ]);
  $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
include __DIR__.'/partials/header.php';
include __DIR__.'/partials/categories.php';
include __DIR__.'/partials/product.php';
include __DIR__.'/partials/footer.php';
?>
