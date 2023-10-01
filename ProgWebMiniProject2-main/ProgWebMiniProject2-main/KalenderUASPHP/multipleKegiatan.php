<!-- manfaatkan url variable untuk dapat kegiatan, search: how to get url variabl;e -->
<?php 
    session_start();

    if (!isset($_SESSION["loged_in"])) {
        header("Location: loginForm.php");
    }

    $koneksi = mysqli_connect("localhost", "root", "", "mini_project2") or die("koneksi gagal");
    $link = $_SERVER['REQUEST_URI'];
    $id = $_GET['id'];
    $tglMulai = "SELECT tglKegiatan FROM detailKegiatan WHERE id =".$id;
    $mulai= mysqli_query($koneksi, $tglMulai);
    $arrayMulai= mysqli_fetch_assoc($mulai);
    
    $sql = "SELECT * FROM detailKegiatan WHERE tglKegiatan='".$arrayMulai['tglKegiatan']."'";
    $result= mysqli_query($koneksi, $sql);


    
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kegiatan</title>
    <link rel="stylesheet" href="styleDetail.css">
</head>
<body>
    <header>
        <span> 
            <?php echo date('F j, Y',strtotime($arrayMulai['tglKegiatan'])); ?></h1>
        </span>
    </header>
    <br>
        <button id="tombol1" class="tombol" onclick="location.href='index.php?nav=<?php echo $_SESSION['nav']?>'" > Kembali</button>
    <br>
    <?php 
    if (mysqli_num_rows($result) > 0) {
        while ($rows = mysqli_fetch_assoc($result)) {
            ?>
            <div class="bodyEvent" style="margin-bottom: 10px;">
                <table class="showTable">
                    <thead>
                        
                            <th colspan="3">
                                <div id="theader">
                                    <?php echo $rows['namaKegiatan']; ?>
                                </div>
                                <button id="deleteButton" class="tombolDalam" onclick="deleteEvent('<?php echo $rows['user_id']; ?>',
                                    '<?php echo $rows['namaKegiatan']; ?>',
                                    '<?php echo $rows['lvlPenting']; ?>',
                                    '<?php echo $rows['tglMulai']; ?>',
                                    '<?php echo $rows['tglSelesai']; ?>',
                                    '<?php echo $rows['lokasiKegiatan']; ?>',
                                    '<?php echo $rows['gambar']; ?>'
                                    )" >Delete</button>
                                <button id="updateKegiatan" onclick="showFormUpdate(
                                    '<?php echo $rows['user_id']; ?>',
                                    '<?php echo $rows['namaKegiatan']; ?>',
                                    '<?php echo $rows['lvlPenting']; ?>',
                                    '<?php echo $rows['tglMulai']; ?>',
                                    '<?php echo $rows['tglSelesai']; ?>',
                                    '<?php echo $rows['lokasiKegiatan']; ?>',
                                    '<?php echo $rows['gambar']; ?>'
                                    )" class="tombolDalam">Update</button>

                                <button id="tombol2" onclick="lihatDetail(<?php echo $rows['id'] ?>)" class="tombolDalam">Lihat</button>
                                
                                
                            </th>
                    </thead>
                    <tbody>
                        <tr>
                        <td rowspan="5"><img class="img-size" src="<?php echo $rows['gambar']?>"></td>                            
                        <td>Level Penting</td>
                            <td><?php echo $rows['lvlPenting']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Mulai</td>
                            <td><?php echo $rows['tglMulai']; ?></td>
                        </tr>
                        <tr>
                            <td>Tanggal Selesai</td>
                            <td><?php echo $rows['tglSelesai']; ?></td>
                        </tr>
                        <tr>
                            <td>Durasi</td>
                            <td><?php echo $rows['durasiKegiatan']; ?></td>
                        </tr>
                        <tr>
                            <td>Lokasi</td>
                            <td><?php echo $rows['lokasiKegiatan']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
    <?php
        }
    } else {
        echo "No rows found.";
    } ?>
  
        <div id="formUpdateKegiatan">
            <h2>Update Kegiatan</h2>
            <!-- add css for form and button -->
            <form action="index.php?nav=<?php echo $_SESSION['nav']?>" method="post" enctype="multipart/form-data" id="formUpdate">
                <table>
                    <input type="hidden" name="oldUser" id= "oldUser">
                    <input type="hidden" name="oldNama" id="oldNama">
                    <input type="hidden" name="oldMulai" id="oldMulai">
                    <input type="hidden" name="oldSelesai" id="oldSelesai">
                    <input type="hidden" name="oldLokasi" id="oldLokasi">
                    <input type="hidden" name="oldGambar" id="oldGambar">
                    <tr>
                        <td>Judul Kegiatan:</td>
                        <td><input type="text" name="namaKegiatan" id="namaKegiatan" placeholder="Masukkan Judul Kegiatan...">
                        <span class='alert' id="alertNama"></span>
                    </td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai:</td>
                        <td>
                            <input type="datetime-local" name="tglMulai" id="tglMulai"?>
                            <span class='alert' id="alertMulai"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Tanggal Selesai:</td>
                        <td><input type="datetime-local" name="tglSelesai" id="tglSelesai">
                        <span class='alert' id="alertSelesai"></span>
                    </td>
                    </tr>
                    <tr>
                        <td>Tingkat:</td>
                        <td>
                            <select name="lvlPenting" id="lvlPenting">
                                <option value="kosong" hidden selected>Silakan Pilih Tingkat Kepentingan</option>
                                <option value="biasa">biasa</option>
                                <option value="sedang">sedang</option>
                                <option value="sangat penting">sangat penting</option>
                            </select> <span class='alert' id="alertLevel"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>lokasi:</td>
                        <td><input type="text" name="lokasiKegiatan" id="lokasiKegiatan" placeholder="Masukkan Lokasi">
                        <span class='alert' id="alertLokasi"></span>
                    </td>
                    </tr>
                    <tr>
                        <td>Gambar:</td>
                        <td><input type="file" name="gambar" id="gambar"><br><span id="path"></span></td> 
                    </tr>
                </table>
                <p style="text-align:center;"><input type="submit" name="submitUpdate" id="saveButton" value="Simpan"></p>
                
            </form>
            <p style= "text-align:center;">
                <button id="batalButton">Batal</button>
            </p>
            
        </div>
        <div id="formBackground"></div>
        <div id="confirmDelete">
            Are you sure want to delete? 
            <form action= "index.php?nav=<?php echo $_SESSION['nav']?>" method="post">
                <input type="hidden" name="oldUser2" id= "oldUser2">
                <input type="hidden" name="oldNama2" id="oldNama2">
                <input type="hidden" name="oldMulai2" id="oldMulai2">
                <input type="hidden" name="oldSelesai2" id="oldSelesai2">
                <input type="hidden" name="oldLokasi2" id="oldLokasi2">
                <input type="hidden" name="oldGambar2" id="oldGambar2">
                <input type="submit" name="deleteKegiatan" id="deleteKegiatan" value="Delete">
            </form>
            <button id="batalButton2" onclick="reset()">Batal</button>
            
        </div>
</body>
</html>
<script src="scriptDetail.js"></script>