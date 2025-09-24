// Setup CSRF token agar semua request AJAX dikenali Laravel
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

// Fungsi untuk menampilkan loader
function showLoader() { $('#loader').fadeIn(200); }
// Fungsi untuk menyembunyikan loader
function hideLoader() { $('#loader').fadeOut(200); }

$(document).ready(function(){

  const apiUrl = "/api/metodepembayaran";   // Endpoint API Metode Pembayaran

  // Inisialisasi DataTables
  const table = $('#metodePembayaranTable').DataTable({
    processing: true,
    ajax: { url: apiUrl, dataSrc: "data" }, // Ambil data dari API
    columns: [
      { data: null, render: (d,t,r,m)=> m.row + 1 }, // Kolom nomor urut
      { data: "nama_metode" },                       // Nama metode pembayaran
      { data: "deskripsi" },                         // Deskripsi
      { 
        data: "id", orderable:false, searchable:false, 
        render: function(id, type, row){
          // Tombol aksi
          return `
            <button class="btn btn-info btn-sm btn-detail" data-id="${id}">
              <i class="fas fa-info-circle"></i> Detail
            </button>
            <button class="btn btn-primary btn-sm btn-edit"
                    data-id="${id}"
                    data-nama="${row.nama_metode}"
                    data-deskripsi="${row.deskripsi}">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm btn-delete"
                    data-id="${id}"
                    data-name="${row.nama_metode}">
              <i class="fas fa-trash"></i> Hapus
            </button>
          `;
      }}
    ]
  });

  // ====== TAMBAH DATA ======
  $(document).on('submit', '#form-metodepembayaran', function(e){
    e.preventDefault();
    showLoader();

    $.post(apiUrl, $(this).serialize())  // Kirim data baru (POST)
      .done(res => {
        hideLoader();
        $('#modalMetodePembayaran').modal('hide'); // Tutup modal
        $('#form-metodepembayaran')[0].reset();    // Reset form
        Swal.fire("Berhasil!", res.message ?? "Metode pembayaran berhasil ditambahkan", "success");
        table.ajax.reload(null, false);            // Reload tabel tanpa reset paging
      })
      .fail(xhr => {
        hideLoader();
        let msg = '';
        $.each(xhr.responseJSON?.errors ?? {}, (k,v)=> msg += v + '\n'); // Ambil error validasi
        Swal.fire("Gagal!", msg || (xhr.responseJSON?.message ?? "Terjadi kesalahan"), "error");
      });
  });

  // ====== BUKA MODAL EDIT ======
  $(document).on('click', '.btn-edit', function(){
    // Isi form edit dengan data dari tombol
    $('#edit_id').val($(this).data('id'));
    $('#edit_nama_metode').val($(this).data('nama'));
    $('#edit_deskripsi').val($(this).data('deskripsi'));
    $('#modalEditMetodePembayaran').modal('show');
  });

  // ====== UPDATE DATA ======
  $(document).on('submit', '#form-edit-metodepembayaran', function(e){
    e.preventDefault();
    const id   = $('#edit_id').val();
    const nama = $('#edit_nama_metode').val();

    // Konfirmasi update
    Swal.fire({
      title: 'Konfirmasi Update',
      text: `Apakah kamu yakin ingin mengupdate data "${nama}"?`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, update!',
      cancelButtonText: 'Batal'
    }).then(result => {
      if(!result.isConfirmed) return;

      showLoader();
      $.ajax({
        url: `${apiUrl}/${id}`,   // PUT ke API
        method: "PUT",
        data: $(this).serialize(),
        success: res => {
          hideLoader();
          $('#modalEditMetodePembayaran').modal('hide'); // Tutup modal
          Swal.fire("Berhasil!", res.message ?? `Data "${nama}" berhasil diupdate`, "success");
          table.ajax.reload(null, false);                // Reload tabel
        },
        error: xhr => {
          hideLoader();
          let msg = '';
          $.each(xhr.responseJSON?.errors ?? {}, (k,v)=> msg += v + '\n');
          Swal.fire("Gagal!", msg || (xhr.responseJSON?.message ?? "Terjadi kesalahan"), "error");
        }
      });
    });
  });

  // ====== DETAIL DATA ======
  $(document).on('click', '.btn-detail', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    showLoader();
    $.get("/api/metodepembayaran/" + id, function(res) {
        hideLoader();

        if (res.success) {
            // Isi data detail ke modal
            $('#detail_nama_metode').text(res.data.nama_metode);
            $('#detail_deskripsi').text(res.data.deskripsi);

            // Isi daftar obat (jika ada relasi dengan obat)
            let obats = res.data.obats || [];
            let html = "";
            if (obats.length > 0) {
                obats.forEach((obat, i) => {
                    html += `
                        <tr>
                          <td>${i + 1}</td>
                          <td>${obat.nama_obat}</td>
                        </tr>`;
                });
            } else {
                html = `<tr><td colspan="2" class="text-center text-muted">Belum ada obat</td></tr>`;
            }
            $("#detail_obats").html(html);

            $('#modalDetailMetodePembayaran').modal('show'); // Tampilkan modal
        } else {
            Swal.fire("Gagal!", res.message ?? "Data tidak ditemukan", "error");
        }
    }).fail(xhr => {
        hideLoader();
        Swal.fire("Error!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
    });
  });

  // ====== HAPUS DATA ======
  $(document).on('click', '.btn-delete', function(){
    const id   = $(this).data('id');
    const nama = $(this).data('name');

    Swal.fire({
      title: 'Apakah kamu yakin?',
      text: `Data "${nama}" akan dihapus secara permanen!`,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal'
    }).then(result => {
      if(!result.isConfirmed) return;

      showLoader();
      $.ajax({
        url: `${apiUrl}/${id}`,   // DELETE ke API
        method: "DELETE",
        success: res => {
          hideLoader();
          Swal.fire("Berhasil!", res.message ?? `Data "${nama}" berhasil dihapus`, "success");
          table.ajax.reload(null, false); // Reload tabel
        },
        error: xhr => {
          hideLoader();
          Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
        }
      });
    });
  });

  // ====== SHOW (redirect ke halaman detail Laravel Blade) ======
  $(document).on('click', '.btn-show', function(){
    const id = $(this).data('id');
    window.location.href = `/metodepembayaran/${id}`;
  });

});
