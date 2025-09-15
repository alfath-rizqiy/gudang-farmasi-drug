$(document).ready(function () {
    $("#formProfile").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $("#formProfile").attr("action"), // route PATCH profile
            type: "POST", // tetap POST karena ada @method('patch')
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (response) {
                $("#loader").hide();

                Swal.fire({
                    icon: "success",
                    title: "Berhasil",
                    text: "Profile berhasil diperbarui",
                    timer: 1500,
                    showConfirmButton: false,
                }).then(() => {
                    // Refresh halaman biar foto langsung update
                    location.reload();
                });
            },
            error: function (xhr) {
                $("#loader").hide();

                let errMsg = "Terjadi kesalahan, coba lagi.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: "error",
                    title: "Gagal",
                    text: errMsg,
                });
            },
        });
    });
});
