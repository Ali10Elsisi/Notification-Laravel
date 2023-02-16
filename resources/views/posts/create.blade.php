<form action="{{ route('posts.store') }}" method="Post">
    @csrf
    <input type="text" placeholder="title" name="title"><br>
    <input type="text" placeholder="body" name="body"><br>
    <button type="submit">submit</button>
</form>