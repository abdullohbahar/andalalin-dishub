var modalUploadPicture = new bootstrap.Modal(
    document.getElementById("modalUploadPicture"),
    {}
);

$("body").on("click", "#uploadPicture", function () {
    var date = $(this).data("date");
    var scheduleid = $(this).data("scheduleid");
    var week = $(this).data("week");
    $("#datePicture").val(date);
    $("#scheduleid").val(scheduleid);
    $("#week").val(week);

    modalUploadPicture.show();
});

var modalSeePicture = new bootstrap.Modal(
    document.getElementById("modalSeePicture"),
    {}
);

$("body").on("click", "#seePicture", function () {
    var id = $(this).data("scheduleid");
    var url = window.location.origin;
    // Fungsi async untuk mengirim permintaan AJAX
    async function fetchData() {
        try {
            const response = await fetch("/get-progress-picture/" + id);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json(); // Mengambil data JSON dari respons

            $(".appendImage").empty();
            $(".appendBtn").empty();

            console.log(data);

            if (data.datas.length > 0) {
                data.datas.forEach((item, index) => {
                    index += 1;
                    // $("#pict" + index).attr("src", url + "/" + item.picture);

                    var img = `
                    <div class="col-sm-12 col-md-4">
                        <img src="${url}/${item.picture}" id="pict${index}" class="img-thumbnail mx-1" alt="">
                    </div>
                    `;

                    var btn = `
                        <div class="col-sm-12 col-md-4">
                            <button class="btn btn-danger btn-sm mt-2" style="width: 100%" data-id="${item.id}" id="deletePicture">Hapus</button>
                        </div>
                    `;

                    $(".appendBtn").append(btn);
                    $(".appendImage").append(img);
                });
            } else {
                var html = `<h1>Belum Ada Foto</h1>`;
                $(".appendImage").append(html);
            }
            modalSeePicture.show();
        } catch (error) {
            // Tangani kesalahan jika terjadi
            console.error("Terjadi kesalahan:", error);
        }
    }

    // Panggil fungsi fetchData
    fetchData();
});

$("body").on("click", "#deletePicture", function () {
    var id = $(this).data("id");

    Swal.fire({
        title: "Apakah anda yakin?",
        text: "Foto yang dihapus tidak bisa dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, Hapus",
        cancelButtonText: "Batal",
    }).then((result) => {
        $.ajax({
            url: "/konsultan-pengawas/remove-progress-picture/" + id,
            dataType: "JSON",
            method: "DELETE",
            success: function (response) {
                console.log(response);
                if (response.status == 200) {
                    success(response.message);
                    setTimeout(function () {
                        window.location = "";
                    }, 1450);
                }
            },
        });
    });
});

$("body").on("click", "#seePictureOtherRole", function () {
    var kindOfWorkDetailID = $(this).data("kindofworkdetailid");
    var week = $(this).data("week");
    var scheduleID = $(this).data("scheduleid");
    console.log(scheduleID);
    var url = window.location.origin;
    // Fungsi async untuk mengirim permintaan AJAX
    async function fetchData() {
        try {
            const response = await fetch(
                "/get-progress-picture-other-role/" +
                    kindOfWorkDetailID +
                    "/" +
                    week
            );
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json(); // Mengambil data JSON dari respons

            $(".appendImage").empty();

            if (data.datas.length > 0) {
                data.datas.forEach((item, index) => {
                    console.log(item);

                    if (item.length > 0) {
                        item.forEach((item, index) => {
                            var img = `
                            <div class="col-sm-12 col-md-4">
                                <img src="${url}/${item.picture}" id="pict${index}" class="img-thumbnail mx-1" alt="">
                            </div>
                            `;

                            $(".appendImage").append(img);
                        });
                    } else {
                        var html = `<h1>Belum Ada Foto</h1>`;
                        $(".appendImage").append(html);
                    }
                });
            } else {
                var html = `<h1>Belum Ada Foto</h1>`;
                $(".appendImage").append(html);
            }
            modalSeePicture.show();
        } catch (error) {
            // Tangani kesalahan jika terjadi
            alert("Terjadi kesalahan:", error);
        }
    }

    // Panggil fungsi fetchData
    fetchData();
});
