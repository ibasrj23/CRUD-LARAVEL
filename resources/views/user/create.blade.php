<h1>Tambah User</h1>

<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <label>Nama:</label>
    <input type="text" name="name" value="{{ old('name') }}"> <br><br>

    <label>Email:</label>
    <input type="email" name="email" value="{{ old('email') }}"> <br><br>

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('users.index') }}">Kembali</a>
