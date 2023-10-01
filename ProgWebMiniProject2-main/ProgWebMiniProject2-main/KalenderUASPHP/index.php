<?php
    session_start();
    $koneksi = mysqli_connect("localhost", "root", "", "mini_project2") or die("koneksi gagal");    
    
    $useriD = $_SESSION['id'];
    //jika belum login; lempar user ke laman login
    if (!isset($_SESSION["loged_in"])) {
        header("Location: loginForm.php");
    } else{
        //jika sudah, cek value nav untuk menghitung bulan secara dinamis:
        if(!isset($_GET['nav'])){
            $_SESSION['nav'] = 0;
            $_GET['nav'] = 0;
        } else{
            if($_GET['nav'] == "next"){
                $_SESSION['nav']++;
            } else if($_GET['nav'] == "prev"){
                $_SESSION['nav']--;
            } else{
                $_SESSION['nav']=$_GET['nav'];
            }
        }
    }

    //jika ingin logout
    if (isset($_POST['logout'])) {
        session_destroy();   
    }

    function loadKalender(){
        //get current date
        //hitung hari selama 1 bulan
        //hitung jumlah petak kalender kosong
        
        //DATE time zone is in CEST not WIB (maybe need correction)
        $koneksi = mysqli_connect("localhost", "root", "", "mini_project2") or die("koneksi gagal");
        $hari = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        $currentDate = date("d");
        $currentMonth = date("m");
        $currentYear = date('Y');
        $today = mktime(0, 0, 0, $currentMonth + $_SESSION['nav'], $currentDate, $currentYear); // note: this is an array, test pake print_r()!

        $jumlahHari = getdate(mktime(0, 0, 0, ($currentMonth + $_SESSION['nav'] + 1), 0, $currentYear))['mday'];
        $hariPertamaBulan = getdate(mktime(0, 0, 0, ($currentMonth + $_SESSION['nav']), 1, $currentYear))['weekday'];
        $jumlahPetakKosong = array_search($hariPertamaBulan, $hari);

        //create kalender using loop:
        for($i = 1; $i <= $jumlahHari + $jumlahPetakKosong; $i++){
            if($i>$jumlahPetakKosong){
                //jika bukan petak kosong, lakukan pengecekan apakah ada event di hari itu:
                $counterTanggal = $i - $jumlahPetakKosong;
                $counterEvent = date("Y-m-d",mktime(0,0,0,$currentMonth + $_SESSION['nav'],$counterTanggal,$currentYear));
                
                $query = "SELECT * FROM detailKegiatan WHERE tglKegiatan = '$counterEvent' and user_id='".$_SESSION['id']."' ORDER BY id";
                $rows = mysqli_query($koneksi, $query);
                if(mysqli_num_rows($rows) > 0){
                    //if event found dan tgl is now:
                    if(($_SESSION['nav']==0) && ($counterTanggal == $currentDate)){
                        echo "<div class = 'day' id = 'currentDay' onclick='showFormTambah()'>";
                        echo $counterTanggal;
                        while($row = mysqli_fetch_assoc($rows)){
                            $id = $row['id'];
                            $namaKegiatan = $row['namaKegiatan'];
                            $tglmulai = $row['tglMulai'];
                            $tglselesai = $row['tglSelesai'];
                            $lvlPenting = ($row['lvlPenting'] == "sangat penting")? "penting":$row['lvlPenting'];
                            
                            $durasi = $row['durasiKegiatan'];
                            $lokasi = $row['lokasiKegiatan'];
                            $gambar = $row['gambar'];

                            echo "<div class= 'event $lvlPenting' onclick='showPreview(event, $id, \"$namaKegiatan\", \"$tglmulai\", \"$tglselesai\", \"$lvlPenting\", \"$durasi\", \"$lokasi\", \"$gambar\")'>
                                <a>$namaKegiatan</a>";
                            echo "</div>";
                        }
                        echo "</div>";
                    } else{
                        //event found but tgl is not now
                        echo "<div class = 'day' onclick='showFormTambah()'>";
                        echo $counterTanggal;
                        while($row = mysqli_fetch_assoc($rows)){
                            $id = $row['id'];
                            $namaKegiatan = $row['namaKegiatan'];
                            $tglmulai = $row['tglMulai'];
                            $tglselesai = $row['tglSelesai'];
                            $lvlPenting = ($row['lvlPenting'] == "sangat penting")? "penting":$row['lvlPenting'];
                            $durasi = $row['durasiKegiatan'];
                            $lokasi = $row['lokasiKegiatan'];
                            $gambar = $row['gambar'];
                            
                            echo "<div class= 'event $lvlPenting' onclick='showPreview(event, $id, \"$namaKegiatan\", \"$tglmulai\", \"$tglselesai\", \"$lvlPenting\", \"$durasi\", \"$lokasi\", \"$gambar\")'>
                                <a>$namaKegiatan</a>";
                            echo "</div>";

                        }
                        echo "</div>";
                    }
                } else{
                    //no event found:
                    if(($_SESSION['nav']==0) && ($counterTanggal == $currentDate)){
                        echo"<div class = 'day' id = 'currentDay' onclick='showFormTambah()'>". ($counterTanggal) ."</div>";    
                    } else{
                        echo"<div class = 'day' onclick='showFormTambah()'>". ($counterTanggal) ."</div>";
                    }
                }
            } else{
                echo"<div class = 'day empty'></div>";
            }
        }
        mysqli_close($koneksi);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Alpha 2</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <header>

    </header>
    <main>
        <div id="container">
            <div id="header">
            <form action="index.php" method="POST">
        <input class="action-button" type="submit" value="Logout" name="logout">
    </form>
                <div id="currentMonth">
                    <?php
                        $headerTanggal = getdate(mktime(0, 0, 0, date("m") + $_SESSION['nav'], date("d"), date("Y")));
                        echo $headerTanggal['month'] . " " . $headerTanggal['year'];
                    ?>
                </div>
                <div>
                    <button id="backButton" onclick="location.href='index.php?nav=prev'">Back</button>
                    <button id="nextButton" onclick="location.href='index.php?nav=next'">Next</button>
                </div>
            </div>
            <div id="weekdays">
                <div>Minggu</div>
                <div>Senin</div>
                <div>Selasa</div>
                <div>Rabu</div>
                <div>Kamis</div>
                <div>Jumat</div>
                <div>Sabtu</div>
            </div>
            <div id="kalender">
                <!-- dinamis -->
                <?php loadKalender()?>
            </div>
        </div>
    </main>

    <div id="formTambahKegiatan">
        <h2>Tambah Kegiatan</h2>
        <!-- add css for form and button -->
        <form action="index.php?nav=<?php echo $_SESSION['nav']?>" method="post" enctype="multipart/form-data" id="formTambahKegiatan2">
            <table>
                <!-- add pengecekan:
                    1. semua input tidak boleh kosong kecuali gambar
                    2. tanggal selesai >= tanggal mulai

                    masalah(?): akan selalu refresh ke sini / may or may not need to be fix... 
                -->
                <tr>
                    <td>Judul Kegiatan:</td>
                    <td><input type="text" name="namaKegiatan" id="namaKegiatan" placeholder="Masukkan Judul Kegiatan..."><span class='alert' id="alertNama"></span></td>
                </tr>
                <tr>
                    <td>Tanggal Mulai:</td>
                    <td><input type="datetime-local" name="tglMulai" id="tglMulai"?><span class='alert' id="alertMulai"></span></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai:</td>
                    <td><input type="datetime-local" name="tglSelesai" id="tglSelesai"><span class='alert' id="alertSelesai"></span></td>
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
                    <td><input type="text" name="lokasiKegiatan" id="lokasiKegiatan" placeholder="Masukkan Lokasi"><span class='alert' id="alertLokasi"></span></td>
                </tr>
                <tr>
                    <td>Gambar:</td>
                    <td><input type="file" name="gambar" id="gambar"></td> 
                </tr>
            </table>
            <input type="submit" name="submit" id="saveButton" value="Simpan">
        </form>
        <button id="cancelButton" onclick="reset()">Batal</button>
         <!-- not the real save button// -->
       
    </div>

    <div id="formPreview">
        <h2 id="preNamaKegiatan"></h2> <br>
        <img class="thumbprint" id="preGambar" alt="Tidak ditemukan">
        <table>
            <tr>
                <td>Tanggal Mulai</td>
                <td id="preTglMulai"></td>
            </tr>
            <tr>
                <td>Tanggal Selesai</td>
                <td id="preTglSelesai"></td>
            </tr>
            <tr>
                <td>Tingkat Kepentingan</td>
                <td id="preLvlPenting"></td>
            </tr>
            <tr>
                <td>Durasi Kegiatan</td>
                <td id="preDurasi"></td>
            </tr>
            <tr>
                <td>Lokasi Kegiatan</td>
                <td id="preLokasi"></td>
            </tr>
        </table>
        <button id="seeButton">Lihat</button>
        <button id="closeButton">Batal</button> <br>
        <button id="multipleKegiatan">Lihat Semua Kegiatan Hari ini</button>
    </div>

    <div id="formBackground"></div>
    </main>
    <footer>
        <!-- <?php
            //echo date('d m Y T');
        ?> -->
    </footer>
    <script src="script.js"></script>
</body>
</html>
<?php 
    if (isset($_POST['submit'])) {
        $namaKegiatan = $_POST['namaKegiatan'];
        $tglMulai = $_POST['tglMulai'];
        $tglSelesai = $_POST['tglSelesai'];
        $lvlPenting = $_POST['lvlPenting'];
        $lokasiKegiatan = $_POST['lokasiKegiatan'];
        
        //handel files
        $lokal = "img/".$_FILES["gambar"]["name"];
        $tipefile = strtolower(pathinfo($lokal, PATHINFO_EXTENSION));
        if ($tipefile != "jpg" && $tipefile != "jpeg" && $tipefile != "png"){ 
            echo ("Tipe file bukan gambar!");   
        }else{
            move_uploaded_file($_FILES["gambar"]["tmp_name"],$lokal);
        }
        
        //handle durasi:
        $DT1 = new DateTime($tglMulai);
        $DT2 = new DateTime($tglSelesai);
        $interval = $DT1->diff($DT2); //mencari selisih
        $durasiKegiatan = $interval->format('%a days %h hours %i minutes %s seconds');
        
        //$i = 0;
        $DT1Day = $DT1->format('d');
        $inputSukses = true;
        do{
            $tglKegiatan = date("Y-m-d",mktime(0,0,0,$DT1->format('m'),$DT1Day,$DT1->format('Y')));
            //echo $tglKegiatan . "<br>"; 
            //$i++;
            $DT1Day++;
            
            $sql = "INSERT INTO detailKegiatan(user_id, namaKegiatan, tglMulai, tglKegiatan, tglSelesai, lvlPenting, durasiKegiatan, lokasiKegiatan, gambar) VALUES ($useriD,'$namaKegiatan', '$tglMulai', '$tglKegiatan', '$tglSelesai', '$lvlPenting', '$durasiKegiatan', '$lokasiKegiatan','$lokal')";
            if(!$result = mysqli_query($koneksi, $sql)){
                $inputSukses = false;
                break;
            }
            //$result = mysqli_query($koneksi, $sql);
        }while($tglKegiatan != date("Y-m-d",mktime(0,0,0,$DT2->format('m'),$DT2->format('d'),$DT2->format('Y'))));
        
        if($inputSukses){
            //header("refresh:3");
            echo"Berhasil menginputkan kegiatan!";
            echo "<meta http-equiv='refresh' content='0'>";
        } else{
            echo"Input kegiatan gagal!";
        }
        mysqli_close($koneksi);
    }
    if (isset($_POST["submitUpdate"])){
        $userId = $_POST["oldUser"];
        $oldMulai = $_POST["oldMulai"];
        $oldNama = $_POST["oldNama"];
        $oldSelesai = $_POST["oldSelesai"];
        $oldLokasi = $_POST["oldLokasi"];
        $sqlDelete = "DELETE FROM detailKegiatan WHERE user_id='$userId' AND namaKegiatan='$oldNama' AND tglMulai='$oldMulai' AND tglSelesai='$oldSelesai' AND lokasiKegiatan='$oldLokasi'";
        $resultDel = mysqli_query($koneksi, $sqlDelete);
        if($resultDel){echo "berhasil hapus";}

        $namaKegiatan = $_POST['namaKegiatan'];
        $tglMulai = $_POST['tglMulai'];
        $tglSelesai = $_POST['tglSelesai'];
        $lvlPenting = $_POST['lvlPenting'];
        $lokasiKegiatan = $_POST['lokasiKegiatan'];
        $gambar = $_POST['oldGambar'];

        //handel files
        if(!empty($_FILES['gambar']['name'])){
            unlink($_POST['oldGambar']);
            $lokal = "img/".$_FILES["gambar"]["name"];
            $tipefile = strtolower(pathinfo($lokal, PATHINFO_EXTENSION));
            move_uploaded_file($_FILES["gambar"]["tmp_name"],$lokal);
            $gambar = $lokal;
            
        }
        
        //handle durasi:
        $DT1 = new DateTime($tglMulai);
        $DT2 = new DateTime($tglSelesai);
        $interval = $DT1->diff($DT2); //mencari selisih
        $durasiKegiatan = $interval->format('%a days %h hours %i minutes %s seconds');
        
        //$i = 0;
        $DT1Day = $DT1->format('d');
        $inputSukses = true;
        do{
            $tglKegiatan = date("Y-m-d",mktime(0,0,0,$DT1->format('m'),$DT1Day,$DT1->format('Y')));
            //echo $tglKegiatan . "<br>"; 
            //$i++;
            $DT1Day++;
            
            $sql = "INSERT INTO detailKegiatan(user_id, namaKegiatan, tglMulai, tglKegiatan, tglSelesai, lvlPenting, durasiKegiatan, lokasiKegiatan, gambar) VALUES ($userId,'$namaKegiatan', '$tglMulai', '$tglKegiatan', '$tglSelesai', '$lvlPenting', '$durasiKegiatan', '$lokasiKegiatan','$gambar')";
            if(!$result = mysqli_query($koneksi, $sql)){
                $inputSukses = false;
                break;
            }
            //$result = mysqli_query($koneksi, $sql);
        }while($tglKegiatan != date("Y-m-d",mktime(0,0,0,$DT2->format('m'),$DT2->format('d'),$DT2->format('Y'))));

        if($inputSukses){
            //header("refresh:3");
            echo "<meta http-equiv='refresh' content='0'>";
        } else{
            echo"Input kegiatan gagal!";
        }
        echo "<meta http-equiv='refresh' content='0'>";
        mysqli_close($koneksi);
    }

    if (isset($_POST["deleteKegiatan"])){
        $userId2 = $_POST["oldUser2"];
        $oldMulai2 = $_POST["oldMulai2"];
        $oldNama2 = $_POST["oldNama2"];
        $oldSelesai2 = $_POST["oldSelesai2"];
        $oldLokasi2 = $_POST["oldLokasi2"];
        $sqlDel = "DELETE FROM detailKegiatan WHERE user_id='$userId2' AND namaKegiatan='$oldNama2' AND tglMulai='$oldMulai2' AND tglSelesai='$oldSelesai2' AND lokasiKegiatan='$oldLokasi2'";
        $resultDel2 = mysqli_query($koneksi, $sqlDel);
        if($resultDel2){echo "berhasil hapus";echo "<meta http-equiv='refresh' content='0'>";}
    }

?>
