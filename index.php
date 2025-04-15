<?php

include 'config.php';
$db = Database::getInstance()->getConnection();
include 'partials/header.php';
?>

<a href="login.php">Login</a>
<a href="courses.php">Courses</a>
<a href="dashboard.php">Dashboard</a>
<a href="cart.php">Cart</a>

<?php

include 'partials/footer.php';
?>