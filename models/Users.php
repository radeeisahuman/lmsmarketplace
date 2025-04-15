<?php

class User{
    private string $name;
    private string $email;
    private string $password;
    private string $role;

    public function __construct(string $name, string $password, string $email, string $role){
        $this -> name = $name;
        $this -> email = $email;
        $this -> password = $password;
        $this -> role = $role;
    }

    public function getName(){
        return $this->name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getRole(){
        return $this->role;
    }
}

// Strategy Pattern

abstract class UserRegistration{
    abstract public function register(User $user, PDO $db);

    public function insert(PDO $db, User $user): void{
        $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES(:name, :email, :password, :role)");

        $stmt -> execute([
            ':name' => $user->getName(),
            ':email' => $user->getEmail(),
            ':password' => $user->getPassword(),
            ':role' => $user->getRole()
        ]);
    }
}

class InstructorRegistration extends UserRegistration{
    public function register(User $user, PDO $db){
        $this -> insert($db, $user);
    }
}

class StudentRegistration extends UserRegistration{
    public function register(User $user, PDO $db){
        $this -> insert($db, $user);
    }
}

class AdminRegistration extends UserRegistration{
    public function register(User $user, PDO $db){
        $this -> insert($db, $user);
    }
}

class RegistrationContext{
    private UserRegistration $registration;

    public function registrationRole(UserRegistration $reg){
        $this -> registration = $reg;
    }

    public function registerUser(User $user, PDO $db){
        if(isset($this -> registration)){
            $this -> registration -> register($user, $db);
        } else {
            echo "No registration mode set";
        }
    }
}