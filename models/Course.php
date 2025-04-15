<?php

include 'Topic.php';

// Factory and Decorator

abstract class Course{
    public int $id;
    public string $title;
    public string $description;
    public int $instructor_id;
    public string $type;

    public function __construct(int $id, string $title, string $description, int $instructor_id, string $type){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->instructor_id = $instructor_id;
        $this->type = $type;
    }
    
    abstract public function create(): void;
}

class CourseAddOns extends Course{
    protected Course $course;

    public function __construct(Course $course){
        $this->course = $course;
    }

    public function create(): void{
        $this->course->create();
    }
}

class Lesson extends CourseAddOns{
    public function create(): void{
        $this->course->create();
        $this->addLesson();
    }

    public function addLesson(){
        echo "You added a Lesson";
    }
}

class Quiz extends CourseAddOns{
    public function create(): void{
        $this->course->create();
        $this->addQuiz();
    }

    public function addQuiz(){
        echo "You added a Quiz";
    }
}

class Assignment extends CourseAddOns{
    public function create(): void{
        $this->course->create();
        $this->addAssignment();
    }

    public function addAssignment(){
        echo "You added an Assignment";
    }
}

class TextCourse extends Course{
    public function create(): void{
        $this->type="text";
    }
}

class VideoCourse extends Course{
    public function create(): void{
        $this->type="video";
    }
}

class LiveCourse extends Course{
    public function create(): void{
        $this->type="live";
    }
}

abstract class CourseFactory{
    abstract public function createCourse(): Course;

    public function showCourse(): void{
        $course = $this -> createCourse();
        $course -> create();
    }
}

class TextCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new TextCourse;
    }
}

class VideoCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new VideoCourse;
    }
}

class LiveCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new LiveCourse;
    }
}


?>