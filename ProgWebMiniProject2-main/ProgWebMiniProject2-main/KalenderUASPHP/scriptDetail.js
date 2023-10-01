function lihatSemua(id){
    location.href='multipleKegiatan.php?id='+id;
};

function lihatDetail(id){
    location.href='detailKegiatan.php?id='+id;
   
};

// const openButton = document.querySelector("[data-open-modal]");
// const closeButton = document.querySelector("[data-close-modal]"); 
// const modal = document.querySelector("[data-modal]");

// openButton.addEventListener("click", ()=>{modal.showModal();})
// closeButton.addEventListener("click", ()=>{modal.closest();});
let formBackground = document.getElementById("formBackground");
let confirmDelete = document.getElementById("confirmDelete");
let batalButton = document.getElementById("batalButton");
let batalButton2 = document.getElementById("batalButton2");

function deleteEvent(userId, nama, lvl, mulai, selesai, lokasi,gambar ){
    formBackground.style.display = "block";
    confirmDelete.style.display = "block";
    let setOldUser2 = document.getElementById("oldUser2");
    let setOldNama2 = document.getElementById("oldNama2");
    let setOldMulai2 = document.getElementById("oldMulai2");
    let setOldSelesai2 = document.getElementById("oldSelesai2");
    let setOldLokasi2 = document.getElementById("oldLokasi2");
    let setOldGambar2 = document.getElementById("oldGambar2");

    setOldUser2.setAttribute("value", userId);
    setOldNama2.setAttribute("value", nama);
    setOldMulai2.setAttribute("value", mulai);
    setOldSelesai2.setAttribute("value", selesai);
    setOldLokasi2.setAttribute("value", lokasi);
    setOldGambar2.setAttribute("value", gambar);

    batalButton2.addEventListener("click", ()=>{
        formBackground.style.display = "None";
        confirmDelete.style.display = "None";
    })

}



let formUpdateKegiatan = document.getElementById("formUpdateKegiatan");
function showFormUpdate(userId, nama, lvl, mulai, selesai, lokasi,gambar ){
    formBackground.style.display = "block";
    formUpdateKegiatan.style.display = "block";
    let setOldUser = document.getElementById("oldUser");
    let setOldNama = document.getElementById("oldNama");
    let setOldMulai = document.getElementById("oldMulai");
    let setOldSelesai = document.getElementById("oldSelesai");
    let setOldLokasi = document.getElementById("oldLokasi");
    let setOldGambar = document.getElementById("oldGambar");

    setOldUser.setAttribute("value", userId);
    setOldNama.setAttribute("value", nama);
    setOldMulai.setAttribute("value", mulai);
    setOldSelesai.setAttribute("value", selesai);
    setOldLokasi.setAttribute("value", lokasi);
    setOldGambar.setAttribute("value", gambar);

    let setNama = document.getElementById("namaKegiatan");
    let setMulai = document.getElementById("tglMulai");
    let setSelesai = document.getElementById("tglSelesai");
    let setLokasi = document.getElementById("lokasiKegiatan");
    let setGambar = document.getElementById("path");
    let setLevel = document.getElementById("lvlPenting");
    setNama.setAttribute("value", nama);
    setMulai.setAttribute("value", mulai);
    setSelesai.setAttribute("value", selesai);
    setLokasi.setAttribute("value", lokasi);
    setGambar.innerText = gambar;
    setLevel.value = lvl;
    
    batalButton.addEventListener("click", ()=>{
        formBackground.style.display = "None";
        formUpdateKegiatan.style.display = "None";
    }
    )
};

let formUpdate= document.getElementById("formUpdate");
let namaAlert = document.getElementById("alertNama");
let alertMulai = document.getElementById("alertMulai");
let alertSelesai = document.getElementById("alertSelesai");
let alertLevel = document.getElementById("alertLevel");
let alertLokasi = document.getElementById("alertLokasi");
formUpdate.addEventListener('submit', function(event){
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
    

    if(namaKegiatan.value == ""){
        namaAlert.innerHTML = "Masih kosong!";
        incompleteMsg += "Nama Kegiatan masih kosong...\n";
        namaKegiatan.style.border = "1px solid red";
    }

    if(tglMulai.value == ""){
        alertMulai.innerHTML = "Masih kosong!";
        incompleteMsg += "tanggal mulai masih kosong...\n";
        tglMulai.style.border = "1px solid red";
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
    formUpdate.style.display = "none";
    formTambahKegiatan.style.display = "none";
}
