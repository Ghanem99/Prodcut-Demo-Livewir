<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all()
    {
        return Product::all();
    }

    public function findOrFail($id)
    {
        return Product::findOrFail($id);
    }

    public function create($data)
    {
        return Product::create($data);
    }

    public function update($id, $data)
    {
        return Product::whereId($id)->update($data);
    }

    public function delete($id)
    {
        return Product::find($id)->delete();
    }
}
