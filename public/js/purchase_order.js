$(document).ready(function () {

    // 🔹 Inisialisasi DataTable
    let table = $('#tablePO').DataTable({
        ajax: {
            url: '/api/purchase-orders',
            data: function (d) {
                d.supplier_id = $('#filterSupplier').val();
                d.tanggal_mulai = $('#tanggalMulai').val();
                d.tanggal_selesai = $('#tanggalSelesai').val();
            },
            dataSrc: 'data'
        },
        columns: [
            { data: null, render: (d, t, r, m) => m.row + 1 },
            { data: 'nomor_po' },
            { data: 'tgl_po' },
            { data: 'tgl_kirim' },
            { data: 'top' },
            { data: 'tgl_jatuh_tempo' },
            { data: 'supplier' },
            { data: 'total', className: 'text-end' },
            {
                data: 'status',
                render: function (data) {
                    let color = data === 'OPEN' ? 'success' : 'secondary';
                    return `<span class="badge bg-${color}">${data}</span>`;
                }
            },
            { data: 'valid_user' },
            {
                data: 'id',
                className: 'text-center',
                render: function (id) {
                    return `
                        <button class="btn btn-sm btn-success" title="Lihat"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                    `;
                }
            }
        ]
    });

    // 🔹 Tombol Cari (reload data)
    $('#btnCari').on('click', function () {
        table.ajax.reload();
    });

    // 🔹 Load Supplier Dropdown
    $.getJSON('/api/suppliers', function (res) {
        $.each(res.data, function (_, supplier) {
            $('#filterSupplier').append(`<option value="${supplier.id}">${supplier.nama_supplier}</option>`);
        });
    });

});
