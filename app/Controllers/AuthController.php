<?php
namespace App\Controllers;
use Auth;
use PDO;

class AuthController
{
    private $conn;
    private $auth;

    public function __construct(PDO $conn, Auth $auth)
    {
        $this->conn = $conn;
        $this->auth = $auth;
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid login data.']);
            return;
        }

        $username = $data['username'];
        $password = $data['password'];

        $token = $this->auth->login($username, $password);

        if ($token) {
            $data = [
                'token' => $token,
                'server' => 'php',
            ];

            echo json_encode($data);

        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized.']);
        }
    }
}
