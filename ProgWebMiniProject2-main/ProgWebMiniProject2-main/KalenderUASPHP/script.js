//for index, indexnext, and indexprev:
let formBackground = document.getElementById("formBackground");
let formTambahKegiatan = document.getElementById("formTambahKegiatan");
let formTambah = document.getElementById("formTambahKegiatan2");
let formPreview = document.getElementById("formPreview");

//form
let namaKegiatan = document.getElementById("namaKegiatan");
let tglMulai = document.getElementById("tglMulai");
let tglSelesai = document.getElementById("tglSelesai");
let lvlPenting = document.getElementById("lvlPenting");
//let durasiKegiatan = document.getElementById("durasiKegiatan");
let lokasiKegiatan = document.getElementById("lokasiKegiatan");
let gambar = document.getElementById("gambar");

let saveButton = document.getElementById("saveButton");
let cancelButton = document.getElementById("cancelButton");
let closeButton = document.getElementById('closeButton'); // untuk menutup preview
let seeButton = document.getElementById('seeButton');
let multipleButton = document.getElementById('multipleKegiatan');


// function yang dipake element-element html:
function showFormTambah(){
    formBackground.style.display = "block";
    formTambahKegiatan.style.display = "block";
}

function showPreview(event, id, judul, mulai, berhenti, level, durasi, lokasi, gambar){
    //edit behavior form dari sini:
    formBackground.style.display = "block";
    formPreview.style.display = "block";
    let judulKegiatan = document.getElementById('preNamaKegiatan');
    let tglMulai = document.getElementById('preTglMulai');
    let tglSelesai = document.getElementById('preTglSelesai');
    let lvlPrev = document.getElementById('preLvlPenting');
    let lokasiPrev = document.getElementById('preLokasi');
    let durasiPrev = document.getElementById('preDurasi');
    let gambarPrev = document.getElementById('preGambar');


    judulKegiatan.innerHTML = judul;
    tglMulai.innerHTML = mulai;
    tglSelesai.innerHTML = berhenti;
    lvlPrev.innerHTML = level;
    durasiPrev.innerHTML = durasi;
    lokasiPrev.innerHTML = lokasi;
    gambarPrev.setAttribute("src", gambar);
    seeButton.addEventListener('click', () => {
        location.href='detailKegiatan.php?id='+id;
    })

    multipleButton.addEventListener('click', () => {location.href='multipleKegiatan.php?id='+id});

    event.stopPropagation(); //method sakti
}

function closeFormTambah(){
    formBackground.style.display = "none";
    formTambahKegiatan.style.display = "none";
    namaKegiatan.value = "";
    tglMulai.value = "";
    tglSelesai.value = "";
    lvlPenting.value = "kosong";
    //durasiKegiatan.value = "";
    lokasiKegiatan.value = "";
}

cancelButton.addEventListener('click', closeFormTambah) //cause the page to restart, fix: merubah letak cancel button diluar form
closeButton.addEventListener('click', ()=>{
    formBackground.style.display = "none";
    formPreview.style.display = "none";
}) //work as intended
let namaAlert = document.getElementById("alertNama");
let alertMulai = document.getElementById("alertMulai");
let alertSelesai = document.getElementById("alertSelesai");
let alertLevel = document.getElementById("alertLevel");
let alertLokasi = document.getElementById("alertLokasi");

formTambah.addEventListener('submit', function(event){
    var incompleteMsg = "";
    var tipefile = "";


    //reseting border color:
    namaKegiatan.style.border = "1px solid black";
    tglMulai.style.border = "1px solid black";
    tglSelesai.style.border = "1px solid black";
    lvlPenting.style.border = "1px solid black";
    lokasiKegiatan.style.border = "1px solid black";
    gambar.style.border = "1px solid black";

    if(gambar.value != ""){
        tipefile = gambar.value.split('.').pop();
    }

    

    if(tglMulai.value!= "" && tglSelesai.value != ""){
        var substringTglMulai = tglMulai.value.split("T");
        var substringTglSelesai = tglSelesai.value.split("T");

        var substringDate1 = substringTglMulai[0].split("-");
        var substringTime1 = substringTglMulai[1].split(":");
        var substringDate2 = substringTglSelesai[0].split("-");
        var substringTime2 = substringTglSelesai[1].split(":");

        var dateStart = new Date(substringDate1[0], substringDate1[1]-1, substringDate1[2], substringTime1[0], substringTime1[1], 0);
        var dateEnd = new Date(substringDate2[0], substringDate2[1]-1, substringDate2[2], substringTime2[0], substringTime2[1], 0);
    }

    
    let ToDate = new Date();

    if(namaKegiatan.value == ""){
        namaAlert.innerHTML = "Masih kosong!";
        incompleteMsg += "Nama Kegiatan masih kosong...\n";
        namaKegiatan.style.border = "1px solid red";
    }

    if (tglMulai.value == "") {
        alertMulai.innerHTML = "Masih kosong!";
        incompleteMsg += "tanggal mulai masih kosong...\n";
        tglMulai.style.border = "1px solid red";
    } else {
        var dateMulai = new Date(tglMulai.value);
        if (isNaN(dateMulai)) {
            alertMulai.innerHTML = "Format tanggal tidak valid!";
            tglMulai.style.border = "1px solid red";
        } else if (dateMulai.getTime() <= ToDate.getTime()) {
            alertMulai.innerHTML = "Tanggal sudah lewat!";
        }
    }
    

    if(tglSelesai.value == ""){
        alertSelesai.innerHTML = "Masih kosong!\n";
        incompleteMsg += "tanggal selesai masih kosong...\n";
        tglSelesai.style.border = "1px solid red";
    }
    else if(dateEnd - dateStart < 0){
        alertSelesai.innerHTML = "Harus diatas tanggal mulai\n";
        incompleteMsg += "tanggal selesai lebih besar daripada tanggal dimulai...\n";
        tglSelesai.style.border = "1px solid red";
    }

    if(lvlPenting.value == "kosong"){
        alertLevel.innerHTML = "Masih kosong!";
        incompleteMsg += "tingkat kepentingan masih kosong...\n";
        lvlPenting.style.border = "1px solid red";
    }

    if(lokasiKegiatan.value == ""){
        alertLokasi.innerHTML = "Masih Kosong!";
        incompleteMsg += "lokasi kegiatan masih kosong...\n";
        lokasiKegiatan.style.border = "1px solid red";
    }
    if(incompleteMsg != ""){
        // alert(incompleteMsg);
        //alert("judul: ".namaKegiatan.value);
        event.preventDefault();
    }
}

)
    
function reset(){
    alertLevel.innerHTML = "";
    alertLokasi.innerHTML = "";
    alertMulai.innerHTML = "";
    alertSelesai.innerHTML = "";
    namaAlert.innerHTML = "";
    formBackground.style.display = "None";
    formTambahKegiatan.style.display = "none";
    namaKegiatan.style.border = "1px solid black";
    tglMulai.style.border = "1px solid black";
    tglSelesai.style.border = "1px solid black";
    lvlPenting.style.border = "1px solid black";
    lokasiKegiatan.style.border = "1px solid black";
    gambar.style.border = "1px solid black";
    
}
// this part for testing purposes:
