<?php

include 'partials/header.php';


$db = Database::getInstance()->getConnection();
?>

<section class="d-flex align-items-center justify-content-center text-white" style="min-height: 100vh; background: linear-gradient(to right,rgb(140, 4, 252),rgb(41, 6, 105));">
  <div class="text-center">
    <h1 class="display-4">Learn Anytime, Anywhere</h1>
    <p class="lead">Join thousands of learners and grow your skills.</p>
    <a href="courses.php" class="btn btn-light btn-lg mt-3">Explore Courses</a>
  </div>
</section>

<?php

include 'partials/footer.php';
?>