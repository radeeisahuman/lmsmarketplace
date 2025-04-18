<?php

class Topic{
    public string $name;
    public string $type;
    public string $content;
}

abstract class TopicBuilder{
    public Topic $topic;

    public function __construct(Topic $topic){
        $this->topic = $topic;
    }

    public function returnTopic(): Topic{
        return $this -> topic;
    }

    abstract public function addName(string $name): void;
    abstract public function addType(): void;
    abstract public function addContent(string $content): void;
}

class LessonBuilder extends TopicBuilder{
    
    public function addName(string $name): void{
        $this->topic->name = $name;
    }

    public function addType(): void{
        $this->topic->type = "Lesson";
    }

    public function addContent(string $content): void{
        $this->topic->content = $content;
    }

}

class QuizBuilder extends TopicBuilder{
    
    public function addName(string $name): void{
        $this->topic->name = $name;
    }

    public function addType(): void{
        $this->topic->type = "Quiz";
    }

    public function addContent(string $content): void{
        $this->topic->content = $content;
    }

}

class AssignmentBuilder extends TopicBuilder{
    
    public function addName(string $name): void{
        $this->topic->name = $name;
    }

    public function addType(): void{
        $this->topic->type = "Assignment";
    }

    public function addContent(string $content): void{
        $this->topic->content = $content;
    }

}

function CreateTopic(TopicBuilder $builder, string $name, string $content){
    $builder -> addName($name);
    $builder -> addType();
    $builder -> addContent($content);

    return $builder->returnTopic();
}