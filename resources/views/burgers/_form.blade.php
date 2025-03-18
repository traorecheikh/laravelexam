<div class="form-group">
    <label for="nom">Nom</label>
    <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $burger->nom) }}" required>
</div>

<div class="form-group">
    <label for="prix">Prix (CFA)</label>
    <input type="number" step="0.01" name="prix" id="prix" class="form-control" value="{{ old('prix', $burger->prix) }}"
           required>
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control"
              rows="4">{{ old('description', $burger->description) }}</textarea>
</div>

<div class="form-group">
    <label for="stock">Stock</label>
    <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $burger->stock) }}"
           required>
</div>

<div class="form-group">
    <label for="image">Image</label>
    <input type="file" name="image" id="image" class="form-control">
    @if($burger->image)
        <img src="{{ asset('storage/' . $burger->image) }}" alt="{{ $burger->nom }}" class="img-thumbnail mt-2"
             width="150">
    @endif
</div>
