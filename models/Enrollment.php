<?php

require_once __DIR__ . '/vendor/autoload.php';

// Observer

interface EnrollmentObserver{
    public function update(int $course_id, int $user_id);
}

class Enrollment{
    private array $observers = [];

    public function register($observer){
        $this -> observers[] = $observer;
    }

    public function unregister($observer){
        $this -> observers = array_filter(
            $this -> observers,
            fn($obs) => $obs !== $observer
        );
    }

    public function notify(int $course_id, int $user_id){
        foreach($this->observers as $observer){
            $observer -> update($course_id, $user_id);
        }
    }
}

class EmailLearner implements EnrollmentObserver{
    private string $email;

    public function __construct(string $email){
        $this->email = $email;
    }

    public function update(int $course_id, int $user_id){
        echo "Email sent to: " . $this->email;
        echo "Message: Enrolled in the course " . $course->name;
    }
}

class EmailInstructor implements EnrollmentObserver{
    private string $learneremail;
    private string $instructoremail;

    public function __construct(string $lEmail, string $iEmail){
        $this -> learneremail = $lEmail;
        $this -> instructoremail = $iEmail;
    }

    public function update(int $course_id, int $user_id){
        echo "Hey there " . $this->instructoremail . ", you have a new enrollment in " . $course->name;
        echo "The learner's email is " . $this->learneremail;
    }
}

class ConfirmEnrollment implements EnrollmentObserver{
    private \PDO $db;

    public function __construct(PDO $db){
        $this -> db = $db;
    }

    public function update(int $course_id, int $user_id){
        $stmt = $this->db->prepare("INSERT INTO enrollments (student_id, course_id) VALUES (:student_id, :course_id)");
        $stmt->execute([
            ':student_id' => $user_id,
            ':course_id' => $course_id
        ]);
    }
}