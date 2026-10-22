<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Belajar PHP</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .card {
            background: #1e293b;
            padding: 30px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        h1 {
            color: #38bdf8;
        }

        p {
            color: #cbd5e1;
        }
    </style>
</head>
<body>

    <?php
        $nama = "Developer";
        $bahasa = "PHP";
        $versi = PHP_VERSION;
    ?>

    <div class="card">
        <h1>Halo, <?= htmlspecialchars($nama) ?>! 👋</h1>

        <p>Selamat datang di halaman PHP pertamamu.</p>

        <p>Bahasa pemrograman: <strong><?= htmlspecialchars($bahasa) ?></strong></p>

        <p>Versi PHP: <strong><?= htmlspecialchars($versi) ?></strong></p>

        <p>Waktu server: <strong><?= date("d-m-Y H:i:s") ?></strong></p>
    </div>

</body>
</html>
