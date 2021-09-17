<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Validasi SPJ</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Validasi SPJ</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Validasi SPJ</h4>
                </div>
                <div class="card-body">
                    <h5>Detail Proyek</h5>
                    <table class="table table-sm">
                        <?php

                        foreach ($data['proyek'] as $key => $value) {
                            echo "<tr>";
                            echo "<td width='30%'>$key</td>";
                            echo "<td>$value</td>";

                            echo "</tr>";
                        }; ?>

                    </table>
                    <h5>Vendor Pelaksana</h5>
                    <table class="table table-sm">
                        <?php

                        foreach ($data['vendor'] as $key => $value) {
                            echo "<tr>";
                            echo "<td width='30%'>$key</td>";
                            echo "<td>$value</td>";

                            echo "</tr>";
                        }; ?>

                    </table>

                    <h5>Surat Pesanan Jasa (SPJ)</h5>
                    <table class="table table-sm">
                        <?php

                        foreach ($data['spj'] as $key => $value) {
                            echo "<tr>";
                            echo "<td width='30%'>$key</td>";
                            echo "<td>$value</td>";

                            echo "</tr>";
                        }; ?>

                    </table>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary mr-1 btn-validasi" data-link="<?= base_url('validasi_spj/setuju/' . $data['id_proyek_vendor']); ?>" type="button">Validasi</button>
                    <a class="btn btn-warning" href="<?= base_url('validasi_spj'); ?>">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>
<?= csrf_field('csrf_protection'); ?>
<script>
    $('.btn-validasi').click(function(e) {
        e.preventDefault();

        let btn = $(this);
        let csrf = $('#csrf_protection');

        Swal.fire({
            title: "Konfirmasi Ulang",
            text: "Yakin Validasi SPJ?",
            icon: "warning",
            showCancelButton: true,
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    type: "post",
                    url: btn.data('link'),
                    dataType: "json",
                    data: csrf.attr('name') + "=" + csrf.attr('value'),
                    beforeSend: function() {
                        $(btn).addClass("disabled");
                    },
                    complete: function() {
                        $(btn).removeClass("disabled");
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire("Sukses..", response.message, "success").then(() => {
                                location.href = BASEURL + 'validasi_spj'
                            });
                        } else {
                            Swal.fire("Opps..", response.message, "error");
                        }
                    },
                });
            }
        });
    });
</script>