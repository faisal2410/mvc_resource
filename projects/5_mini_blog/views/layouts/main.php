// views/layouts/main.php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Mini Blog') ?></title>
</head>

<body>
    <?php include 'views/partials/header.php'; ?>

    <main>
        <?php include "views/{$view}.php"; ?>
    </main>

    <?php include 'views/partials/footer.php'; ?>
</body>

</html>