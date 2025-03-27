<?php
use PHPUnit\Framework\TestCase;

class AuthTest extends TestCase {
    private $pdo;

    protected function setUp(): void {
        $this->pdo = new PDO('mysql:host=localhost;dbname=notes_esigelec', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        // Insérer un utilisateur de test avant les tests
        $this->pdo->exec("INSERT INTO users (username, password, is_admin) VALUES ('admin', '" . md5('password123') . "', 1)");
    }

    protected function tearDown(): void {
        // Nettoyer la base après les tests
        $this->pdo->exec("DELETE FROM users WHERE username = 'admin'");
    }

    public function testUserCanLogin() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute(['username' => 'admin', 'password' => md5('password123')]);
        
        $user = $stmt->fetch();
        $this->assertNotFalse($user, "L'utilisateur devrait pouvoir se connecter.");
    }

    public function testInvalidLoginFails() {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->execute(['username' => 'fakeuser', 'password' => md5('wrongpass')]);
        
        $user = $stmt->fetch();
        $this->assertFalse($user, "Une connexion invalide ne doit pas fonctionner.");
    }

    /**
     * @runInSeparateProcess
     */
    public function testSessionIsStarted() {
        session_start();
        $_SESSION['user'] = 'admin';
        $this->assertArrayHasKey('user', $_SESSION, "La session doit contenir une clé 'user'.");
    }
}
