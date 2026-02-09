<!DOCTYPE html>
<html>
<head>
    <title>Aplikasi Parkir</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 6px;
        }
        h2 {
            margin-top: 0;
        }
        input, select, button {
            width: 100%;
            padding: 8px;
            margin-top: 8px;
        }
        button {
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
        }
        .success {
            background: #d4edda;
        }
        .error {
            background: #f8d7da;
        }
        hr {
            margin: 30px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>🚗 Aplikasi Parkir</h2>

    <p><strong>Saldo Operator:</strong> Rp {{ number_format($operator->balance ?? 0) }}</p>

    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert error">{{ session('error') }}</div>
    @endif

    <hr>

    <h3>Kendaraan Masuk</h3>
    <form method="POST" action="{{ route('parking.enter') }}">
        @csrf
        <input type="text" name="plate_number" placeholder="Plat Nomor" required>

        <select name="type" required>
            <option value="">-- Jenis Kendaraan --</option>
            <option value="motor">Motor</option>
            <option value="mobil">Mobil</option>
        </select>

        <input type="text" name="driver_name" placeholder="Nama Pengendara" required>

        <button type="submit">Masuk Parkir</button>
    </form>

    <hr>

    <h3>Kendaraan Keluar</h3>
    <form method="POST" action="{{ route('parking.exit') }}">
        @csrf
        <input type="text" name="plate_number" placeholder="Plat Nomor" required>

        <button type="submit">Keluar Parkir</button>
    </form>
</div>

</body>
</html>
