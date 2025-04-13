<?php

class User{
    private string $id;
    private string $name;
    private string $email;
    private string $password;
    private string $role;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(string $id, string $name, string $password, string $role, DateTime $createdAt, DateTime $updatedAt){
        $this -> id = $id;
        $this -> name = $name;
        $this -> email = $email;
        $this -> password = $password;
        $this -> role = $role;
        $this -> createdAt = $createdAt;
        $this -> updatedAt = $updatedAt;
    }
}

interface UserRegistration{
    public function register(User $user);
}

class InstructorRegistration implements UserRegistration{
    public function execute(User $user){
        echo 'Created New Instructor: ' . $user -> name;
    }
}

class StudentRegistration implements UserRegistration{
    public function execute(User $user){
        echo 'Created New Learner: ' . $user -> name;
    }
}

class AdminRegistration implements UserRegistration{
    public function execute(User $user){
        echo 'Created New Admin: ' . $user -> name;
    }
}

class RegistrationContext{
    private UserRegistration $registration;

    public function registrationRole(UserRegistration $reg){
        $this -> registration = $registration;
    }

    public function register(){
        if(isset($this -> registration)){
            $this -> registration -> execute;
        } else {
            echo "No registration mode set";
        }
    }
}