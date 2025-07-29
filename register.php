<?php
session_start();
require __DIR__ . '/api/config.php';

// 1) Load current user (for header)
$currentUser = null;
if (!empty($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([ $_SESSION['user_id'] ]);
    $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
    // Already registered/logged in? Send them home
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $u = trim($_POST['username']);
  $e = trim($_POST['email']);
  $p = $_POST['password'];

  if (!filter_var($e, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email address.";
  } elseif (strlen($p) < 6) {
    $error = "Password must be at least 6 characters.";
  }

  if (!$error) {
    $hash = password_hash($p, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare(
      "INSERT INTO users (username,email,password_hash) VALUES (?,?,?)"
    );
    try {
      $stmt->execute([$u, $e, $hash]);
      $_SESSION['user_id'] = $pdo->lastInsertId();
      header('Location: index.php');
      exit;
    } catch (PDOException $ex) {
      if ($ex->getCode() === '23000') {
        $error = "Username or email already taken.";
      } else {
        $error = "Unexpected error.";
      }
    }
  }
}

// 2) Include header
include __DIR__ . '/partials/header.php';
?>
<main class="auth-form">
  <h2>Register</h2>
  <?php if($error): ?><p class="error"><?=htmlspecialchars($error)?></p><?php endif; ?>
  <form method="POST">
    <input name="username" placeholder="Username" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
</main>
<?php include __DIR__. '/partials/footer.php'; ?>
