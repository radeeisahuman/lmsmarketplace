<?php
session_start();
include 'models/Enrollment.php';
include 'config.php';

if(isset($_POST['course_id']) && isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        $db = Database::getInstance()->getConnection();
        $user = $db->prepare("SELECT id FROM users WHERE name = :name");
        $user->execute([
            ":name" => $_SESSION['username']
        ]);
        $user_result = $user->fetch(PDO::FETCH_ASSOC);
        $user_id = $user_result['id'];

        $courses = $db->prepare("SELECT course_id FROM enrollments WHERE student_id = :student_id and course_id = :course_id");
        $courses -> execute([
            ':student_id' => $user_id,
            ':course_id' => $_POST['course_id']
        ]);
        $course_id = $courses -> fetch(PDO::FETCH_ASSOC);

        if(!$course_id){
            $enrollment_manager = new Enrollment();
            $finish_enroll = new ConfirmEnrollment($db);
            $enrollment_manager -> register($finish_enroll);
            $enrollment_manager -> notify($_POST['course_id'], $user_id);
            header('Location: dashboard.php');
        } else{
            header('Location: dashboard.php');
        }
    } else{
        header('Location: login.php');
    }
}

?>