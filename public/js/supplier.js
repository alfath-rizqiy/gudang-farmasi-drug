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

$(document).ready(function () {
    const apiUrl = supplierApiUrl; // semua CRUD lewat API
    const table = $("#tabelSupplier").DataTable({
        processing: true,
        scrollX: true,
        ajax: { url: apiUrl, dataSrc: "data" },
        autoWidth: false,
        columns: [
            {
                data: null,
                render: (d, t, r, m) => m.row + 1,
                className: "text-center",
            }, // nomor urut
            { data: "nama_supplier" },
            { data: "telepon" },
            { data: "email" },
            { data: "alamat" },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function (id, type, row) {
                    return `
          <button class="btn btn-info btn-sm btn-show" data-id="${id}">
            <i class="fas fa-info-circle"></i> Detail
          </button>
          <button class="btn btn-primary btn-sm btn-edit" 
                 data-id="${id}"
                    data-nama="${row.nama_supplier}"
                    data-tlpn="${row.telepon}"
                    data-email="${row.email}"
                    data-alamat="${row.alamat}">
            <i class="fas fa-edit"></i> Edit
          </button>
          <button class="btn btn-danger btn-sm btn-delete" data-id="${id}" data-name="${row.nama_supplier}">
            <i class="fas fa-trash"></i> Hapus
          </button>
          `;
                },
            },
        ],
    });

    // ====== TAMBAH ======
    $(document).on("submit", "#formSupplier", function (e) {
        e.preventDefault();
        showLoader();
        $.post(apiUrl, $(this).serialize())
            .done((res) => {
                hideLoader();
                $("#modalSupplier").modal("hide");
                $("#formSupplier")[0].reset();
                Swal.fire(
                    "Berhasil!",
                    res.message ?? "Supplier berhasil ditambahkan",
                    "success"
                );
                table.ajax.reload(null, false);
            })
            .fail((xhr) => {
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
            });
    });

    // ====== BUKA MODAL EDIT ======
    $(document).on("click", ".btn-edit", function () {
        $("#edit_id").val($(this).data("id"));
        $("#edit_nama_supplier").val($(this).data("nama"));
        $("#edit_telepon").val($(this).data("tlpn"));
        $("#edit_email").val($(this).data("email"));
        $("#edit_alamat").val($(this).data("alamat"));
        $("#modalEditSupplier").modal("show");
    });

    // ====== UPDATE ======
    $(document).on("submit", "#formEditSupplier", function (e) {
        e.preventDefault();
        const id = $("#edit_id").val();
        const nama = $("#edit_nama_supplier").val();

        console.log("Update ke:", `${apiUrl}/${id}`);

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
            $.ajax({
                url: `${apiUrl}/${id}`,
                method: "PUT",
                data: $(this).serialize(),
                success: (res) => {
                    hideLoader();
                    $("#modalEditSupplier").modal("hide");
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
                        "Gagal Update!",
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

    // ====== SHOW ======
    $(document).on("click", ".btn-show", function (e) {
        e.preventDefault();
        let id = $(this).data("id");

        $.get(`${apiUrl}/${id}`, function (res) {
            if (!res.success) {
                Swal.fire(
                    "Gagal!",
                    res.message || "Data tidak ditemukan",
                    "error"
                );
                return;
            }

            const supplier = res.data; // ✅ ambil dari key data

            // tampilkan detail nama
            $("#detail_nama_supplier").text(supplier.nama_supplier);

            // daftar obat
            let rows = "";
            if (supplier.obats && supplier.obats.length > 0) {
                supplier.obats.forEach((obat, index) => {
                    rows += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${obat.nama_obat}</td>
                    </tr>
                `;
                });
            } else {
                rows = `<tr><td colspan="2" class="text-center">Belum ada obat</td></tr>`;
            }

            $("#detail_obat_list").html(rows);
            $("#modalDetailSupplier").modal("show");
        });
    });
});
