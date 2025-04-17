<?php
session_start();
include 'partials/header.php';
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
<!--
Course form UI
<section class="d-flex justify-content-center align-items-center bg-light" style="height: 100vh;">
  <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
    <h4 class="mb-3 text-center">Add material</h4>
    <form action="addtopic.php" method="post" >
      <div class="mb-3">
        <label for="topic_name" class="form-label">Name</label>
        <input type="text" name="topic_name" class="form-control" id="topic_name" required>
      </div>
      <div class="mb-3">
        <label for="duration" class="form-label">Duration</label>
        <input type="text" name="duration" class="form-control" id="duration" required>
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" class="form-control" id="content" required></textarea>
      </div>
      <div>
      <input type="hidden" name="course_id" value="htmlspecialchars($course['id'])">
      </div>
      <div class="mb-3">
        <label for="topic_type" class="form-label">Type</label>
        <select class="form-select" id="topic_type" name="topic_type" required>
          <option value="" disabled selected>Select topic type</option>
          <option value="Lesson">Lesson</option>
          <option value="Quiz">Quiz</option>
          <option value="Assignment">Assignment</option>
        </select>
      </div>
      <button type="submit" class="btn text-white w-100" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105)); border: none">Add topic</button>
    </form>
  </div>
</section>
-->

<?php

include 'partials/footer.php';

?>