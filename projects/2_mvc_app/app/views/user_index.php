<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <title>Home</title>
</head>

<body>
    <h1>Users List</h1>
    <a href="?controller=user&action=create">Add New User</a>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)
                <a href="?controller=user&action=update&id=<?= $user['id'] ?>">Edit</a>
                <a href="?controller=user&action=delete&id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>