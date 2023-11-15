<div>
    <div class="col-md-8 mb-2">
        @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
        @if($addProduct)
            @include('livewire.includes.create')
        @endif
        @if($updateProduct)
            @include('livewire.includes.update')
        @endif
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(!$addProduct)
                <button wire:click="addProductForm()" class="btn btn-primary btn-sm float-right">Add New product</button>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Thumbnail</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($products) > 0)
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            {{$product->name}}
                                        </td>
                                        <td>
                                            {{$product->description}}
                                        </td>

                                        <td>
                                            {{$product->price}}
                                        </td>
                                        <td>
                                            <img src="{{ asset('images/' . $product->image) }}" alt="Product Image" width="100">
                                        </td>
                                        <td>
                                            <img src="{{ asset('thumbnails/' . $product->thumbnail) }}" alt="Product thumbnail" width="100">
                                        </td>
                                        <td>
                                            <button wire:click="editProduct({{ $product->id }})" class="btn btn-primary btn-sm">Edit</button>
                                            <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-danger btn-sm">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" align="center">
                                        No products Found.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
 
</div>