<?php

namespace App\Actions;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class UpdateProductAction
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function execute($productId, $validated, $image, $thumbnail)
    {
        try {
            if ($image) {
                $validated['image'] = $this->uploadImage($image);
            }

            if ($thumbnail) {
                $validated['thumbnail'] = $this->uploadThumbnail($thumbnail);
            }

            $this->productRepository->update($productId, $validated);

            session()->flash('success', 'Product Updated Successfully!!');
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    private function uploadImage($image)
    {
        return $image->store('public/images');
    }

    private function uploadThumbnail($thumbnail)
    {
        return $thumbnail->store('public/thumbnails');
    }
}