<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="start_date"> Start Date : <span class="danger">*</span>
                </label>
                <input type="date" class="form-control required" name="start_date" id="start_date" />
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label" for="end_date"> End Date : <span class="danger">*</span>
                </label>
                <input type="date" class="form-control required" name="end_date" id="end_date" />
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label" for="end_date"> Pegawai : <span class="danger">*</span>
                </label>
                <select name="pegawai" id="pegawai" class="form-control">
                    @foreach ($pegawai as $id => $nama)
                        <option value="{{ $id }}">{{ $nama }}</option>
                    @endforeach
                </select>
                <label class="text-info small" style="">Boleh dikosongkan.</label>
            </div>
        </div>
    </div>
</div>

<script>
    $('.btn-cetak').on('click', function(e) {
        e.preventDefault();
        let start = $('#start_date').val();
        let end = $('#end_date').val();
        let kategori = localStorage.getItem('kategori-cetak')

        if (kategori == 'absensi') {
            if (!start || !end) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal wajib diisi',
                    text: 'Silakan isi tanggal mulai dan tanggal akhir.'
                });
                return;
            }

            if (start > end) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tanggal tidak valid',
                    text: 'Tanggal mulai tidak boleh lebih besar dari tanggal akhir.'
                });
                return;
            }
        }

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
