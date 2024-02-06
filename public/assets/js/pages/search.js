function scrollToElementWithSpace(elementId, space) {
    var element = document.getElementById(elementId);
    var navbarHeight = document.getElementById("kt_app_header").offsetHeight; // Ganti dengan ID navbar Anda

    // Hitung posisi gulir yang diinginkan
    var scrollPosition =
        element.getBoundingClientRect().top +
        window.scrollY -
        navbarHeight -
        space;

    // Gulir ke posisi tersebut
    window.scrollTo({
        top: scrollPosition,
        behavior: "smooth", // Animasi gulir
    });
}

var currentIndex = -1; // Variabel untuk melacak indeks teks yang telah ditemukan saat ini
var foundTexts = []; // Variabel untuk menyimpan teks yang telah ditemukan

function search() {
    var name =
        document.getElementById("searchForm").elements["searchItem"].value;
    var pattern = new RegExp(name, "gi"); // "gi" akan mencari semua kemunculan kata dengan "g" untuk global dan "i" untuk mengabaikan perbedaan huruf besar/kecil

    var divs = document.getElementsByClassName("parentSearchable");

    var targetIds = [];

    // Temukan indeks kata yang sesuai berikutnya
    var startIndex = currentIndex + 1;

    // Jika sudah mencapai kata yang terakhir, arahkan kembali ke kata pertama
    if (startIndex >= divs.length) {
        startIndex = 0;
    }

    // Temukan kata yang sesuai dari indeks yang sesuai berikutnya
    var found = false;

    for (var i = startIndex; i < divs.length; i++) {
        var para = divs[i].getElementsByClassName("childSearchable");
        var text = para[0].innerText.toLowerCase();

        if (text.match(pattern)) {
            var targetId = divs[i].parentNode.id;
            targetIds.push(targetId);
            foundTexts.push(text);

            // Tambahkan warna latar belakang
            var targetElement = document.getElementById(targetId);
            targetElement.style.backgroundColor = "yellow"; // Ganti dengan warna yang Anda inginkan

            // Gulir ke elemen yang cocok
            scrollToElementWithSpace(targetId, 20); // Ganti 20 dengan jarak tambahan yang Anda inginkan
            currentIndex = i; // Perbarui indeks saat ini
            found = true;
            break; // Berhenti setelah menemukan yang cocok pertama
        }
    }

    console.log(currentIndex);

    if (currentIndex == -1) {
        alert("Kata tidak ditemukan");
    }

    // Jika data tidak ditemukan
    if (!found) {
        // Set currentIndex ke 0
        currentIndex = -1;
    }
}
