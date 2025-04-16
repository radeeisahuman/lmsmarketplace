<?php

include 'models/Course.php';
include 'config.php';

$db = Database::getInstance() -> getConnection();
/*
echo($_POST['course_id']);
echo($_POST['title']);
echo($_POST['description']);
echo($_POST['instructor_id']);
echo($_POST['course_type']);
echo($_POST['course_status']);
*/
if(isset($_POST['instructor_id'])){
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

    if(isset($_POST['course_id'])){
        $coursestmt = $db -> prepare('SELECT id from courses WHERE id = :course_id');

        $coursestmt -> execute([
            ':course_id' => $_POST['course_id']
        ]);

        $courseexists = $coursestmt -> fetch(PDO::FETCH_ASSOC);
    } else {
        $courseexists = FALSE;
    }
    
    $last_value = end($_POST);
    if($courseexists){
        $factory->updateCourse($db, (int) $_POST['course_id']);
        $new_course = $factory -> createCourse();
        array_map(function($topic, $lesson_content, $lesson_type){
            switch($lesson_type){
                case 'lesson':
                    $add_on = new Lesson($new_course);
                    $add_on -> addLesson($topic, $lesson_content, $db);
                    break;
                case 'quiz':
                    $add_on = new Quiz($new_course);
                    $add_on -> addQuiz($topic, $lesson_content, $db);
                    break;
                case 'assignment':
                    $add_on = new Assignment($new_course);
                    $add_on -> addAssignment($topic, $lesson_content, $db);
                    break;
            }
        }, $_POST['topic'], $_POST['lesson_content'], $last_value);
    } else{
        $course = $factory->pushCourse($db);
        header('Location: dashboard.php');
    }
} else {
    header('Location: dashboard.php');
}