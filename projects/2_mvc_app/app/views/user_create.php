<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css">
    <title>Add User</title>
</head>

<body>
    <h1>Create New User</h1>
    <form action="?controller=user&action=create" method="POST">
        <label>Name: <input type="text" name="name"></label><br>
        <label>Email: <input type="email" name="email"></label><br>
        <button type="submit">Submit</button>
    </form>
</body>

</html>