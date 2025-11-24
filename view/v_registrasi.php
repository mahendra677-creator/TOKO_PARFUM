<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Data Siswa</title>
  <style>
    body {
      background-color: #f4f4f4;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    .navbar {
      background-color:  #2c3e50;
      overflow: hidden;
      width: 100%;
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
    
    .main-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    h3 {
      text-align: center;
      color: black;
      font-family: Comic Sans MS;
    }
    
    .form-container {
      width: 800px;
      padding: 30px; 
      border: 2px solid #ccc; 
      border-radius: 10px;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
      margin-top: 20px;
    }
    
    .form-group {
      margin-bottom: 20px; 
    }
    
    label {
      color: #555;
      display: block;
      margin-bottom: 8px; 
      font-weight: bold;
    }
    
    input[type="text"],
    input[type="number"],
    input[type="password"],
    input[type="date"],
    input[type="email"],
    select {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      height: auto;
      box-sizing: border-box;
      background-color: #f8f8f8;
      color: #333;
      font-size: 16px;
    }

    input:focus, select:focus {
        border-color: #007bff; /* Efek fokus yang lebih profesional */
        outline: none;
    }

    .button-submit {
      background-color: #0056b3; /* Warna tombol yang lebih umum (biru) */
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
      background-color: lightblue; /* Warna hover yang lebih gelap */
      transform: translateY(-2px); /* Efek melayang */
    }
    .form-group .radio-group{
      display: flex;
      gap: 5px;
    }
    .form-group .radio-group input{
      margin-right: 5px;
    }
      
  </style>
</head>
<body>
   <nav class="navbar">
        <a href="v_tampil_data_pelanggan.php">Tambah Data User</a>
        <a href="v_tambah_data_pelanggan.php">Daftar User</a>
    </nav>
    
    <div class="main-container">
        <h3>Tambah Data User</h3>
        <div class="form-container">
            <form action="../controller/c_pelanggan.php?aksi=registrasi" method="post">
              
                <div class="form-group">
                    <label for="username">Username</label> 
                    <input type="text" id="username" placeholder="masukkan username" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="masukkan email" name="email" required>
                </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" placeholder="masukkan password" name="password" required>
                </div>
                
                
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <input type="text" id="alamat" placeholder="masukkan alamat user" name="alamat" required>
                </div>
                
                
                <div class="form-group">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">Pilih jenis kelamin</option>
                        <option value="laki-laki">Laki-laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" id="role" placeholder="masukkan role" name="role" value="user" readonly="">
                </div>
                <button type="submit" class="button-submit">Tambah</button>
            </form>
        </div>
    </div>
</body>
</html>