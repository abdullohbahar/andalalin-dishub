// Fungsi untuk mengubah angka menjadi format Rupiah
function formatRupiah(number) {
    // Ubah number menjadi string
    number = number.toString();

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
$("#contract_unit_price").on("keyup", function () {
    var number = $(this).val();
    var formatted = formatRupiah(number);
    $(this).val(formatted);
});

// menghitung total harga
document.addEventListener("DOMContentLoaded", function () {
    var contractUnitPriceInput = document.getElementById("contract_unit_price");
    var volumeInput = document.getElementById("contract_volume");
    var totalPriceInput = document.getElementById("total_contract_price");

    // Fungsi untuk menghapus format Rupiah dan mengembalikan angka
    function extractNumber(value) {
        return parseFloat(value.replace(/[^\d]+/g, "")) || 0;
    }

    // Fungsi untuk menghitung total harga
    function calculateTotalPrice() {
        var contractUnitPrice = extractNumber(contractUnitPriceInput.value);
        var volume = parseFloat(volumeInput.value) || 0;
        var totalHarga = contractUnitPrice * volume;
        totalPriceInput.value = formatRupiah(totalHarga); // Menampilkan total harga dengan dua desimal
    }

    // Event listener untuk menghitung total harga saat pengguna menginputkan nilai
    contractUnitPriceInput.addEventListener("input", calculateTotalPrice);
    volumeInput.addEventListener("input", calculateTotalPrice);
});
