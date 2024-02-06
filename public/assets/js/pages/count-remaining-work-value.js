// remove percentage on input
$("body").on("keyup", ".progress-value", function () {
    var val = $(this).val();
    val = val.replace("%", ""); // Menghapus karakter '%'
    $(this).val(val); // Mengatur nilai input dengan hasil yang telah dimodifikasi
});

$("#myForm").on("submit", function () {
    var progressValue = $(".progress-value");
    var workValue = parseFloat($("#work_value").val().replace("%", ""));

    // Variabel untuk menyimpan hasil penjumlahan
    var total = 0;

    // Loop melalui semua elemen input dan menambahkan nilainya ke total
    progressValue.each(function () {
        console.log($(this).val());
        total += parseFloat($(this).val().replace("%", "")) || 0; // Menambahkan nilai dengan konversi ke float, atau 0 jika tidak valid.
    });

    console.log(total, workValue);

    if (total > workValue) {
        alert("Total Progress Tidak Boleh Melebihi Nilai Pekerjaan!");
        return false;
    }
});
