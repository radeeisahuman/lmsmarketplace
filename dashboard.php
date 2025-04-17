<?php


include 'partials/header.php';


$db = Database::getInstance()->getConnection();

if(isset($_SESSION['loggedin'])){
    if($_SESSION['loggedin']){
        echo '<h2 class="text-center p-2">Hi There ' . $_SESSION['username'] . '</h2>';
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
<!-- <a href='logout.php'>logout</a> -->

<?php
$stmt = $db->prepare("SELECT id, name, role FROM users WHERE name=:name");
$stmt->execute([
    ':name' => $_SESSION['username']
]);
$currentuser = $stmt->fetch(PDO::FETCH_ASSOC);

if($currentuser['role'] == 'instructor'){
    $findcourses = $db->prepare("SELECT courses.id, courses.title, courses.type, courses.description FROM courses INNER JOIN users on users.id = courses.instructor_id WHERE users.id = :user_id");
    $findcourses -> execute([
        ':user_id' => $currentuser['id']
    ]);
    $courses = $findcourses -> fetchAll(PDO::FETCH_ASSOC);
    //echo "<h2>Displaying your courses</h2>";
} else if($currentuser['role'] == 'student'){
    $findcourses = $db->prepare("SELECT courses.id, courses.title, courses.type, courses.description FROM courses INNER JOIN enrollments on courses.id = enrollments.course_id WHERE enrollments.student_id=:student_id");
    $findcourses -> execute([
        ':student_id' => $currentuser['id']
    ]);
    $courses = $findcourses -> fetchAll(PDO::FETCH_ASSOC);
    echo "<h2>Enrolled in the following courses</h2>";
}
/*
if(isset($courses)){

    foreach ($courses as $course){
        echo "<h3>" . $course['title'] . "</h3>";
        echo "<p>" . $course['description'] . "</p>";
        if ($currentuser['role'] == 'instructor'){
            ?>
            <form method="GET" action="edit_course.php">
                <input name="course_id" type="hidden" value="<?php echo $course['id']; ?>">
                <input type="submit" value="Edit Course">
            </form>
            <hr>
            <?php
        }
    }

    if ($currentuser['role'] == 'instructor'){
        echo "<a href='add_course.php'>Add A New Course</a>";
    }

}
*/
$notifications = [];
$sql="SELECT message, created_at FROM notifications WHERE learner_id = ?";
$notification_arr = $db->prepare($sql);
$user_id = [$currentuser['id']];
//echo $user_id[0];
$notification_arr->execute($user_id);
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($notifications);
?>

<div class="container mt-3">
    <div class="d-flex justify-content-end">
        <div class="dropdown">
            <button class="btn dropdown-toggle text-white" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105))" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Notifications
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="max-height: 300px; overflow-y: auto;">
                <?php if (empty($notifications)): ?>
                    <li><span class="dropdown-item-text text-muted">No notifications</span></li>
                <?php else: ?>
                    <?php foreach ($notifications as $note): ?>
                        <li>
                            <span class="dropdown-item-text">
                                <?= htmlspecialchars($note['message']) ?><br>
                                <small class="text-muted"><?= date('M d, Y H:i', strtotime($note['created_at'])) ?></small>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<div class="container mt-4">
    <h2 class="text-center p-2">
        <?= $currentuser['role'] === 'instructor' ? 'My Courses (Instructor)' : 'My Enrolled Courses (Learner)' ?>
    </h2>
    <div class="row">
        <?php if (empty($courses)): ?>
            <div class="alert alert-warning">No course added yet.</div>
        <?php else: ?>
        <?php foreach ($courses as $course): ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="card shadow" style="width: 20rem; height: 20rem;">
    <div class="card-body d-flex flex-column">
        <!-- Title -->
        <h5 class="card-title mb-2 text-center"><strong><?= htmlspecialchars($course['title']) ?></strong></h5>

        <!-- Description -->
        <p class="card-text mb-2" style="flex-grow: 1; overflow: hidden; text-overflow: ellipsis;">
            <?= htmlspecialchars($course['description']) ?>
        </p>
<?php
        //var_dump($course);
?>
        <!-- Type -->
        <p class="card-text mb-3 text-muted"><?= htmlspecialchars($course['type']) ?> Course</p>

        <!-- Buttons -->
        <div class="mt-auto text-center">
            <div class="d-flex justify-content-center gap-2">
                <!-- View button -->
                <form method="POST" action="viewcourse.php">
                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                    <button type="submit" class="btn text-white" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105)); border: none">View</button>
                </form>

                <!-- Edit button (only for instructors) -->
                <?php if ($currentuser['role'] === 'instructor'): ?>
                <form method="GET" action="edit_course.php">
                    <input type="hidden" name="course_id" value="<?= htmlspecialchars($course['id']) ?>">
                    <button type="submit" class="btn text-white" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105)); border: none">Edit</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Add Course button for instructors only -->
        <?php if ($currentuser['role'] === 'instructor'): ?>
        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
            <div class="card shadow" style="width: 20rem; height: 20rem">
                <div class="card-body d-flex justify-content-center align-items-center">
                    <a href="add_course.php" class="btn text-white" style="background: linear-gradient(45deg,rgb(98, 0, 179),rgb(41, 6, 105)); border: none">Add Course</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    
    </div>
</div>

<?php

include 'partials/footer.php';

?>