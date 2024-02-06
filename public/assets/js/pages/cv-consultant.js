$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var currentUrl = window.location.href;

// show datatable data

$("#kt_datatable_dom_positioning").DataTable({
    searchDelay: 500,
    processing: true,
    serverSide: true,
    ajax: {
        url: currentUrl,
    },
    language: {
        lengthMenu: "Show _MENU_",
    },
    dom:
        "<'row'" +
        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
        "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
        ">" +
        "<'table-responsive'tr>" +
        "<'row'" +
        "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
        "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
        ">",
    columns: [
        {
            orderable: false,
            data: null,
            name: null,
        },
        {
            orderable: true,
            data: "name",
            name: "name",
        },
        {
            orderable: true,
            data: "phone_number",
            name: "phone_number",
        },
        {
            orderable: false,
            data: "address",
            name: "address",
        },
        {
            data: null,
            name: null,
        },
    ],
    columnDefs: [
        {
            targets: 0,
            data: null,
            searchable: false,
            orderable: false,
            className: "text-left border-bottom",
            render: (data, type, row, meta) => {
                return meta.row + meta.settings._iDisplayStart + 1;
            },
        },
        {
            data: null,
            targets: -1,
            searchable: false,
            orderable: false,
            className: "text-left",
            render: function (data, type, row) {
                return `<a href="/admin/cv-consultant/${row.id}/edit" class="btn btn-sm btn-bg-warning my-1 text-white">Ubah</a>
                            <a href="#" class="btn btn-sm btn-bg-danger my-1 text-white" data-name="${row.name}" data-id="${row.id}" id="delete">Hapus</a>`;
            },
        },
    ],
});

//  Delete Data
$("body").on("click", "#delete", function () {
    var id = $(this).data("id");
    var name = $(this).data("name");

    Swal.fire({
        title: `Apakah Anda Ingin Menghapus ${name}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Hapus",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/admin/cv-consultant/" + id,
                dataType: "json",
                type: "DELETE",
                success: function (response) {
                    if (response.status == 200) {
                        success(response.message);
                        setTimeout(function () {
                            window.location = "";
                        }, 1450);
                    } else {
                        failed(response.message);
                    }
                },
            });
        }
    });
});
