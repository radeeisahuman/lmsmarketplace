<?php

include 'config.php';
$db = Database::getInstance()->getConnection();
session_start();

include 'partials/header.php';
if(isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        echo 'Hi There ' . $_SESSION['username'] . '<br>';
    }
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
$stmt = $db->prepare("SELECT id, name, role FROM users WHERE name=:name");
$stmt->execute([
    ':name' => $_SESSION['username']
]);
$currentuser = $stmt->fetch(PDO::FETCH_ASSOC);

if($currentuser['role'] == 'instructor'){
    $findcourses = $db->prepare("SELECT title, description FROM courses INNER JOIN users on users.id = courses.instructor_id WHERE users.id = :user_id");
    $findcourses -> execute([
        ':user_id' => $currentuser['id']
    ]);
    $courses = $findcourses -> fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Displaying your courses</h2>";
} else if($currentuser['role'] == 'student'){
    $findcourses = $db->prepare("SELECT title, description FROM courses INNER JOIN enrollments on courses.id = enrollments.course_id WHERE enrollments.student_id=:student_id");
    $findcourses -> execute([
        ':student_id' => $currentuser['id']
    ]);
    $courses = $findcourses -> fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Enrolled in the following courses</h2>";
}

if(isset($courses)){

    foreach ($courses as $course){
        echo "<h3>" . $course['title'] . "</h3>";
        echo "<p>" . $course['description'] . "<p>";
    }

}

?>

<?php

include 'partials/footer.php';

?>