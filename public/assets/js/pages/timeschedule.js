// remove percentage on input
$("body").on("keyup", ".progress-value", function () {
    var val = $(this).val();
    val = val.replace("%", ""); // Menghapus karakter '%'
    $(this).val(val); // Mengatur nilai input dengan hasil yang telah dimodifikasi
});

$("#myForm").on("submit", function () {
    var progressValue = $(".progress-value");
    var workValue = parseFloat($("#workValue").text());

    console.log(workValue);

    // Variabel untuk menyimpan hasil penjumlahan
    var total = 0;

    // Loop melalui semua elemen input dan menambahkan nilainya ke total
    progressValue.each(function () {
        total += parseFloat($(this).val()); // Menambahkan nilai dengan konversi ke float, atau 0 jika tidak valid.
    });

    if (total > workValue) {
        alert("Total Time Schedule Tidak Boleh Melebihi Nilai Pekerjaan!");
        return false;
    }
});
