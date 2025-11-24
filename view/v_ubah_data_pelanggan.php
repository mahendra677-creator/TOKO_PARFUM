<?php
include_once '../model/m_pelanggan.php';

$pelanggan = new m_pelanggan();

// Pastikan ada parameter id_user di URL
if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Ambil data pelanggan berdasarkan ID
    $data = $pelanggan->get_by_id($id_user);
    $pelanggans = mysqli_fetch_assoc($data);
} else {
    echo "<script>alert('ID pengguna tidak ditemukan!'); window.location='v_tampil_data_pelanggan.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rubah Data User</title>
  <style>
    body {
      background-color: #f4f4f4;
      font-family: Arial, sans-serif;
      margin: 0;
      padding-top: 0px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .navbar {
      background-color: #2c3e50;
      overflow: hidden;
      width: 100%;
      position: fixed;
      top: 0;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .navbar a {
      float: left;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
      font-size: 17px;
    }

    .navbar a:hover {
      background-color: #ddd;
      color: black;
    }

    .navbar a.active {
      background-color: #04AA6D;
      color: white;
    }
    
    .form-container {
      width: 500px;
      padding: 30px;
      border: 1px solid #ccc;
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      margin-top: 120px;
    }
    
    h2 {
      text-align: center;
      color: #04AA6D;
      font-family: Comic Sans MS;
      margin-top: 100px;
      margin-bottom: 0;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    h3 {
      text-align: center;
      color: #333;
      font-family: Comic Sans MS;
      margin-top: 5px;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    label {
      color: #333;
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    
    input[type="text"],
    input[type="password"],
    input[type="email"],
    select,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      box-sizing: border-box;
      background-color: #f8f8f8;
      color: #333;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    
    input:focus, select:focus, textarea:focus {
      border-color: #04AA6D; 
      outline: none;
    }

    .button-submit {
      background-color: #04AA6D; 
      color: white;
      border: none;
      width: 100%;
      padding: 15px;
      margin-top: 20px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      border-radius: 8px;
      transition: background-color 0.3s, transform 0.3s;
    }

    .button-submit:hover {
      background-color: #039a60; 
      transform: translateY(-2px);
    }
  </style>
</head>
<body>
  <div class="navbar">
      <a href="v_tambah_data_pelanggan.php">Tambah Data</a>
      <a href="v_tampil_data_pelanggan.php">Daftar User</a>
  </div>

  <h2>Rubah Data User</h2>
  <h3>Silakan perbarui informasi pengguna di bawah ini</h3>
  
  <div class="form-container">
    <form action="../controller/c_pelanggan.php?aksi=edit" method="post">
      
      <input type="hidden" name="id_user" value="<?= $pelanggans['id_user']; ?>">

      <div class="form-group">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" value="<?= $pelanggans['nama']; ?>" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?= $pelanggans['email']; ?>" required>
      </div>

      <div class="form-group">
        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat" rows="3" required><?= $pelanggans['alamat']; ?></textarea>
      </div>

      <div class="form-group">
        <label for="password">Password (opsional)</label>
        <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin diubah">
      </div>

      <button type="submit" class="button-submit">Simpan Perubahan</button>
    </form>
  </div>
</body>
</html>
