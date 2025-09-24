$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function showLoader() {
    $("#loader").fadeIn(200);
}
function hideLoader() {
    $("#loader").fadeOut(200);
}

// Fungsi load dropdown dengan opsi selected
function loadDropdown(url, selectId, key, selectedId = null) {
    $.get(url, function (res) {
        if (res.success) {
            let options = `<option value="">Pilih </option>`;
            res.data.forEach((item) => {
                let display = item[key] ?? item.nama ?? item.name ?? "-";
                let selected = selectedId == item.id ? "selected" : "";
                options += `<option value="${item.id}" ${selected}>${display}</option>`;
            });
            $(`#${selectId}`).html(options);
        } else {
            $(`#${selectId}`).html(`<option value="">Data kosong</option>`);
        }
    }).fail(() => {
        $(`#${selectId}`).html(`<option value="">Gagal memuat ${key}</option>`);
    });
}

$(document).ready(function () {
    // === Load dropdown saat halaman siap ===
    loadDropdown("/api/supplier", "supplier_id", "nama_supplier");
    loadDropdown("/api/kemasan", "kemasan_id", "nama_kemasan");
    loadDropdown("/api/satuankecil", "satuan_kecil_id", "nama_satuankecil");
    loadDropdown("/api/satuanbesar", "satuan_besar_id", "nama_satuanbesar");
    loadDropdown("/api/kategori", "kategori_id", "nama_kategori");
    loadDropdown("/api/aturanpakai", "aturanpakai_id", "frekuensi_pemakaian");
    loadDropdown("/api/metodepembayaran", "metodepembayaran_id", "nama_metode");
    const apiUrl = "/api/obat"; // API route resource

    const table = $("#tableObat").DataTable({
        processing: true,
        scrollX: true,
        fixedHeader: true,
        ajax: { url: apiUrl, dataSrc: "data" },
        serverSide: false,
        responsive: true,
        autoWidth: false,
        columns: [
            {
                data: null,
                render: (d, t, r, m) => m.row + 1,
                className: "text-center",
            }, // nomor urut
            { data: "nama_obat" },
            { data: "supplier", title: "Supplier" },
            { data: "kategori", title: "Kategori" },
            { data: "kemasan", title: "Kemasan" },
            { data: "aturanpakai", title: "Aturan Pakai" },
            { data: "satuan_kecil", title: "Satuan Kecil" },
            { data: "satuan_besar", title: "Satuan Besar" },
            { data: "metode_pembayaran", title: "Metode Pembayaran" },
            // { data: "deskripsi_obat" },
            // { data: "stok" },
            {
                data: "created_at",
                render: function (data) {
                    let date = new Date(data);
                    return date.toLocaleDateString("id-ID", {
                        day: "2-digit",
                        month: "long", // pakai huruf, contoh: September
                        year: "numeric",
                    });
                },
            },
            //     {
            //         data: "foto",
            //         title: "Foto Obat",
            //         render: function (foto, type, row) {
            //             let gambar = foto ? foto : "default.png";
            //             return `
            //     <button class="btn btn-sm btn-primary btn-foto"
            //         data-foto="/storage/${foto}"
            //         data-nama="${row.nama_obat}">
            //         <i class="fas fa-image"></i> Lihat Foto
            //     </button>
            // `;
            //         },
            //     },

            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
                        <button class="btn btn-info btn-sm btn-show" data-id="${id}">
                            <i class="fas fa-info-circle"></i> Info
                        </button>
                        <button class="btn btn-primary btn-sm btn-edit"
                                data-id="${id}"
                                data-nama="${row.nama_obat}"
                                data-supplier="${row.supplier_id}"
                                data-kemasan="${row.kemasan_id}"
                                data-satuan_kecil="${row.satuan_kecil_id}"
                                data-satuan_besar="${row.satuan_besar_id}"
                                data-aturanpakai="${row.aturanpakai_id}"
                                data-kategori="${row.kategori_id}"
                                data-metodepembayaran="${row.metodepembayaran_id}"
                                data-deskripsi_obat="${row.deskripsi_obat}"
                                data-stok="${row.stok}"
                                data-foto="${row.foto}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-danger btn-sm btn-delete" 
                                data-id="${id}" 
                                data-name="${row.nama_obat}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    `;
                },
            },
        ],
    });

    // ====== TAMBAH ======
    $(document).on("submit", "#formObat", function (e) {
        e.preventDefault();
        showLoader();
        let formData = new FormData(this);
        $.ajax({
            url: apiUrl,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                hideLoader();
                $("#modalObat").modal("hide");

                $(".modal-backdrop").remove();
                $("body").removeClass("modal-open");

                $("#formObat")[0].reset();

                Swal.fire(
                    "Berhasil!",
                    res.message ?? "Obat berhasil ditambahkan",
                    "success"
                );
                table.ajax.reload(null, false);
            },
            error: (xhr) => {
                hideLoader();
                let msg = "";
                $.each(
                    xhr.responseJSON?.errors ?? {},
                    (k, v) => (msg += v + "\n")
                );
                Swal.fire(
                    "Gagal!",
                    msg || (xhr.responseJSON?.message ?? "Terjadi kesalahan"),
                    "error"
                );
            },
        });
    });

    // Tampilkan foto di modal
    $(document).on("click", ".btn-foto", function () {
        let foto = $(this).data("foto");
        let nama = $(this).data("nama");

        $("#fotoPreview").attr("src", foto);
        $("#namaObatFoto").text(nama);
        $("#modalFoto").modal("show");
    });

    // ====== BUKA MODAL EDIT ======
    $(document).on("click", ".btn-edit", function () {
        $("#edit_id").val($(this).data("id"));
        $("#edit_nama_obat").val($(this).data("nama"));
        $("#edit_deskripsi_obat").val($(this).data("deskripsi_obat"));
        $("#edit_stok").val($(this).data("stok"));

        // Load semua dropdown edit dan set selected sesuai data
        loadDropdown(
            "/api/supplier",
            "edit_supplier_id",
            "nama_supplier",
            $(this).data("supplier")
        );
        loadDropdown(
            "/api/kemasan",
            "edit_kemasan_id",
            "nama_kemasan",
            $(this).data("kemasan")
        );
        loadDropdown(
            "/api/satuankecil",
            "edit_satuan_kecil_id",
            "nama_satuankecil",
            $(this).data("satuan_kecil")
        );
        loadDropdown(
            "/api/satuanbesar",
            "edit_satuan_besar_id",
            "nama_satuanbesar",
            $(this).data("satuan_besar")
        );
        loadDropdown(
            "/api/kategori",
            "edit_kategori_id",
            "nama_kategori",
            $(this).data("kategori")
        );
        loadDropdown(
            "/api/aturanpakai",
            "edit_aturanpakai_id",
            "frekuensi_pemakaian",
            $(this).data("aturanpakai")
        );
        loadDropdown(
            "/api/metodepembayaran",
            "edit_metodepembayaran_id",
            "nama_metode",
            $(this).data("metodepembayaran")
        );

        // Preview foto lama
        if ($(this).data("foto")) {
            $("#preview_edit_foto")
                .attr("src", "/storage/" + $(this).data("foto"))
                .removeClass("d-none");
        } else {
            $("#preview_edit_foto").addClass("d-none");
        }

        $("#modalEditObat").modal("show");
    });

    // ====== UPDATE ======
    $(document).on("submit", "#formEditObat", function (e) {
        e.preventDefault();
        const id = $("#edit_id").val();
        const nama = $("#edit_nama_obat").val();

        Swal.fire({
            title: "Konfirmasi Update",
            text: `Apakah kamu yakin ingin mengupdate data "${nama}"?`,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, update!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (!result.isConfirmed) return;

            showLoader();
            let formData = new FormData($("#formEditObat")[0]);

            $.ajax({
                url: "/api/obat/" + id,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { "X-HTTP-Method-Override": "PUT" },
                success: (res) => {
                    hideLoader();
                    $("#modalEditObat").modal("hide");
                    Swal.fire(
                        "Berhasil!",
                        res.message ?? `Data "${nama}" berhasil diupdate`,
                        "success"
                    );
                    table.ajax.reload(null, false);
                },
                error: (xhr) => {
                    hideLoader();
                    let msg = "";
                    $.each(
                        xhr.responseJSON?.errors ?? {},
                        (k, v) => (msg += v + "\n")
                    );
                    Swal.fire(
                        "Gagal!",
                        msg ||
                            (xhr.responseJSON?.message ?? "Terjadi kesalahan"),
                        "error"
                    );
                },
            });
        });
    });

    // ====== HAPUS ======
    $(document).on("click", ".btn-delete", function () {
        const id = $(this).data("id");
        const nama = $(this).data("name");

        Swal.fire({
            title: "Apakah kamu yakin?",
            text: `Data "${nama}" akan dihapus secara permanen!`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (!result.isConfirmed) return;

            showLoader();
            $.ajax({
                url: `${apiUrl}/${id}`,
                method: "DELETE",
                success: (res) => {
                    hideLoader();
                    Swal.fire(
                        "Berhasil!",
                        res.message ?? `Data "${nama}" berhasil dihapus`,
                        "success"
                    );
                    table.ajax.reload(null, false);
                },
                error: (xhr) => {
                    hideLoader();
                    Swal.fire(
                        "Gagal!",
                        xhr.responseJSON?.message ?? "Terjadi kesalahan",
                        "error"
                    );
                },
            });
        });
    });

    // import
    $("#formImport").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let url = $(this).data("url");

        $.ajax({
            url: importObatUrl,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                // munculkan loader
                $("#loader").fadeIn(200);
            },

            success: function (res) {
                $("#loader").fadeOut(200);
                $("#importModal").modal("hide");

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: res.message ?? "Data berhasil diimport!",
                    timer: 2000,
                }).then(() => {
                    table.ajax.reload(false);
                });
            },
            error: function (xhr) {
                $("#loader").fadeOut(200);

                if (xhr.status === 422) {
                    let pesan = xhr.responseJSON.message ?? "Validasi gagal.";

                    Swal.fire({
                        icon: "error",
                        title: "Import gagal!",
                        html: pesan,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Terjadi kesalahan!",
                        text:
                            xhr.responseJSON?.message ??
                            "Silakan coba Import ulang.",
                    });
                }
            },
        });
    });

    // ====== SHOW ======
    $(document).on("click", ".btn-show", function () {
        const id = $(this).data("id");

        window.location.href = `/obat/${id}`;
    });
});
