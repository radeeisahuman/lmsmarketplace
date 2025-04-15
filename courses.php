<?php

include 'partials/header.php';
include 'config.php';
include 'models/Enrollment.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT courses.id, courses.title, courses.description, courses.instructor_id, users.name FROM courses INNER JOIN users ON courses.instructor_id = users.id WHERE status='published'");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($courses as $course){
    ?>
    <form method="post" action="enroll.php">
    <h2><?php echo $course['title']; ?></h2>
    <p><?php echo $course['description']; ?></p>
    <p><?php echo $course['title']; ?></p>
    <p>By the instructor: <?php echo $course['name']; ?></p>
    <input type="hidden" name="course_id" value="<?php echo $course['id'] ?>">
    <input type="submit" value="Enroll Now">
    </form>
    <?php
}
?>



<?php

include 'partials/footer.php'

?>