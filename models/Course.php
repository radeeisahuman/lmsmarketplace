<?php

include 'Topic.php';

// Factory and Decorator

abstract class Course{
    private int $id;
    private string $title;
    private string $description;
    private int $instructor_id;
    private string $type;
    private string $status;

    public function __construct(int $id, string $title, string $description, int $instructor_id, string $type, string $status){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->instructor_id = $instructor_id;
        $this->type = $type;
        $this->status = $status;
    }

    public function pushCourseLive(PDO $db){
        $stmt = $db -> prepare("INSERT INTO courses (title, description, instructor_id, type, status) VALUES (:title, :description, :instructor_id, :type, :status)");
        $stmt -> execute([
            ':title' => $this -> title,
            ':description' => $this -> description,
            ':instructor_id' => $this -> instructor_id,
            ':type' => $this -> type,
            ':status' => $this -> status,
        ]);
    }

    public function updateCourse(PDO $db, int $course_id){
        $stmt = $db -> prepare("UPDATE courses SET title = :title, description = :description, instructor_id = :ins_id, type = :type, status = :status WHERE id = :course_id");
        $stmt -> execute([
            ':title' => $this -> title,
            ':description' => $this -> description,
            ':ins_id' => $this -> instructor_id,
            ':type' => $this -> type,
            ':status' => $this -> status,
            ':course_id' => $course_id
        ]);
    }
    
    abstract public function create(): void;
}

class CourseAddOns extends Course{
    protected Course $course;
    protected TopicBuilder $builder;

    public function __construct(Course $course, TopicBuilder $builder){
        $this->course = $course;
        $this->builder = $builder;
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

    public function addLesson(string $name, string $duration, string $content){
        $topic = CreateTopic($this->builder, $name, $duration, $content);
    }
}

class Quiz extends CourseAddOns{
    public function create(): void{
        $this->course->create();
        $this->addQuiz();
    }

    public function addQuiz(string $name, string $duration, string $content){
        $topic = CreateTopic($this->builder, $name, $duration, $content);
    }
}

class Assignment extends CourseAddOns{
    public function create(): void{
        $this->course->create();
        $this->addAssignment();
    }

    public function addAssignment(string $name, string $duration, string $content){
        $topic = CreateTopic($this->builder, $name, $duration, $content);
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
    public int $id;
    public string $title;
    public string $description;
    public int $instructor_id;
    public string $type;
    public string $status;

    public function __construct(int $id, string $title, string $description, int $instructor_id, string $type, string $status){
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->instructor_id = $instructor_id;
        $this->type = $type;
        $this->status = $status;
    }

    abstract public function createCourse(): Course;

    public function pushCourse(PDO $db): void{
        $course = $this -> createCourse();
        $course -> create();
        $course -> pushCourseLive($db);
    }

    public function updateCourse(PDO $db, int $id): void{
        $course = $this -> createCourse();
        $course -> create();
        $course -> updateCourse($db, $id);
    }

}

class TextCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new TextCourse($this->id, $this->title, $this->description, $this->instructor_id, $this->type, $this->status);
    }
}

class VideoCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new VideoCourse($this->id, $this->title, $this->description, $this->instructor_id, $this->type, $this->status);
    }
}

class LiveCourseFactory extends CourseFactory{
    public function createCourse(): Course{
        return new LiveCourse($this->id, $this->title, $this->description, $this->instructor_id, $this->type, $this->status);
    }
}


?>