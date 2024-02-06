$("#sendTaskReportAgreement").submit(function (event) {
    event.preventDefault(); // Mencegah formulir dikirim secara otomatis

    // Tampilkan popup konfirmasi
    Swal.fire({
        title: "Apakah Anda yakin ingin mengirim persetujuan pekerjaan?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya, Kirim",
        cancelButtonText: "Tidak, Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika pengguna menekan "Ya, Kirim", submit formulir
            $(this).unbind("submit").submit();
        } else {
            // Jika pengguna menekan "Tidak, Batal", tidak lakukan apa-apa
        }
    });
});
