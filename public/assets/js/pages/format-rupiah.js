// Fungsi untuk mengubah angka menjadi format Rupiah
function formatRupiah(number) {
    // Hapus semua karakter selain digit
    number = number.replace(/\D/g, "");

    // Pastikan ada number sebelum mengubahnya menjadi format Rupiah
    if (number.length > 0) {
        // Ubah number menjadi format Rupiah
        var reverse = number.toString().split("").reverse().join("");
        var ribuan = reverse.match(/\d{1,3}/g);
        var formatted = ribuan.join(".").split("").reverse().join("");
        return "Rp " + formatted;
    } else {
        return ""; // Mengembalikan string kosong jika tidak ada number
    }
}

// Menggunakan event keyup untuk mengubah number saat diketikkan
$("#contract_value").on("keyup", function () {
    console.log($(this).val());
    var number = $(this).val();
    var formatted = formatRupiah(number);
    $(this).val(formatted);
});
