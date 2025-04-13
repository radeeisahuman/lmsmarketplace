<?php

class Course{
    private string $id;
    private string $name;


    public function __construct(string $name){
        $this -> name = $name;
    }
}

?>