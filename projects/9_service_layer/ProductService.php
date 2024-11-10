<?php
class ProductService
{
    protected $productRepository;
    protected $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function purchaseProduct($productId, $userId)
    {
        $product = $this->productRepository->find($productId);

        if ($product->stock <= 0) {
            throw new Exception("Product out of stock");
        }

        $product->stock--;
        $this->productRepository->update($product);
        $this->userRepository->addPurchase($userId, $productId);

        return "Purchase successful!";
    }
}
