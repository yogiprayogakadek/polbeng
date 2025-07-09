<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label" for="Status"> Status Pegawai : <span class="danger">*</span>
                </label>
                <select name="status_pegawai" id="status_pegawai" class="form-control">
                    <option value="semua">Semua status (Aktif & Tidak)</option>
                    <option value="1">Aktif</option>
                    <option value="0">Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    $('.btn-cetak').on('click', function(e) {
        e.preventDefault();
        let kategori = localStorage.getItem('kategori-cetak')
        console.log(kategori)

        let token = $('meta[name=csrf-token]').attr('content')
        let form = new FormData($('#formPrint')[0]);
        form.append('_token', token)
        form.append('kategori', kategori)

        showPrintLoader();

        $.ajax({
            url: "{{ route('laporan.cetak') }}",
            method: 'POST',
            data: form,
            processData: false,
            contentType: false,
            xhrFields: {
                responseType: 'blob' // Penting untuk file binary
            },
            success: function(response) {
                let blob = new Blob([response], {
                    type: 'application/pdf'
                });
                let link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = "laporan.pdf";
                link.click();
                // localStorage.clear()
                hidePrintLoader();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                Swal.fire('Error', 'Gagal generate PDF', 'error');

                hidePrintLoader();
            }
        });

    });
</script>
