<?php

include 'config.php';
$db = Database::getInstance()->getConnection();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Marketplace</title>
</head>
<body>
    <a href="login.php">Login</a>
    <a href="courses.php">Courses</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="cart.php">Cart</a>
</body>
</html>