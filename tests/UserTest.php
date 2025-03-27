<?php

    // Classe à tester
class User {
    private $firstName;
    private $lastName;

    public function __construct($firstName, $lastName) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getFullName() {
        return $this->firstName . ' ' . $this->lastName;
    }
}

// Test pour la classe User
class UserTest extends \PHPUnit\Framework\TestCase {
    public function testGetFullName() {
        $user = new User('John', 'Doe');
        $this->assertEquals('John Doe', $user->getFullName());

        $user = new User('Jane', 'Smith');
        $this->assertEquals('Jane Smith', $user->getFullName());
    }
}
