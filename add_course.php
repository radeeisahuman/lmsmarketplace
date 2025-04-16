<?php
session_start();
include 'partials/header.php';
include 'config.php';
$db = Database::getInstance()->getConnection();


if($_SESSION['loggedin']){
    $user = $db->prepare("SELECT id, role FROM users WHERE name = :name");
    $user->execute([
        ':name' => $_SESSION['username']
    ]);
    $user_array = $user->fetch(PDO::FETCH_ASSOC);
    
    if($user_array['role'] == 'instructor'){
        ?>
        <form method="POST" action="publish_course.php">
            Course Title: <input type="text" name="title"><br>
            Course Description: <input type="text" name="description"><br>
            <input type="hidden" name="instructor_id" value="<?php echo $user_array['id']; ?>">
            Course Type: <input type="text" name="course_type">
            Course Status: <input type="text" name="course_status">
            <input type="submit" value="Submit">
        </form>
        <?php
    } else{
        header('Location: dashboard.php');
    }
} else{
    header('Location: login.php');
}

?>



<?php

include 'partials/footer.php';

?>