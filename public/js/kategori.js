$.ajaxSetup({
  headers: {
    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
  }
});

function showLoader(){ $('#loader').fadeIn(200); }
function hideLoader(){ $('#loader').fadeOut(200); }

$(document).ready(function(){

  const apiUrl = "/api/kategori";   // API endpoint
  const table = $('#dataTable').DataTable({
    processing: true,
    ajax: { url: apiUrl, dataSrc: "data" },
    columns: [
      { data: null, render: (d,t,r,m)=> m.row + 1 }, // nomor urut
      { data: "nama_kategori" },
      { data: "deskripsi" },
      { data: "id", orderable:false, searchable:false, render: function(id, type, row){
          return `
            <button class="btn btn-info btn-sm btn-show" data-id="${id}">
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

  // ====== TAMBAH ======
  $(document).on('submit', '#form-kategori', function(e){
    e.preventDefault();
    showLoader();
    $.post(apiUrl, $(this).serialize())
      .done(res => {
        hideLoader();
        $('#modalKategori').modal('hide');
        $('#form-kategori')[0].reset();
        Swal.fire("Berhasil!", res.message ?? "Kategori berhasil ditambahkan", "success");
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
    $('#edit_nama_kategori').val($(this).data('nama'));
    $('#edit_deskripsi').val($(this).data('deskripsi'));
    $('#modalEditKategori').modal('show');
  });

  // ====== UPDATE ======
  $(document).on('submit', '#form-edit-kategori', function(e){
    e.preventDefault();
    const id   = $('#edit_id').val();
    const nama = $('#edit_nama_kategori').val();

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
          $('#modalEditKategori').modal('hide');
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
    window.location.href = `/kategori/${id}`;
  });

});
