<?php
session_start();
require __DIR__ . '/api/config.php';

// 1) Load current user (for header)
$currentUser = null;
if (!empty($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([ $_SESSION['user_id'] ]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    // Already logged in? Send them home
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = trim($_POST['username']);
  $p = $_POST['password'];

  $stmt = $pdo->prepare(
    "SELECT id,password_hash FROM users WHERE username=? OR email=? LIMIT 1"
  );
  $stmt->execute([$u,$u]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($p,$user['password_hash'])) {
    $_SESSION['user_id'] = $user['id'];
    header('Location: index.php');
    exit;
  } else {
    $error = "Invalid credentials.";
  }
}

// 2) Include header (which will use $currentUser)
include __DIR__ . '/partials/header.php';
?>
<main class="auth-form">
  <h2>Login</h2>
  <?php if($error): ?><p class="error"><?=htmlspecialchars($error)?></p><?php endif; ?>
  <form method="POST">
    <input name="username" placeholder="Username or Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
  </form>
</main>
<?php include __DIR__. '/partials/footer.php'; ?>
