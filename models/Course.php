<?php

include 'Topic.php';

// Factory and Decorator

interface Course{
    public function create(): void;
}

class CourseAddOns implements Course{
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

class TextCourse implements Course{
    public function create(): void{
        echo "You created a text course";
    }
}

class VideoCourse implements Course{
    public function create(): void{
        echo "You created a video course";
    }
}

class LiveCourse implements Course{
    public function create(): void{
        echo "You created a live course";
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