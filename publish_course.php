<?php

include 'models/Course.php';
include 'config.php';

$db = Database::getInstance() -> getConnection();

echo($_POST['course_id']);
echo($_POST['title']);
echo($_POST['description']);
echo($_POST['instructor_id']);
echo($_POST['course_type']);
echo($_POST['course_status']);
if(isset($_POST['course_id'])){
    switch($_POST['course_type']){
        case 'text':
            $factory = new TextCourseFactory((int) $_POST['course_id'], $_POST['title'], $_POST['description'], (int) $_POST['instructor_id'], $_POST['course_type'], $_POST['course_status']);
            break;
        case 'video':
            $factory = new VideoCourseFactory((int) $_POST['course_id'], $_POST['title'], $_POST['description'], (int) $_POST['instructor_id'], $_POST['course_type'], $_POST['course_status']);
            break;
        case 'live':
            $factory = new LiveCourseFactory((int) $_POST['course_id'], $_POST['title'], $_POST['description'], (int) $_POST['instructor_id'], $_POST['course_type'], $_POST['course_status']);
            break;
    }

    $coursestmt = $db -> prepare('SELECT id from courses WHERE id = :course_id');

    $coursestmt -> execute([
        ':course_id' => $_POST['course_id']
    ]);

    $courseexists = $coursestmt -> fetch(PDO::FETCH_ASSOC);
    
    if($courseexists){
        $course = $factory->updateCourse($db, (int) $_POST['course_id']);
    } else{
        $course = $factory->pushCourse($db);
    }
} else {
    header('Location: dashboard.php');
}