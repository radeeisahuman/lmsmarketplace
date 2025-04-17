<?php

include 'partials/header.php';
include 'models/Enrollment.php';

$db = Database::getInstance()->getConnection();
$stmt = $db->prepare("SELECT courses.id, courses.title, courses.description, courses.instructor_id, courses.type, users.name FROM courses INNER JOIN users ON courses.instructor_id = users.id WHERE status='published'");
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*
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
} */
?>

<div class="container mt-4">
    <h2 class="text-center p-2">Available Courses</h2>
    <div class="row">
        <?php foreach ($courses as $course): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card shadow" style="width: 20rem; height: 20rem">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <h5 class="card-title"><strong><?= htmlspecialchars($course['title']) ?></strong></h5>
                        <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                        <p class="card-text">Type: <?= htmlspecialchars($course['type']) ?></p>
                        <div class="text-center mt-auto">
                        <form method="POST" action="enroll.php">
                            <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                            <button type="submit" class="btn text-white" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105)); border: none">Enroll</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>



<?php

include 'partials/footer.php'

?>