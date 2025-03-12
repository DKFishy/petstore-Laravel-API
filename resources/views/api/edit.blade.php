<!-- resources/views/api/edit.blade.php -->

<form action="{{ route('pets.update', ['petId' => $pet['id']]) }}" method="POST">
    @csrf
    @method('PUT')

    <label for="id">ID:</label>
    <input type="text" id="id" name="id" value="{{ $pet['id'] }}" readonly>

    <!-- text fields only accept letters, spaces, apostrophes, special letters  -->
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s']+" value="{{ $pet['name'] }}" required placeholder="Pet name">
    <label for="category">Category name:</label>
    <input type="text" id="category" name="category" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s']+" value="{{ $pet['category']['name'] ?? '' }}" placeholder="Category name">
    
    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="available" {{ $pet['status'] === 'available' ? 'selected' : '' }}>Available</option>
        <option value="pending" {{ $pet['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="sold" {{ $pet['status'] === 'sold' ? 'selected' : '' }}>Sold</option>
    </select>

    <br>

    <button type="submit">Save Changes</button>
</form>
