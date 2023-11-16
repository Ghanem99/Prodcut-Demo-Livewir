<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Repositories\ProductRepository;

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
    
    public function boot(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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
        
        if ($this->image) {
            $validated['image'] = $this->image->store('public/images');
        }
        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('public/thumbnails');
        }

        try {
            $this->productRepository->create($validated);

            session()->flash('success', 'Product Created Successfully!!');
            $this->resetFields();
            $this->addProduct = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
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
                $this->image = null;
                $this->thumbnail = null;
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
        
        if ($this->image) {
            $validated['image'] = $this->image->store('public/images');
        }
        if ($this->thumbnail) {
            $validated['thumbnail'] = $this->thumbnail->store('public/thumbnails');
        }

        try {
            $this->productRepository->update($this->productId, $validated);

            session()->flash('success', 'Product Updated Successfully!!');
            $this->resetFields();
            $this->updateProduct = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    public function cancelProduct()
    {
        $this->addProduct = false;
        $this->updateProduct = false;
        $this->resetFields();
    }

    public function deleteProduct($id)
    {
        try {
            $this->productRepository->delete($id);
            session()->flash('success', 'Product Deleted Successfully!!');
        } catch (\Exception $e) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }
}
