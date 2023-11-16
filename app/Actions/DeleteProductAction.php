<?php 

namespace App\Actions;

use App\Repositories\ProductRepository;

class DeleteProductAction
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute($id)
    {
        try {
            $this->productRepository->delete($id);
            session()->flash('success', 'Product Deleted Successfully!!');
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }
}
