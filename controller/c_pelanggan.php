<?php
include_once '../model/m_pelanggan.php';

$pelanggan = new m_pelanggan();

try {
    // Mengecek apakah ada aksi yang dilakukan oleh view
    if (!empty($_GET['aksi'])) {

        // ==== Aksi Tambah Data ====
        if ($_GET['aksi'] == 'tambah') {
            $id = null; // AUTO_INCREMENT dari database

            // Mengambil data dari form
            $nama     = $_POST['nama'];
            $email    = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $alamat   = $_POST['alamat'];
            $jk       = $_POST['jenis_kelamin'];
            $role     = $_POST['role'];

            // Memanggil fungsi tambah_data
            $result = $pelanggan->tambah_data($id, $nama, $email, $password, $alamat, $jk, $role);

            if ($result) {
                echo "<script>
                        alert('Data Berhasil Ditambahkan');
                        window.location='../view/v_tambah_data_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data Gagal Ditambahkan');
                        window.location='../view/v_tambah_data_pelanggan.php';
                      </script>";
            }
        }

        // ==== Aksi Hapus Data ====
        elseif ($_GET['aksi'] == 'hapus') {
            $id = $_GET['id_user'];

            $result = $pelanggan->hapus_data($id);

            if ($result) {
                echo "<script>
                        alert('Data Berhasil Dihapus');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data Gagal Dihapus');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            }
        }



        if ($_GET['aksi'] == 'registrasi') {
            $id = null; // AUTO_INCREMENT dari database

            // Mengambil data dari form
            $nama     = $_POST['nama'];
            $email    = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $alamat   = $_POST['alamat'];
            $jk       = $_POST['jenis_kelamin'];
            $role     = $_POST['role'];

            // Memanggil fungsi tambah_data
            $result = $pelanggan->registrasi_data($id, $nama, $email, $password, $alamat, $jk, $role);

            if ($result) {
                echo "<script>
                        alert('Data Berhasil Ditambahkan');
                        window.location='../view/v_login.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data Gagal Ditambahkan');
                        window.location='../view/v_registrasi.php';
                      </script>";
            }
        }


        //=====AKSI UPDATE=====
        elseif ($_GET['aksi'] == 'edit') {
    $id       = $_POST['id_user'];
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $alamat   = !empty($_POST['alamat']) ? $_POST['alamat'] : null;
    $jk       = !empty($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : null;
    $role     = !empty($_POST['role']) ? $_POST['role'] : null;

    // Ambil data lama dari database
    $koneksi = new koneksi();
    $data_lama = mysqli_fetch_assoc(mysqli_query($koneksi->koneksi, "SELECT * FROM user WHERE id_user='$id'"));

    // Jika ada field kosong, pakai data lama
    $alamat = $alamat ?? $data_lama['alamat'];
    $jk     = $jk ?? $data_lama['jenis_kelamin'];
    $role   = $role ?? $data_lama['role'];

    if (empty($password)) {
        $query = "UPDATE user SET 
                    nama = '$nama', 
                    email = '$email',
                    alamat = '$alamat',
                    jenis_kelamin = '$jk',
                    role = '$role'
                  WHERE id_user = '$id'";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE user SET 
                    nama = '$nama', 
                    email = '$email',
                    password = '$hashed',
                    alamat = '$alamat',
                    jenis_kelamin = '$jk',
                    role = '$role'
                  WHERE id_user = '$id'";
    }

    $result = mysqli_query($koneksi->koneksi, $query);

    if ($result) {
        echo "<script>
                alert('Data Berhasil Diubah');
                window.location='../view/v_tampil_data_pelanggan.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Gagal Diubah');
                window.location='../view/v_tampil_data_pelanggan.php';
              </script>";
    }
}

    } else {
        // Jika tidak ada aksi, tampilkan semua data pelanggan
        $pelanggan = $pelanggan->tampil_data();
    }

} catch (Exception $e) {
    echo $e->getMessage();
}

        

?>
