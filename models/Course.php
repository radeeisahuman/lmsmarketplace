<?php

interface Course{
    public function create(): void;
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