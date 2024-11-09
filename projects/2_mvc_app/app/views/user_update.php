<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <title>Update User</title>
</head>

<body>
    <h1>Update User</h1>

    <?php if ($user): ?>
        <form action="?controller=user&action=update&id=<?= htmlspecialchars($user['id']) ?>" method="POST">
            <label>Name: <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>"></label><br>
            <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"></label><br>
            <button type="submit">Update</button>
        </form>
    <?php else: ?>
        <p>User not found.</p>
    <?php endif; ?>
</body>

</html>