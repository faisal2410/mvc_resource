<?php
class ProductRepository implements ProductRepositoryInterface
{
    protected $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find($productId)
    {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->bindParam(':id', $productId);
        $statement->execute();

        return $statement->fetchObject(Product::class);
    }

    public function update($product)
    {
        $statement = $this->pdo->prepare("UPDATE products SET stock = :stock WHERE id = :id");
        $statement->bindParam(':stock', $product->stock);
        $statement->bindParam(':id', $product->id);
        $statement->execute();
    }
}
