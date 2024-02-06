// Fungsi untuk mengubah angka menjadi format Rupiah
function formatRupiah(number) {
    // Konversi angka menjadi format Rupiah dengan toLocaleString
    var formatted = Number(number).toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
    });

    return formatted;
}

function formatRupiahMcUnit(number) {
    // Ubah number menjadi string
    number = number.toString();

    // Hapus semua karakter selain digit
    number = number.replace(/\D/g, "");

    // Pastikan ada number sebelum mengubahnya menjadi format Rupiah
    if (number.length > 0) {
        // Ubah number menjadi format Rupiah
        var reverse = number.toString().split("").reverse().join("");
        var ribuan = reverse.match(/\d{1,3}/g);
        console.log("ribuan: " + ribuan);
        var formatted = ribuan.join(".").split("").reverse().join("");
        return "Rp " + formatted;
    } else {
        return ""; // Mengembalikan string kosong jika tidak ada number
    }
}

// Menggunakan event keyup untuk mengubah number saat diketikkan
$("#mc_unit_price").on("keyup", function () {
    var number = $(this).val();
    var formatted = formatRupiahMcUnit(number);
    $(this).val(formatted);
});

// menghitung total harga
document.addEventListener("DOMContentLoaded", function () {
    var mcUnitPriceInput = document.getElementById("mc_unit_price");
    var volumeInput = document.getElementById("mc_volume");
    var totalPriceInput = document.getElementById("total_mc_price");

    // Fungsi untuk menghapus format Rupiah dan mengembalikan angka
    function extractNumber(value) {
        return parseFloat(value.replace(/[^\d]+/g, "")) || 0;
    }

    function convertToDot(value) {
        var convertedValue = value.replace(",", ".");
        return parseFloat(convertedValue);
    }

    // Fungsi untuk menghitung total harga
    function calculateTotalPrice() {
        var mcUnitPrice = extractNumber(mcUnitPriceInput.value);
        var volume = convertToDot(volumeInput.value) || 0;
        var totalHarga = mcUnitPrice * volume;
        console.log("total harga: " + totalHarga);
        totalPriceInput.value = formatRupiah(totalHarga); // Menampilkan total harga dengan dua desimal
    }

    // Event listener untuk menghitung total harga saat pengguna menginputkan nilai
    mcUnitPriceInput.addEventListener("input", calculateTotalPrice);
    volumeInput.addEventListener("input", calculateTotalPrice);
});
