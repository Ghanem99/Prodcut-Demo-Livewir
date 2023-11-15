<div class="card">
    <div class="card-body">
        <form>
            <div class="form-group mb-3">
                <label for="name">Name:</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" wire:model="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" wire:model="description" placeholder="Enter Description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="price">Price:</label>
                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Enter price" wire:model="price">
                @error('price')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Image:</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" wire:model="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="thumbnail">Thumbnail:</label>
                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror" id="thumbnail" wire:model="thumbnail">
                @error('thumbnail')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="d-grid gap-2">
                <button wire:click.prevent="updateProductForm()" class="btn btn-success btn-block">Update</button>
                <button wire:click.prevent="cancelProduct()" class="btn btn-secondary btn-block">Cancel</button>
            </div>
        </form>
    </div>
</div>