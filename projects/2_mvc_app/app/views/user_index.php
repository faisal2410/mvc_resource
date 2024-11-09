<h1>Users List</h1>
<a href="?controller=user&action=create">Add New User</a>
<ul>
    <?php foreach ($users as $user): ?>
        <li><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</li>
    <?php endforeach; ?>
</ul>