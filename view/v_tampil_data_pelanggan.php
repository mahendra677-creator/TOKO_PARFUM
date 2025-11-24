<?php
// Sertakan file controller
include_once '../controller/c_pelanggan.php'; // Asumsi ini memuat data $pelanggan
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .main-header {
            background-color: #2c3e50;
            padding: 10px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            display: flex;
            align-items: center;
        }

        .nav-list {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 0;
        }

        .nav-item a {
            padding: 12px 20px;
            text-decoration: none;
            color: #ecf0f1;
            font-weight: 500;
            font-size: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-item a.active {
            background-color: #3498db;
            border-radius: 8px 0 0 8px;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
        }

        .nav-item:last-child a.active {
            border-radius: 8px;
        }

        .nav-item a:not(.active):hover {
            background-color: #34495e;
        }

        .search-container {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .search-input {
            padding: 8px 12px;
            border: 1px solid #34495e;
            border-radius: 8px;
            background-color: #3a5369;
            color: white;
            font-size: 0.9rem;
            width: 200px;
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .search-input::placeholder {
            color: #bdc3c7;
        }

        .search-input:focus {
            background-color: #4a647d;
            border-color: #3498db;
            outline: none;
        }

        .search-button {
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #2980b9;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
            margin: 5px 60px;
            width: 80%;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        table thead tr {
            background-color: #2c3e50;
            color: white;
            text-align: left;
        }

        table th,
        table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #ddd;
        }

        .aksi-buttons a {
            color: white;
            text-decoration: none;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        .aksi-buttons .update-btn {
            background-color: #e68a00;
        }

        .aksi-buttons .update-btn:hover {
            background-color: #c06d00;
        }

        .aksi-buttons .hapus-btn {
            background-color: #d32f2f;
        }

        .aksi-buttons .hapus-btn:hover {
            background-color: #a30000;
        }
    </style>
</head>

<body>

    <header class="main-header">
        <nav class="navbar">
            <ul class="nav-list">
                <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="v_tambah_data_pelanggan.php">Tambah Data User</a></li>
                <li class="nav-item"><a class="nav-link active" href="v_tampil_data_pelanggan.php">Daftar Pelanggan</a></li>
                <li class="nav-item"><a class="nav-link" href="../asset/aksi_logout.php">Logout</a></li>
            </ul>
        </nav>
        <div class="search-container">
            <input type="search" placeholder="Cari..." name="search" class="search-input">
            <button class="search-button">Cari</button>
        </div>
    </header>

    <div class="container">
        <h2>Daftar Pembeli</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($pelanggan as $data): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->nama ?></td>
                        <td><?= $data->email ?></td>
                        <td><?= $data->alamat ?></td>
                        <td><?= $data->jenis_kelamin ?></td>
                        <td>
                            <div class="aksi-buttons">
                                <!-- Tombol Update diarahkan ke form edit -->
                                <a href="v_ubah_data_pelanggan.php?id_user=<?= $data->id_user ?>" class="update-btn">Update</a>

                                <!-- Tombol Hapus -->
                                <a href="../controller/c_pelanggan.php?aksi=hapus&id_user=<?= $data->id_user ?>" 
                                   onclick="return confirm('Anda yakin ingin menghapus data ini?')" 
                                   class="hapus-btn">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
