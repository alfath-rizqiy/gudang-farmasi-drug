// ====== Setup CSRF Token untuk semua AJAX request ======
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// ====== Fungsi Loader (menampilkan animasi loading saat proses AJAX) ======
function showLoader() {
    $("#loader").fadeIn(200);
}
function hideLoader() {
    $("#loader").fadeOut(200);
}

// ====== Helper untuk format angka jadi Rupiah (contoh: Rp 20.000,00) ======
function formatNumber(num) {
    if (num === null || num === undefined || num === "") return "0,00";
    return (
        "Rp " +
        parseFloat(num).toLocaleString("id-ID", { minimumFractionDigits: 2 })
    );
}

// ====== Helper untuk ubah format tanggal ke WIB ======
// contoh output: 12-10-2025 16:51 WIB
function formatDateToWIB(isoDateStr) {
    if (!isoDateStr) return "-";
    const date = new Date(isoDateStr);
    const options = {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        timeZone: "Asia/Jakarta",
        hour12: false,
    };
    return (
        date
            .toLocaleString("id-ID", options)
            .replace(",", "")
            .replace(/\//g, "-") + " WIB"
    );
}

// ====== Ketika dokumen sudah siap dijalankan ======
$(document).ready(function () {
    const apiUrl = "/api/harga"; // URL endpoint API harga

    // ====== Inisialisasi DataTable untuk menampilkan daftar harga ======
    const table = $("#hargaTable").DataTable({
        processing: true,
        ajax: { url: apiUrl, dataSrc: "data" }, // ambil data dari API
        columns: [
            // Kolom nomor urut otomatis
            {
                data: null,
                render: (d, t, r, m) => m.row + 1,
                className: "text-center",
            },
            // Nama obat
            { data: "obat.nama_obat" },
            // Harga jual (ditampilkan dalam format Rupiah)
            { data: "harga_jual", render: (d) => formatNumber(d) },

            // Jika role user adalah admin/petugas, tampilkan kolom tambahan
            ...(userRole === "admin" || userRole === "petugas"
                ? [
                      { data: "harga_pokok", render: (d) => formatNumber(d) },
                      { data: "margin", render: (d) => formatNumber(d) },
                      { data: "ppn", render: (d) => formatNumber(d) }, // Kolom PPN
                      {
                          data: "created_at",
                          render: function (data) {
                              // Format tanggal dibuat lebih mudah dibaca
                              let date = new Date(data);
                              let months = [
                                  "Jan",
                                  "Feb",
                                  "Mar",
                                  "Apr",
                                  "Mei",
                                  "Jun",
                                  "Jul",
                                  "Agu",
                                  "Sep",
                                  "Okt",
                                  "Nov",
                                  "Des",
                              ];
                              let day = String(date.getDate()).padStart(2, "0");
                              let month = months[date.getMonth()];
                              let year = date.getFullYear();
                              let hours = String(date.getHours()).padStart(2, "0");
                              let minutes = String(date.getMinutes()).padStart(2, "0");

                              return `${day} ${month} ${year}, ${hours}:${minutes}`;
                          },
                      },
                  ]
                : []),
            // Kolom tombol aksi (Detail, Edit, Hapus)
            {
                data: "id",
                render: function (id, type, row) {
                    // Tombol detail (semua user bisa lihat)
                    let buttons = `
                        <button class="btn btn-info btn-sm btn-detail" data-id="${id}">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                    `;
                    // Tombol Edit & Hapus hanya muncul untuk admin
                    if (userRole === "admin") {
                        buttons += `
                            <button class="btn btn-primary btn-sm btn-edit" 
                                data-id="${id}"
                                data-obat="${row.obat.id}"
                                data-hp="${row.harga_pokok}"
                                data-m="${row.margin}"
                                data-ppn="${row.ppn}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button class="btn btn-danger btn-sm btn-delete" 
                                data-id="${id}" 
                                data-name="${row.obat.nama_obat}">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        `;
                    }
                    return buttons;
                },
            },
        ],
    });

    // ====== TAMBAH DATA HARGA ======
    $(document).on("submit", "#form-harga", function (e) {
        e.preventDefault();
        showLoader(); // tampilkan loading
        $.post(apiUrl, $(this).serialize())
            .done((res) => {
                hideLoader();
                $("#modalHarga").modal("hide");
                $("#form-harga")[0].reset();
                Swal.fire("Berhasil!", res.message ?? "Harga berhasil ditambahkan", "success");
                table.ajax.reload(null, false); // reload tabel tanpa reset halaman
            })
            .fail((xhr) => {
                hideLoader();
                Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
            });
    });

    // ====== BUKA MODAL EDIT ======
    $(document).on("click", ".btn-edit", function () {
        // Ambil data dari tombol edit dan isi ke form edit
        $("#edit_id").val($(this).data("id"));
        $("#edit_obat_id").val($(this).data("obat"));
        $("#edit_harga_pokok").val($(this).data("hp"));
        $("#edit_margin").val($(this).data("m"));
        $("#edit_harga_jual").val(
            parseFloat($(this).data("hp")) + parseFloat($(this).data("m"))
        );
        $("#editModalHarga").modal("show");
    });

    // ====== UPDATE DATA HARGA ======
    $(document).on("submit", "#form-edit-harga", function (e) {
        e.preventDefault();
        const id = $("#edit_id").val();
        showLoader();
        $.ajax({
            url: `${apiUrl}/${id}`,
            method: "PUT",
            data: $(this).serialize(),
            success: (res) => {
                hideLoader();
                $("#editModalHarga").modal("hide");
                Swal.fire("Berhasil!", res.message ?? "Data berhasil diupdate", "success");
                table.ajax.reload(null, false);
            },
            error: (xhr) => {
                hideLoader();
                Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
            },
        });
    });

    // ====== HAPUS DATA HARGA ======
    $(document).on("click", ".btn-delete", function () {
        const id = $(this).data("id");
        const nama = $(this).data("name");
        // Konfirmasi sebelum hapus
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: `Harga obat "${nama}" akan dihapus!`,
            icon: "warning",
            showCancelButton: true,
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
                    Swal.fire("Berhasil!", res.message ?? "Data dihapus", "success");
                    table.ajax.reload(null, false);
                },
                error: (xhr) => {
                    hideLoader();
                    Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
                },
            });
        });
    });

    // ====== DETAIL DATA HARGA ======
    $(document).on("click", ".btn-detail", function () {
        const id = $(this).data("id");
        showLoader();
        $.get(`${apiUrl}/${id}`, function (res) {
            hideLoader();

            // Buat isi tabel riwayat harga secara dinamis
            let html = "";
            res.riwayat.forEach((h, i) => {
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${formatNumber(h.harga_pokok)}</td>
                        <td>${formatNumber(h.margin)}</td>
                        <td>${formatNumber(h.ppn ?? h.harga_pokok * 0.11)}</td>
                        <td>${formatNumber(h.harga_jual)}</td>
                        <td>${formatDateToWIB(h.updated_at)}</td>
                    </tr>
                `;
            });

            // Isi data ke dalam modal detail
            $("#detail_nama_obat").text(res.obat.nama_obat);
            $("#detailRiwayat").html(html);

            // Tampilkan modal
            $("#modalDetailHarga").modal("show");
        }).fail((xhr) => {
            hideLoader();
            Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Data tidak ditemukan", "error");
        });
    });
});
