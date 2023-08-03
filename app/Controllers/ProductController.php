<?php
namespace App\Controllers;

use App\Models\Product;
use PDO;

class ProductController
{
    private $conn;
    private $auth;
    private $productModel;

    public function __construct(PDO $conn, $auth)
    {
        $this->conn = $conn;
        $this->auth = $auth;
        $this->productModel = new Product($this->conn);
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function getAuth()
    {
        return $this->auth;
    }

    private function getTokenFromHeaders()
    {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        $arr = explode(" ", $authHeader);

        if (count($arr) === 2 && $arr[0] === 'Bearer') {
            return $arr[1];
        }

        return '';
    }

    public function index()
    {
        $token = $this->getTokenFromHeaders();

        if (!$token || !$this->auth->verifyToken($token)) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized.' ]);
            return;
        }

        $products = $this->productModel->getAllProducts();
        echo json_encode($products);
    }

    public function show($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found.']);
        }
    }

    public function store()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name']) || !isset($data['price'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid product data.']);
            return;
        }

        $product = $this->productModel->createProduct($data['name'], $data['description'] ?? '', $data['price']);
        http_response_code(201);
        echo json_encode(['message' => 'Product created successfully.', 'product' => $product]);
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['name']) || !isset($data['price'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid product data.']);
            return;
        }

        $product = $this->productModel->updateProduct($id, $data['name'], $data['description'] ?? '', $data['price']);

        if ($product) {
            echo json_encode(['message' => 'Product updated successfully.', 'product' => $product]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found.']);
        }
    }

    public function destroy($id)
    {
        $deleted = $this->productModel->deleteProduct($id);

        if ($deleted) {
            echo json_encode(['message' => 'Product deleted successfully.']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found.']);
        }
    }

    public function renderview()
    {
        include('../');
    }
}
