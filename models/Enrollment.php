<?php



// Observer Interface
interface EnrollmentObserver {
    public function update(int $course_id, int $user_id);
}

// Subject
class Enrollment {
    private array $observers = [];

    public function register(EnrollmentObserver $observer) {
        $this->observers[] = $observer;
    }

    public function unregister(EnrollmentObserver $observer) {
        $this->observers = array_filter(
            $this->observers,
            fn($obs) => $obs !== $observer
        );
    }

    public function notify(int $course_id, int $user_id) {
        foreach ($this->observers as $observer) {
            $observer->update($course_id, $user_id);
        }
    }
}

// Observer for learner notification
class NotifyLearner implements EnrollmentObserver {
    private \PDO $db;
    private int $learnerId;

    public function __construct(PDO $db, int $learnerId) {
        $this->db = $db;
        $this->learnerId = $learnerId;
    }

    public function update(int $course_id, int $user_id) {
        $message = "You have been enrolled in course ID: $course_id";
        $stmt = $this->db->prepare("INSERT INTO notifications (learner_id, course_id, message) VALUES (:user_id, :course_id, :message)");
        $stmt->execute([
            ':user_id' => $this->learnerId,
            ':course_id' => $course_id,
            ':message' => $message
        ]);
    }
}

// Observer for instructor notification
class NotifyInstructor implements EnrollmentObserver {
    private \PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function update(int $course_id, int $user_id) {
        // Get instructor of the course
        $stmt = $this->db->prepare("SELECT instructor_id FROM courses WHERE id = :course_id");
        $stmt->execute([':course_id' => $course_id]);
        $instructor = $stmt->fetch();

        if ($instructor) {
            $instructorId = $instructor['instructor_id'];
            $message = "A new student (ID: $user_id) enrolled in your course ID: $course_id";

            $stmt = $this->db->prepare("INSERT INTO notifications (user_id, course_id, message) VALUES (:user_id, :course_id, :message)");
            $stmt->execute([
                ':user_id' => $instructorId,
                ':course_id' => $course_id,
                ':message' => $message
            ]);
        }
    }
}

// Observer to confirm enrollment in the enrollments table
class ConfirmEnrollment implements EnrollmentObserver {
    private \PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function update(int $course_id, int $user_id) {
        $stmt = $this->db->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)");
        $stmt->execute([
            ':student_id' => $user_id,
            ':course_id' => $course_id
        ]);
    }
}
