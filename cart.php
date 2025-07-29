<?php
session_start();
require __DIR__ . '/api/config.php';

$currentUser = null;
if (isset($_SESSION['user_id'])) {
  $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);
}
include __DIR__ . '/partials/header.php';
?>

<main class="cart-container">
  <h2>Your Cart</h2>
  <div id="cart-items">Loading...</div>
  <div id="cart-total"></div> <!-- ✅ Buy Now will be injected here if items exist -->
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const container = document.getElementById('cart-items');
  const totalBox = document.getElementById('cart-total');

  fetch('api/cart.php')
    .then(res => res.json())
    .then(data => {
      if (data.error === 'LOGIN_REQUIRED') {
        window.location.href = 'login.php';
        return;
      }

      const items = data;
      if (items.length === 0) {
        container.innerHTML = '<p>Your cart is empty.</p>';
        totalBox.textContent = '';
        return;
      }

      let total = 0;
      container.innerHTML = items.map(item => {
        const subtotal = item.price * item.quantity;
        total += subtotal;
        return `
          <div class="cart-item" data-id="${item.id}">
            <img src="${item.image_url}" alt="${item.name}" class="cart-img">
            <div class="cart-info">
              <h3>${item.name}</h3>
              <p>Price: ₹${item.price}</p>
              <p>Quantity: ${item.quantity}</p>
              <p>Subtotal: ₹${subtotal}</p>
              <button class="remove-btn">Remove</button>
            </div>
          </div>
        `;
      }).join('');

      // ✅ Inject total and Buy Now button only if cart has items
      totalBox.innerHTML = `
        <h3>Total: ₹${total}</h3>
        <div class="cart-actions" style="margin-top: 20px;">
          <form action="payment.php" method="POST">
            <button type="submit" class="buy-now-btn">Buy Now</button>
          </form>
        </div>
      `;

      // Remove item from cart
      document.querySelectorAll('.remove-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
          const cartItem = e.target.closest('.cart-item');
          const itemId = cartItem.dataset.id;

          const res = await fetch('api/cart.php', {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: itemId })
          });

          const result = await res.json();
          if (result.success) {
            cartItem.remove();
            location.reload(); // reload to reflect new cart state
          } else {
            alert('❌ Failed to remove item.');
          }
        });
      });
    })
    .catch(err => {
      container.innerHTML = '<p>Something went wrong. Please try again later.</p>';
      console.error('Fetch error:', err);
    });
});
</script>

<?php include __DIR__ . '/partials/footer.php'; ?>
