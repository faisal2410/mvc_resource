<?php
interface ProductRepositoryInterface
{
    public function find($productId);
    public function update($product);
}
