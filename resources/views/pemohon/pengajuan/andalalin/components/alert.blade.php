<div class="col-12">
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <i class="ki-duotone ki-notification-bing fs-2hx text-dark me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                class="path2"></span><span class="path3"></span></i>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column text-dark pe-0 pe-sm-10">
            <!--begin::Title-->
            <h4 class="mb-2 light">Peringatan !</h4>
            <!--end::Title-->

            <!--begin::Content-->
            <span style="font-size: 11pt">
                @if ($klasifikasi == 'rendah')
                    Kategori Pengajuan Anda Masuk Kedalam Kategori Rendah,
                    Anda Tidak Wajib Memilih Konsultan
                @else
                    Kategori Pengajuan Anda Masuk Kedalam Kategori Tinggi,
                    Anda Wajib Memilih Konsultan
                @endif
            </span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
</div>
