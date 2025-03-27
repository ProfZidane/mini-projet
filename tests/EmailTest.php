<?php
    // Fonction à tester
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Test pour la fonction isValidEmail
class EmailValidationTest extends \PHPUnit\Framework\TestCase {
    public function testIsValidEmail() {
        $this->assertTrue(isValidEmail('test@example.com'));
        $this->assertFalse(isValidEmail('invalid-email'));
        $this->assertFalse(isValidEmail('@example.com'));
    }
}
