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
            ?>
            <form>
                Course Title: <input type="text" name="title"><br>
                Course Description: <input type="text" name="description"><br>
                <input type="hidden" name="instructor_id" value="<?php echo $user_array['id']; ?>">
                Course Type: <input type="text" name="type">
                Course Status: <input type="text" name="type">
                <div id="topics_div">
                    <div>
                        Add topic: <input name="topic[]" type="text">
                        Type:
                        <select name="type[]">
                            <option value="lesson">Lesson</option>
                            <option value="quiz">Quiz</option>
                            <option value="assignment">Assignment</option>
                        </select>
                    </div>
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