<?php

use PHPUnit\Framework\TestCase;

class RegisterTest extends TestCase
{
    const EMAIL = 'test@example.com';

    public function testEmailNotEmpty()
    {
        $email = RegisterTest::EMAIL; // Email valide
        $this->assertTrue($this->validateEmailNotEmpty($email), "L'email ne doit pas être vide.");
    }

    public function testEmailEmpty()
    {
        $email = ""; // Email vide
        $this->assertFalse($this->validateEmailNotEmpty($email), "L'email ne doit pas être vide.");
    }

    // Test que l'email est dans un format valide
    public function testValidEmailFormat()
    {
        $email = RegisterTest::EMAIL; // Email valide
        $this->assertTrue($this->validateEmailFormat($email), "L'email est au bon format.");
    }

    public function testInvalidEmailFormat()
    {
        $email = "test@com"; // Email invalide (format incorrect)
        $this->assertFalse($this->validateEmailFormat($email), "L'email doit être au bon format.");
    }

    // Test que les mots de passe correspondent
    public function testPasswordsMatch()
    {
        $password = 'testPassword123';
        $confirmPassword = 'testPassword123'; // Mots de passe identiques
        $this->assertTrue($this->validatePasswordsMatch($password, $confirmPassword), "Les mots de passe doivent correspondre.");
    }

    public function testPasswordsDoNotMatch()
    {
        $password = 'testPassword123';
        $confirmPassword = 'differentPassword456'; // Mots de passe différents
        $this->assertFalse($this->validatePasswordsMatch($password, $confirmPassword), "Les mots de passe ne correspondent pas.");
    }

    // Test que les champs ne sont pas vides
    public function testFieldsNotEmpty()
    {
        $username = "validUser123";
        $email = RegisterTest::EMAIL;
        $password = "testPassword123";
        $confirmPassword = "testPassword123";

        // Vérification que les champs ne sont pas vides
        $this->assertTrue($this->validateFieldsNotEmpty($username, $email, $password, $confirmPassword), "Les champs ne doivent pas être vides.");
    }

    public function testFieldsEmpty()
    {
        $username = "";
        $email = RegisterTest::EMAIL;
        $password = "testPassword123";
        $confirmPassword = "testPassword123";

        // Vérification qu'un champ est vide
        $this->assertFalse($this->validateFieldsNotEmpty($username, $email, $password, $confirmPassword), "Tous les champs doivent être remplis.");
    }

    // Méthodes de validation

    // Vérification que l'email n'est pas vide
    private function validateEmailNotEmpty($email)
    {
        return !empty($email);
    }

    // Vérification du format de l'email (format simple)
    private function validateEmailFormat($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    // Vérification que les mots de passe correspondent
    private function validatePasswordsMatch($password, $confirmPassword)
    {
        return $password === $confirmPassword;
    }

    // Vérification que les champs ne sont pas vides
    private function validateFieldsNotEmpty($username, $email, $password, $confirmPassword)
    {
        return !empty($username) && !empty($email) && !empty($password) && !empty($confirmPassword);
    }
}

