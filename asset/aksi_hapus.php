
<?php
include_once '../model/m_pelanggan.php';

$pelanggan = new m_pelanggan();

try {
    // Mengecek apakah ada aksi yang dilakukan oleh view
    if (!empty($_GET['aksi'])) {

        // ==== Aksi Tambah Data ====
        if ($_GET['aksi'] == 'tambah') {
            $id = $_POST['id_user'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $alamat = $_POST['alamat'];
            $jk = $_POST['jenis_kelamin'];
            $role = $_POST['role'];

            // Memanggil fungsi tambah_data
            $result = $pelanggan->tambah_data($id, $nama, $email, $password, $alamat, $jk, $role);

            if ($result) {
                echo "<script>
                        alert('Data Berhasil Ditambahkan');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data gagal ditambahkan');
                        window.location='../view/v_tambah_data_pelanggan.php';
                      </script>";
            }
        }

        // ==== Aksi Hapus Data ====
        elseif ($_GET['aksi'] == 'hapus') {
            $id = $_GET['id_user'];

            $result = $user->hapus_data($id);

            if ($result) {
                echo "<script>
                        alert('Data berhasil dihapus');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data gagal dihapus');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            }
        }

        // ==== Aksi Update Data ====
        elseif ($_GET['aksi'] == 'update') {
            $id = $_POST['id_user'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $alamat = $_POST['alamat'];
            $jk = $_POST['jenis_kelamin'];
            $role = $_POST['role'];

            // Jika password baru diisi → hash ulang, kalau kosong → pakai yang lama
            if (!empty($_POST['password'])) {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            } else {
                $password = $_POST['password_lama'];
            }

            // Memanggil fungsi update_data
            $result = $user->update_data($id, $nama, $email, $password, $alamat, $jk, $role);

            if ($result) {
                echo "<script>
                        alert('Data berhasil diperbarui');
                        window.location='../view/v_tampil_data_pelanggan.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data gagal diperbarui');
                        window.location='../view/v_edit_data_pelanggan.php?id_user=$id';
                      </script>";
            }
        }

    } else {
        // Jika tidak ada aksi, tampilkan data pelanggan
        $pelanggan = $pelanggan->tampil_data();
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
?>
