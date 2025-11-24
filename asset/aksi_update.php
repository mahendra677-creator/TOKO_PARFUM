
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
         

        // ==== Aksi Hapus Data ====
        if ($_GET['aksi'] == 'hapus') {

             if ($_GET['aksi'] == 'edit') {
                $id = $_GET['id'];
                $users = $user->tampil_data_by_id($id);
                require_once'../view/v_ubah_data_pelanggan.php';

             } else {

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
             }

            $id = $_GET['id_user'];

            $result = $pelanggan->hapus_data($id);

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

    } else {
        // Jika tidak ada aksi, tampilkan data pelanggan
        $pelanggan = $pelanggan->tampil_data();
    }

} catch (Exception $e) {
    echo $e->getMessage();
}
?>
