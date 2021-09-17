<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Histori SPJ</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Histori SPJ</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Histori SPJ</h4>
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
                    <a class="btn btn-warning" href="<?= base_url('histori_spj'); ?>">Kembali</a>
                </div>
            </div>
        </div>
    </section>
</div>