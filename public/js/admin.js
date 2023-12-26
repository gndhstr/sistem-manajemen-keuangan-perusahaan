confirmDelete = function (button) {
    var url = $(button).data("url");
    var nama = $(button).data("nama");
    swal({
        "text": "Konfirmasi Hapus",
        "text": "Apakah anda yakin menghapus Divisi " + nama + "?",
        "icon": "warning",
        "dangermode": true,
        "buttons": true,
    }).then(function (value) {
        if (value) {
            window.location = url;
        }
    })
}

//ubah ukuran text alert succes
var successMessage = "{{ session('success') }}";
if (successMessage) {
    Swal.fire({
        // title: "Sukses",
        text: successMessage,
        icon: "success",
        confirmButtonClass: 'btn btn-primary',
        confirmButtonText: 'OK',
        timer: 5000,
        customClass: {
            // title: 'swal-title',
            content: 'swal-text',
        }
    });
}

//tabel 
const textCenterTdElements = document.querySelectorAll('.table td.text-center');

// Fungsi untuk menyesuaikan kelas pada elemen <td> dan <table>
function adjustLayout() {
    const windowWidth = window.innerWidth;

    // Jika lebar layar kurang dari atau sama dengan 500px
    if (windowWidth <= 500) {
        // Hapus kelas text-center dari elemen <td>
        textCenterTdElements.forEach(td => {
            td.classList.remove('text-center');
        });


    } else {
        // Jika lebar layar lebih dari 500px, tambahkan kembali kelas yang dihapus sebelumnya
        textCenterTdElements.forEach(td => {
            td.classList.add('text-center');
        });


    }
}

// Panggil fungsi pertama kali saat dokumen dimuat
adjustLayout();

// Tambahkan event listener untuk menanggapi perubahan ukuran layar
window.addEventListener('resize', adjustLayout);

// fungsi data table
$(function () {
    $("#dataTable").DataTable();
});
