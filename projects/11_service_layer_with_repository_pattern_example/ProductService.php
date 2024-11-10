<?php
class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function purchaseProduct($productId, $userId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->stock <= 0) {
            throw new Exception("Product out of stock");
        }

        $product->stock--;
        $this->productRepository->update($product);

        // Additional business logic can go here
    }
}
