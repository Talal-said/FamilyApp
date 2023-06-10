<form action="{{ route('import') }}" method="post" enctype="multipart/form-data">
    @csrf
    <input name="file" type="file">
    <button type="submit">submit</button>
</form>