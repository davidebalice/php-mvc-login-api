<?php
namespace App\Models;
use PDO;

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $tableName = TABLE_PREFIX . 'products';
        $stmt = $this->conn->query("SELECT * FROM $tableName");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $tableName = TABLE_PREFIX . 'products';
        $stmt = $this->conn->prepare("SELECT * FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $description, $price)
    {
        $tableName = TABLE_PREFIX . 'products';
        $stmt = $this->conn->prepare("INSERT INTO $tableName (name, description, price) VALUES (:name, :description, :price)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->execute();
        $productId = $this->conn->lastInsertId();
        return $this->getProductById($productId);
    }

    public function updateProduct($id, $name, $description, $price)
    {
        $tableName = TABLE_PREFIX . 'products';
        $stmt = $this->conn->prepare("UPDATE $tableName SET name = :name, description = :description, price = :price WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->execute();

        return $this->getProductById($id);
    }

    public function deleteProduct($id)
    {
        $tableName = TABLE_PREFIX . 'products';
        $stmt = $this->conn->prepare("DELETE FROM $tableName WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
