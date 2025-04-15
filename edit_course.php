<?php
session_start();
include 'partials/header.php';
include 'config.php';
$db = Database::getInstance()->getConnection();

if(isset($_GET['course_id']) && isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        $user = $db->prepare("SELECT id, role FROM users WHERE name = :name");
        $user->execute([
            ':name' => $_SESSION['username']
        ]);
        $user_array = $user->fetch(PDO::FETCH_ASSOC);
        
        if($user_array['role'] == 'instructor'){
            $courses = $db->prepare("SELECT id, title, description, type, status FROM courses WHERE id = :id");
            $courses->execute([
                ':id' => $_GET['course_id']
            ]);

            $course = $courses->fetch(PDO::FETCH_ASSOC);

            $lessons = $db->prepare("SELECT name, content, lesson_type FROM topics WHERE course_id = :course_id");
            $lessons->execute([
                ':course_id' => $_GET['course_id']
            ]);

            $lesson_array = $lessons->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <form method="POST" action="publish_course.php">
                Course Title: <input type="text" name="title" value="<?php echo $course['title']; ?>"><br>
                Course Description: <input type="text" name="description" value="<?php echo $course['description']; ?>"><br>
                <input type="hidden" name="instructor_id" value="<?php echo $user_array['id']; ?>">
                <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                Course Type: <input type="text" name="course_type" value="<?php echo $course['type']; ?>">
                Course Status: <input type="text" name="course_status" value="<?php echo $course['status']; ?>">
                <div id="topics_div">
                    <?php 
                    foreach ($lesson_array as $lesson){
                    ?>
                    <div>
                        Add topic: <input name="topic[]" type="text" value="<?php echo $lesson['name']; ?>">
                        Add content: <input name="lesson_content[]" type="text" value="<?php echo $lesson['content']; ?>">
                        Type:
                        <select name="lesson_type[]">
                            <option value="lesson">Lesson</option>
                            <option value="quiz">Quiz</option>
                            <option value="assignment">Assignment</option>
                        </select>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <button type="button" onclick="addTopic()">Add more</button>
                <input type="submit" value="Submit">
            </form>
            <?php
        } else{
            header('Location: dashboard.php');
        }
    } else{
        header('Location: login.php');
    }
} else{
    header('Location: index.php');
}

?>



<?php

include 'partials/footer.php';

?>