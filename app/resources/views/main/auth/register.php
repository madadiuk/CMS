<!-- Inside app/resources/views/main/auth/register.php -->
<?php if (isset($success) && $success): ?>
    <!-- We use isset to check if $message is defined before trying to echo it -->
    <p><?= htmlspecialchars($message ?? '') ?> Your user ID is <?= htmlspecialchars($userId ?? '') ?>.</p>
<?php elseif (isset($error)): ?>
    <!-- We do the same check for $error -->
    <p>Error: <?= htmlspecialchars($error ?? '') ?></p>
<?php endif; ?>

<!-- Rest of the registration form -->
<form action="/register" method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
</form>