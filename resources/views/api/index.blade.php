<!-- resources/views/api/index.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>List of pets</title>
</head>
<body>
    <h1>Pets</h1>
    <br/>

    <form action="{{ route('pets.add') }}" method="GET">
    @csrf
    <button type="submit">Add new</button>
    
    <ul>
        @foreach ($data as $item)
            <li>Id: {{ $item['id']}}</li>
            <li>Name: {{ isset($item['name']) ? $item['name'] : 'N/A' }}</li>
            <li>Category: {{ isset($item['category']['name']) ? $item['category']['name'] : 'N/A' }}</li>
            <!-- extra field in case assigning ID is required, otherwise 0 is used to automatically generate the ID -->
            <!--<li>Category: {{ isset($item['category']['id']) ? $item['category']['id'] : 'N/A' }}</li>-->
            <li>Status: {{ isset($item['status']) ? $item['status'] : 'N/A' }}</li>
            <br/>
            <!-- entry editing -->
            <form action="{{ route('pets.editForm', ['petId' => $item['id']]) }}" method="GET">
                @csrf
                <button type="submit">Update</button>
            </form>
                
            <!-- entry removal -->
            <form action="{{ route('pets.destroy', ['petId' => $item['id']]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                <button type="submit">Delete</button>
            </form>
            <br/>
        @endforeach
    </ul>
</body>
</html>
