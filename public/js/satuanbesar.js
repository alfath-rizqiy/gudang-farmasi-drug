$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

function showLoader() { $('#loader').fadeIn(200); }
function hideLoader() { $('#loader').fadeOut(200); }

$(document).ready(function(){

  const apiUrl = "/api/satuanbesar";   // endpoint API
  const table = $('#satuanbesarTable').DataTable({
    processing: true,
    ajax: { url: apiUrl, dataSrc: "data" },
    columns: [
      { data: null, render: (d,t,r,m)=> m.row + 1 }, // nomor urut
      { data: "nama_satuanbesar" },
      { data: "deskripsi" },
      { data: "jumlah_satuankecil" },
      { data: "id", orderable:false, searchable:false, render: function(id, type, row){
          return `
            <button class="btn btn-info btn-sm btn-detail" data-id="${id}">
              <i class="fas fa-info-circle"></i> Detail
            </button>
            <button class="btn btn-primary btn-sm btn-edit"
                    data-id="${id}"
                    data-nama="${row.nama_satuanbesar}"
                    data-deskripsi="${row.deskripsi}"
                    data-jumlah="${row.jumlah_satuankecil}">
              <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-danger btn-sm btn-delete"
                    data-id="${id}"
                    data-name="${row.nama_satuanbesar}">
              <i class="fas fa-trash"></i> Hapus
            </button>
          `;
      }}
    ]
  });

  // ====== TAMBAH ======
  $(document).on('submit', '#form-satuanbesar', function(e){
    e.preventDefault();
    showLoader();
    $.post(apiUrl, $(this).serialize())
      .done(res => {
        hideLoader();
        $('#modalSatuanBesar').modal('hide');
        $('#form-satuanbesar')[0].reset();
        Swal.fire("Berhasil!", res.message ?? "Satuan besar berhasil ditambahkan", "success");
        table.ajax.reload(null, false);
      })
      .fail(xhr => {
        hideLoader();
        let msg = '';
        $.each(xhr.responseJSON?.errors ?? {}, (k,v)=> msg += v + '\n');
        Swal.fire("Gagal!", msg || (xhr.responseJSON?.message ?? "Terjadi kesalahan"), "error");
      });
  });

  // ====== BUKA MODAL EDIT ======
  $(document).on('click', '.btn-edit', function(){
    $('#edit_id').val($(this).data('id'));
    $('#edit_nama_satuanbesar').val($(this).data('nama'));
    $('#edit_deskripsi').val($(this).data('deskripsi'));
    $('#edit_jumlah_satuankecil').val($(this).data('jumlah'));
    $('#modalEditSatuanBesar').modal('show');
  });

  // ====== UPDATE ======
  $(document).on('submit', '#form-edit-satuanbesar', function(e){
    e.preventDefault();
    const id   = $('#edit_id').val();
    const nama = $('#edit_nama_satuanbesar').val();

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
        url: `${apiUrl}/${id}`,
        method: "PUT",
        data: $(this).serialize(),
        success: res => {
          hideLoader();
          $('#modalEditSatuanBesar').modal('hide');
          Swal.fire("Berhasil!", res.message ?? `Data "${nama}" berhasil diupdate`, "success");
          table.ajax.reload(null, false);
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

    // ====== DETAIL ======
$(document).on('click', '.btn-detail', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    showLoader();

    $.get("/api/satuanbesar/" + id, function(res) {
        hideLoader();

        if (res.success) {
            $('#detail_nama_satuanbesar').text(res.data.nama_satuanbesar);
            $('#detail_deskripsi').text(res.data.deskripsi);
            $('#detail_jumlah_satuankecil').text(res.data.jumlah_satuankecil);

            // isi daftar obat
            let obats = res.data.obats;
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

            $('#modalDetailSatuanBesar').modal('show');
        } else {
            Swal.fire("Gagal!", res.message ?? "Data tidak ditemukan", "error");
        }
    }).fail(xhr => {
        hideLoader();
        Swal.fire("Error!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
    });
});

  // ====== HAPUS ======
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
        url: `${apiUrl}/${id}`,
        method: "DELETE",
        success: res => {
          hideLoader();
          Swal.fire("Berhasil!", res.message ?? `Data "${nama}" berhasil dihapus`, "success");
          table.ajax.reload(null, false);
        },
        error: xhr => {
          hideLoader();
          Swal.fire("Gagal!", xhr.responseJSON?.message ?? "Terjadi kesalahan", "error");
        }
      });
    });
  });

  // ====== SHOW ======
  $(document).on('click', '.btn-show', function(){
    const id = $(this).data('id');
    window.location.href = `/satuanbesar/${id}`;
  });

});