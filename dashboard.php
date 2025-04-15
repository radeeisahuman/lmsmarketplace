<?php

include 'config.php';
$db = Database::getInstance()->getConnection();
session_start();

include 'partials/header.php';
if($_SESSION['loggedin']){
    echo 'Hi There ' . $_SESSION['username'];
} else{
    $username = $_GET['username'];
    $password = $_GET['password'];

    $query = "SELECT name, password FROM users WHERE name='$username' and password='$password'";

    $result = $db->query($query);

    $user = $result->fetch(PDO::FETCH_ASSOC);

    if ($user){
        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
    } else{
        $_SESSION['loggedin'] = false;
        header('Location: login.php');
        exit();
    }
}
?>

<a href='logout.php'>logout</a>


<?php

include 'partials/footer.php';

?>