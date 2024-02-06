$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

var currentUrl = window.location.href;
var role = $("#role").val();

if (role == "Admin") {
    var hidden = "";
    var url = "/admin/task-report/";
} else if (role == "Supervising Consultant") {
    var hidden = "d-none";
    var url = "/konsultan-pengawas/task-report/";
} else if (role == "Partner") {
    var hidden = "d-none";
    var url = "/rekanan/task-report/";
} else if (role == "Site Supervisor") {
    var hidden = "d-none";
    var url = "/pengawas-lapangan/task-report/";
} else if (role == "Acting Commitment Marker") {
    var hidden = "d-none";
    var url = "/ppk/task-report/";
} else {
    var hidden = "d-none";
    var url = "/task-report/";
}

// show datatable data

// Class definition
var KTDatatablesServerSide = (function () {
    // Shared variables
    var dt;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_dom_positioning").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            scrollX: true,
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
                    data: "activity_name",
                    name: "activity_name",
                },
                {
                    orderable: false,
                    data: "task_name",
                    name: "task_name",
                },
                {
                    orderable: true,
                    data: "fiscal_year",
                    name: "fiscal_year",
                },
                {
                    orderable: true,
                    data: "spk_date",
                    name: "spk_date",
                },
                {
                    orderable: true,
                    data: "status",
                    name: "status",
                },
                {
                    data: "id",
                    name: "id",
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
                    targets: 4,
                    searchable: true,
                    orderable: true,
                    render: function (data) {
                        var spkDate = new Date(data);

                        var formatter = new Intl.DateTimeFormat("id-ID", {
                            year: "numeric",
                            month: "2-digit",
                            day: "2-digit",
                        });
                        var formatTanggal = formatter
                            .format(spkDate)
                            .replace(/\//g, "-");

                        return formatTanggal;
                    },
                },
                {
                    targets: -2,
                    searchable: true,
                    orderable: true,
                    render: function (data, type, row) {
                        if (data == "Aktif") {
                            const dateNow = new Date().getTime();
                            const dateSpk = new Date(row.spk_date).getTime();

                            if (dateNow < dateSpk) {
                                return `<span class="badge badge-secondary">Belum Mulai</span>`;
                            }

                            var color = "success";
                        } else if (data == "SP 1" || data == "SCM 1") {
                            var color = "danger";
                        } else if (data == "SCM 2" || data == "SCM 3") {
                            var color = "danger";
                        }

                        return `<span class="badge badge-${color}">${data}</span>`;
                    },
                },
                {
                    targets: -1,
                    searchable: false,
                    orderable: false,
                    className: "text-left",
                    render: function (data, type, row) {
                        if (
                            role == "Partner" ||
                            role == "Supervising Consultant"
                        ) {
                            if (
                                row.status == "SP 1" ||
                                row.status == "SCM 1" ||
                                row.status == "SCM 2" ||
                                row.status == "SCM 3"
                            ) {
                                var spButton = `<a href="/surat-sp/${row.id}" class="btn btn-warning btn-sm">Surat SP</a>`;
                            } else {
                                var spButton = ``;
                            }
                        } else {
                            var spButton = "";
                        }

                        return `
                            <a href="#" class="btn btn-primary btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                                Aksi
                                <span class="svg-icon fs-5 m-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/report/${row.id}" target="_blank" class="menu-link px-3">
                                        Cetak
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="${url}${row.id}" class="menu-link px-3">
                                        Detail
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="/admin/edit-task-report/${row.id}" class="menu-link px-3 ${hidden}">
                                        Ubah
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a href="#" class="menu-link px-3 ${hidden}" data-name="${row.activity_name}" data-id="${row.id}" id="delete">
                                        Hapus
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->

                            ${spButton}    
                            `;
                    },
                },
            ],
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on("draw", function () {
            KTMenu.createInstances();
        });
    };

    // Public methods
    return {
        init: function () {
            initDatatable();
        },
    };
})();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
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
                url: "/admin/destroy-task-report/" + id,
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

$("body").on("click", "#emptyHistory", function () {
    Swal.fire({
        icon: "warning",
        title: "Belum Ada Riwayat",
    });
});

//  Delete Data
$("body").on("click", "#removeItemButton", function () {
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
                url: "/admin/task-report/destroy-kind-of-work/" + id,
                dataType: "json",
                type: "DELETE",
                success: function (response) {
                    if (response.status == 200) {
                        success("Berhasil");
                        setTimeout(function () {
                            window.location = "";
                        }, 1450);
                    } else {
                        failed("Gagal Menghapus");
                    }
                },
            });
        }
    });
});
