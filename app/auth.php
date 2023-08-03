<?php
require_once '../vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    private $conn;
    private $jwt_secret;

    public function __construct(PDO $conn, $jwt_secret)
    {
        $this->conn = $conn;
        $this->jwt_secret = $jwt_secret;
    }

    public function login($username, $password)
    {
        $tableName = TABLE_PREFIX . 'users';
        $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            $token = $this->generateJWT($user);
            return $token;
        }

        return false;
    }

    private function generateJWT($user)
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = array(
            'user_id' => $user['id'],
            'username' => $user['username'],
            'iat' => $issuedAt,
            'exp' => $expirationTime
        );

        $token = JWT::encode($payload, $this->jwt_secret, 'HS256');
        return $token;
    }

    public function verifyToken($token)
    {

        try {
            $decoded = JWT::decode($token, new Key($this->jwt_secret, 'HS256'));
            return true;
        } catch (Exception $e) {
            return false;
        }

    }
}
