$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

function showLoader() { $('#loader').fadeIn(200); }
function hideLoader() { $('#loader').fadeOut(200); }

// Helper format number ribuan
function formatNumber(num) {
  if (num === null || num === undefined || num === "") return "0,00";
  return "Rp " + parseFloat(num).toLocaleString('id-ID', { minimumFractionDigits: 2 });
}

// Helper format tanggal ke "18-09-2025 12:50 WIB"
function formatDateToWIB(isoDateStr) {
  if (!isoDateStr) return '-';
  const date = new Date(isoDateStr);
  const options = {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    timeZone: 'Asia/Jakarta',
    hour12: false
  };
  return date.toLocaleString('id-ID', options).replace(',', '').replace(/\//g, '-') + ' WIB';
}

$(document).ready(function () {
  const apiUrl = "/api/harga";

  const table = $('#hargaTable').DataTable({
    processing: true,
    ajax: { url: apiUrl, dataSrc: "data" },
    columns: [
      { data: null, render: (d, t, r, m) => m.row + 1 },
      { data: "obat.nama_obat" },
      { data: "harga_jual", render: d => formatNumber(d) },
      ...(userRole === "admin" || userRole === "petugas" ? [
        { data: "harga_pokok", render: d => formatNumber(d) },
        { data: "margin", render: d => formatNumber(d) },
        { data: "updated_at", render: d => formatDateToWIB(d) }
      ] : []),
      {
        data: "id",
        render: function (id, type, row) {
          let buttons = `
            <button class="btn btn-info btn-sm btn-detail" data-id="${id}">
              <i class="fas fa-info-circle"></i> Detail
            </button>
          `;
          if (userRole === "admin") {
            buttons += `
              <button class="btn btn-primary btn-sm btn-edit" 
                      data-id="${id}"
                      data-obat="${row.obat.id}"
                      data-hp="${row.harga_pokok}"
                      data-m="${row.margin}">
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
        }
      }
    ]
  });

  // ====== TAMBAH ======
  $(document).on('submit', '#form-harga', function (e) {
    e.preventDefault();
    showLoader();
    $.post(apiUrl, $(this).serialize())
      .done(res => {
        hideLoader();
        $('#modalHarga').modal('hide');
        $('#form-harga')[0].reset();
        Swal.fire("Berhasil!", res.message ?? "Harga berhasil ditambahkan", "success");
        table.ajax.reload(null, false);
      })
      .fail(xhr => {
        hideLoader();
        Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
      });
  });

  // ====== BUKA MODAL EDIT ======
  $(document).on('click', '.btn-edit', function () {
    $('#edit_id').val($(this).data('id'));
    $('#edit_obat_id').val($(this).data('obat'));
    $('#edit_harga_pokok').val($(this).data('hp'));
    $('#edit_margin').val($(this).data('m'));
    $('#edit_harga_jual').val(parseFloat($(this).data('hp')) + parseFloat($(this).data('m')));
    $('#editModalHarga').modal('show');
  });

  // ====== UPDATE ======
  $(document).on('submit', '#form-edit-harga', function (e) {
    e.preventDefault();
    const id = $('#edit_id').val();
    showLoader();
    $.ajax({
      url: `${apiUrl}/${id}`,
      method: "PUT",
      data: $(this).serialize(),
      success: res => {
        hideLoader();
        $('#editModalHarga').modal('hide');
        Swal.fire("Berhasil!", res.message ?? "Data berhasil diupdate", "success");
        table.ajax.reload(null, false);
      },
      error: xhr => {
        hideLoader();
        Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
      }
    });
  });

  // ====== HAPUS ======
  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    const nama = $(this).data('name');
    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: `Harga obat "${nama}" akan dihapus!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then(result => {
      if (!result.isConfirmed) return;
      showLoader();
      $.ajax({
        url: `${apiUrl}/${id}`,
        method: "DELETE",
        success: res => {
          hideLoader();
          Swal.fire("Berhasil!", res.message ?? "Data dihapus", "success");
          table.ajax.reload(null, false);
        },
        error: xhr => {
          hideLoader();
          Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
        }
      });
    });
  });

  // ====== DETAIL ======
  $(document).on('click', '.btn-detail', function () {
  const id = $(this).data('id');
  showLoader();
  $.get(`${apiUrl}/${id}`, function (res) {
    hideLoader();

    let html = '';
    res.riwayat.forEach((h, i) => {
      html += `
        <tr>
          <td>${i + 1}</td>
          <td>${formatNumber(h.harga_pokok)}</td>
          <td>${formatNumber(h.margin)}</td>
          <td>${formatNumber(h.harga_jual)}</td>
          <td>${formatDateToWIB(h.updated_at)}</td>
        </tr>
      `;
    });

    $("#detail_nama_obat").text(res.obat.nama_obat);
    $("#detailRiwayat").html(html);

    $("#modalDetailHarga").modal("show");
  }).fail(xhr => {
    hideLoader();
    Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Data tidak ditemukan", "error");
  });
});
});