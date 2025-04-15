<?php

include 'partials/header.php';
include 'config.php';
include 'models/Users.php';

session_start();
if(isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        header('Location: index.php');
        exit();
    } else{
        session_unset();
        session_destroy();
    }
} else{
    session_unset();
    session_destroy();
}

$db = Database::getInstance()->getConnection();

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email']) && isset($_POST['usertype'])){
    $registercontext = new RegistrationContext();
    $user = new User($_POST['username'], $_POST['password'], $_POST['email'], $_POST['usertype']);
    $registrationstrategy = ($_POST['usertype'] == 'student') ? new StudentRegistration() : new InstructorRegistration();
    $registercontext -> registrationRole($registrationstrategy);
    $registercontext -> registerUser($user, $db);
    header('Location: login.php');
    exit();
}
?>

<form method='POST' action='registration.php'>
    Username: <input type='text' name='username' required><br>
    Password: <input type='password' name='password' required><br>
    Email: <input type='email' name='email' required><br>
    User Type: <select name='usertype'>
        <option value='instructor'>Instructor</option>
        <option value='student'>Student</option>
    </select><br>
    <input type='submit' value="Submit">
</form>

<?php

include 'partials/footer.php';

?>