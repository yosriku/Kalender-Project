<!-- manfaatkan url variable untuk dapat kegiatan, search: how to get url variabl;e -->
<?php 
    session_start();

    if (!isset($_SESSION["loged_in"])) {
        header("Location: loginForm.php");
    }

    $koneksi = mysqli_connect("localhost", "root", "", "mini_project2") or die("koneksi gagal");
    $link = $_SERVER['REQUEST_URI'];
    $id = $_GET['id'];

    $sql = "SELECT * FROM detailKegiatan WHERE id=".$id;
    $result= mysqli_query($koneksi, $sql);
    $row = mysqli_fetch_assoc($result);

    $tanggalQuery = "SELECT tglKegiatan from detailKegiatan where id=".$id;
    $resultTgl = mysqli_query($koneksi, $tanggalQuery);
    $hasilTgl = mysqli_fetch_assoc($resultTgl);
    
    // handle request delete:
    if(isset($_POST['deleteButton'])){
        $start = mysqli_query($koneksi, "SELECT tglMulai FROM detailKegiatan where id = $_GET[id]");
        $end = mysqli_query($koneksi, "SELECT tglSelesai FROM detailKegiatan where id = $_GET[id]");
        $nama = mysqli_query($koneksi, "SELECT namaKegiatan FROM detailKegiatan where id = $_GET[id]");
        $user = mysqli_query($koneksi, "SELECT user_id FROM detailKegiatan where id = $_GET[id]");

        $rStart = mysqli_fetch_assoc($start);
        $rEnd = mysqli_fetch_assoc($end);
        $rNama = mysqli_fetch_assoc($nama);
        $rUser = mysqli_fetch_assoc($user);
        
        $sqlDelete = "DELETE FROM detailKegiatan WHERE tglMulai = '$rStart[tglMulai]' AND tglSelesai = '$rEnd[tglSelesai]' AND namaKegiatan = '$rNama[namaKegiatan]' AND user_id = $rUser[user_id]";
        mysqli_query($koneksi, $sqlDelete);
        header("location:index.php?nav=".$_SESSION['nav']);
    }
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
            <?php echo date('F j, Y',strtotime($hasilTgl['tglKegiatan'])); ?></h1>
        </span>
    </header>
    <br>
            <button id="tombol1" class="tombol" onclick="location.href='index.php?nav=<?php echo $_SESSION['nav']?>'" > Kembali</button>
            <button id="tombol2" class="tombol" onclick="lihatSemua(<?php echo $id; ?>)">Kegiatan Hari Ini</button>
    <br>
    <dialog data-modal>
        <?php
            //find all matching events:
            $start = mysqli_query($koneksi, "SELECT tglMulai FROM detailKegiatan where id = $_GET[id]");
            $end = mysqli_query($koneksi, "SELECT tglSelesai FROM detailKegiatan where id = $_GET[id]");
            $nama = mysqli_query($koneksi, "SELECT namaKegiatan FROM detailKegiatan where id = $_GET[id]");
            $user = mysqli_query($koneksi, "SELECT user_id FROM detailKegiatan where id = $_GET[id]");

            $rStart = mysqli_fetch_assoc($start);
            $rEnd = mysqli_fetch_assoc($end);
            $rNama = mysqli_fetch_assoc($nama);
            $rUser = mysqli_fetch_assoc($user);

            $sqlSelect = "SELECT * FROM detailKegiatan where tglMulai = '$rStart[tglMulai]' AND tglSelesai = '$rEnd[tglSelesai]' AND namaKegiatan = '$rNama[namaKegiatan]' AND user_id = $rUser[user_id]";
            $temp = "";

            $rows = mysqli_query($koneksi, $sqlSelect);
            if(mysqli_num_rows($rows) > 0){
                while($baris = mysqli_fetch_assoc($rows)){
                    $temp .= $baris['namaKegiatan'] . " - " . $baris['tglKegiatan'] . "<br>"; 
                }
            }
        ?>
        <div style="background-color: #E74646">Anda akan menghapus: </div>
        <div id="dialogBody">
            <span id="kegiatans"> <?php echo $temp?> </span>
            <button data-close-modal>Batal</button>
            <form action="detailKegiatan.php?id=<?php echo $id?>" method="post">
                <input type="submit" value="Ya" name="deleteButton">
            </form>
        </div>
    </dialog>
    <?php //foreach($arrKegiatan["1"] as $row) { ?>
        <div class="bodyEvent" style="margin-bottom: 10px;">
            <table>
                <thead>
                    <th colspan="3">
                        <div id="theader">
                            <?php echo $row['namaKegiatan']; ?>
                        </div>
                        <button id="deleteButton" class="tombolDalam" onclick="bukaDialog(<?php echo $row['id']?>, event)">Delete</button>
                        <button id="updateButton" class="tombolDalam">Update</button>
                    </th>
                </thead>
                <tbody>
                    <tr>
                        <td rowspan="5"><img class="img-size" src="<?php echo $row['gambar']?>"></td>
                        <td>lvlPenting</td>
                        <td><?php echo $row['lvlPenting']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Mulai</td>
                        <td><?php echo $row['tglMulai']; ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Selesai</td>
                        <td><?php echo $row['tglSelesai']; ?></td>
                    </tr>
                    <tr>
                        <td>Durasi</td>
                        <td><?php echo $row['durasiKegiatan']; ?></td>
                    </tr>
                    <tr>
                        <td>Lokasi</td>
                        <td><?php echo $row['lokasiKegiatan']; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php //} ?>
</body>
</html>
<script src="scriptDetail.js"></script>
<script>
    var buttonTutup = document.querySelectorAll("[data-close-modal]")[0];
    var dialogDelete = document.querySelectorAll("[data-modal]")[0];
    var kegiatans = document.getElementById("kegiatans");

    function bukaDialog(id){
        dialogDelete.showModal();
    }

    buttonTutup.addEventListener('click', () => {
        dialogDelete.close();
    })
</script>