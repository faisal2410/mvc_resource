<?php
class ProductController
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function purchaseProduct($productId, $userId)
    {
        return $this->productService->purchaseProduct($productId, $userId);
    }
}
