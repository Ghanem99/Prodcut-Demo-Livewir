<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Repositories\ProductRepository;

use App\Actions\UpdateProductAction;
use App\Actions\CreateProductAction;
use App\Actions\DeleteProductAction;

class Product extends Component
{
    use WithFileUploads;

    public $products,
            $name,
            $description,
            $price,
            $image,
            $thumbnail,
            $productId,
            $updateProduct = false,
            $addProduct = false;
            
            protected $listeners = [
                'deleteProductListener' => 'deleteProduct'
            ];
            
            protected $rules = [
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];
            
    private $productRepository;
    private $updateProductAction;
    private $createProductAction;
    
    public function boot(
        ProductRepository $productRepository, 
        UpdateProductAction $updateProductAction, 
        CreateProductAction $createProductAction, 
        DeleteProductAction $deleteProductAction
        )
    {
        $this->productRepository = $productRepository;
        $this->updateProductAction = $updateProductAction;
        $this->createProductAction = $createProductAction;
        $this->deleteProductAction = $deleteProductAction;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->image = null;
        $this->thumbnail = null;
    }

    public function render()
    {
        $this->products = $this->productRepository->all();
        return view('livewire.product');
    }

    public function addProductForm()
    {
        $this->resetFields();
        $this->addProduct = true;
        $this->updateProduct = false;
    }

    public function storeProduct()
    {
        $validated = $this->validate();

        $this->createProductAction->execute($validated, $this->image, $this->thumbnail);

        $this->resetFields();
        $this->addProduct = false;
    }

    public function editProduct($id)
    {
        try {
            $product = $this->productRepository->findOrFail($id);
            
            if (!$product) {
                session()->flash('error', 'Product not found');
            } else {
                $this->name = $product->name;
                $this->description = $product->description;
                $this->price = $product->price;
                $this->image = asset('storage/images/' . $product->image);
                $this->thumbnail = asset('storage/thumbnails' . $product->thumbnail);
                $this->productId = $product->id;
                $this->updateProduct = true;
                $this->addProduct = false;
            }
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    public function updateProductForm()
    {
        $validated = $this->validate();

        $this->updateProductAction->execute($this->productId, $validated, $this->image, $this->thumbnail);
    
        $this->resetFields();
        $this->updateProduct = false;
    }

    public function cancelProduct()
    {
        $this->addProduct = false;
        $this->updateProduct = false;
        $this->resetFields();
    }

    public function deleteProduct($id)
    {
        $result = $this->deleteProductAction->execute($id);
    }
}
