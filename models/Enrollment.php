<?php

include 'Course.php';

// Observer

interface EnrollmentObserver{
    public function update(Course $course);
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

    public function notify($course){
        foreach($this->observers as $observer){
            $observer -> update($course);
        }
    }
}

class EmailLearner implements EnrollmentObserver{
    private string $email;

    public function __construct(string $email){
        $this->email = $email;
    }

    public function update(Course $course){
        echo "Email sent to: " . $this->email;
        echo "Message: Enrolled in the course " . $course->name;
    }
}

class EmailInstructor implements EnrollmentObserver{
    private string $learneremail;
    private string $instructoremail;

    public function __construct(string $lEmail,string $iEmail){
        $this -> learneremail = $lEmail;
        $this -> instructoremail = $iEmail;
    }

    public function update(Course $course){
        echo "Hey there " . $this->instructoremail . ", you have a new enrollment in " . $course->name;
        echo "The learner's email is " . $this->learneremail;
    }
}

class ConfirmEnrollment implements EnrollmentObserver{
    private string $course_id;

    public function __construct(string $id){
        $this -> course_id = $id;
    }

    public function update(Course $course){
        echo "Enrolled in the " . $course->name;
        echo "Course ID is " . $this -> course_id;
    }
}