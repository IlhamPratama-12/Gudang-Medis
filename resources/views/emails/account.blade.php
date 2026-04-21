<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>

<h3>Akun Anda Telah Disetujui</h3>

<p>Halo, {{ $user->name }}</p>

<p>Akun Anda telah diaktifkan oleh admin.</p>

<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>Silakan login di:</p>
<a href="{{ url('/login') }}">Login e gudang</a>
<br><br>
<p>Reset password secepatnya setelah anda berhasil login</p>

<br><br>
<p>Terima kasih</p>

</body>
</html>