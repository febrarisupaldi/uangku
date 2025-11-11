<!DOCTYPE html>
<html>
<head>
    <title>Aktivasi Akun Uangku</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}</h2>
    <p>Terima kasih telah mendaftar di <b>Uangku</b>.</p>
    <p>Klik tombol di bawah untuk mengaktifkan akun Anda:</p>
    <a href="{{ $activationUrl }}" 
       style="background: #16a34a; color: white; padding: 10px 20px; text-decoration:none; border-radius:5px;">
       Aktivasi Akun
    </a>
    <p>Jika Anda tidak merasa mendaftar, abaikan email ini.</p>
</body>
</html>
