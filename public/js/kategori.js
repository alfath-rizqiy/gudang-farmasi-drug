// Setup CSRF token untuk semua request AJAX (wajib di Laravel)
$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

// Fungsi untuk menampilkan loader
function showLoader(){ $('#loader').fadeIn(200); }
// Fungsi untuk menyembunyikan loader
function hideLoader(){ $('#loader').fadeOut(200); }

$(document).ready(function(){

  const apiUrl = "/api/kategori";   // Endpoint API kategori

  // Inisialisasi DataTables
  const table = $('#dataTable').DataTable({
    processing: true,
    ajax: { url: apiUrl, dataSrc: "data" }, // load data dari API
    columns: [
      { data: null, render: (d,t,r,m)=> m.row + 1 }, // Kolom nomor urut
      { data: "nama_kategori" },                     // Kolom nama kategori
      { data: "deskripsi" },                         // Kolom deskripsi
      { 
        data: "id", orderable:false, searchable:false, 
        render: function(id, type, row){
          // Kolom aksi (detail, edit, hapus)
          return `
            <button class="btn btn-info btn-sm btn-detail" data-id="${id}">
              <i class="fas fa-info-circle"></i> Detail
            </button>
            <button class="btn btn-primary btn-sm btn-edit" 
                    data-id="${id}"
                    data-nama="${row.nama_kategori}"
                    data-deskripsi="${row.deskripsi}">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm btn-delete" 
                    data-id="${id}" 
                    data-name="${row.nama_kategori}">
              <i class="fas fa-trash"></i> Hapus
            </button>
          `;
      }}
    ]
  });

  // ====== TAMBAH DATA ======
  $(document).on('submit', '#form-kategori', function(e){
    e.preventDefault();
    showLoader();

    // Kirim data kategori baru ke API (POST)
    $.post(apiUrl, $(this).serialize())
      .done(res => {
        hideLoader();
        $('#modalKategori').modal('hide');    // Tutup modal
        $('#form-kategori')[0].reset();       // Reset form
        Swal.fire("Berhasil!", res.message ?? "Kategori berhasil ditambahkan", "success");
        table.ajax.reload(null, false);       // Reload DataTables
      })
      .fail(xhr => {
        hideLoader();
        let msg = '';
        $.each(xhr.responseJSON?.errors ?? {}, (k,v)=> msg += v + '\n'); // Ambil pesan error validasi
        Swal.fire("Gagal!", msg || (xhr.responseJSON?.message ?? "Terjadi kesalahan"), "error");
      });
  });

  // ====== BUKA MODAL EDIT ======
  $(document).on('click', '.btn-edit', function(){
    // Isi form edit dengan data dari tombol edit
    $('#edit_id').val($(this).data('id'));
    $('#edit_nama_kategori').val($(this).data('nama'));
    $('#edit_deskripsi').val($(this).data('deskripsi'));
    $('#modalEditKategori').modal('show');
  });

  // ====== UPDATE DATA ======
  $(document).on('submit', '#form-edit-kategori', function(e){
    e.preventDefault();
    const id   = $('#edit_id').val();
    const nama = $('#edit_nama_kategori').val();

    // Konfirmasi sebelum update
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
      // Kirim request PUT ke API
      $.ajax({
        url: `${apiUrl}/${id}`,
        method: "PUT",
        data: $(this).serialize(),
        success: res => {
          hideLoader();
          $('#modalEditKategori').modal('hide');  // Tutup modal
          Swal.fire("Berhasil!", res.message ?? `Data "${nama}" berhasil diupdate`, "success");
          table.ajax.reload(null, false);        // Reload tabel
        },
        error: xhr => {
          hideLoader();
          let msg = '';
          $.each(xhr.responseJSON?.errors ?? {}, (k,v)=> msg += v + '\n'); // Ambil pesan error validasi
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

    // Ambil detail kategori dari API (GET)
    $.get("/api/kategori/" + id, function(res) {
        hideLoader();

        if (res.success) {
            // Isi data detail kategori ke modal
            $('#detail_nama_kategori').text(res.data.nama_kategori);
            $('#detail_deskripsi').text(res.data.deskripsi);

            // Isi daftar obat terkait kategori
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

            $('#modalDetailKategori').modal('show'); // Tampilkan modal
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

    // Konfirmasi sebelum hapus
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
      // Kirim request DELETE ke API
      $.ajax({
        url: `${apiUrl}/${id}`,
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
    // Redirect ke halaman detail (non-API)
    window.location.href = `/kategori/${id}`;
  });

});
