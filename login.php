<?php
include 'partials/header.php';
if(isset($_SESSION) && isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        header('Location: index.php');
        exit();
    } else{
        echo 'invalid credentials';
    }
}
?>

<form method="GET" action="dashboard.php">
    Username: <input type='text' name='username'><br>
    Password: <input type='password' name='password'><br>
    <input type='submit' value='Login'>
</form>


<?php
include 'partials/footer.php'
?>