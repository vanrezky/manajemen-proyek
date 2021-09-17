<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pembelian barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Detail Pembelian barang</div>
            </div>
        </div>
        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Detail Pembelian Barang</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('beli_barang'); ?>" class="btn btn-primary">
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['nama_proyek']; ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Suplier</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['nama_suplier']; ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Beli Barang</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= tanggal($data['tgl_beli_barang']); ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Deskripsi</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= tanggal($data['deskripsi']); ?></b></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Total Pembelian</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= rupiah($data['grand_total']); ?></b></label>
                        </div>
                    </div>
                    <h4>Detail Pembelian Barang</h4>
                    <table class="table table-bordered">
                        <thead>

                            <tr>
                                <td>Nama Barang</td>
                                <td>Satuan</td>
                                <td>Jumlah (qty)</td>
                                <td>Harga</td>
                                <td>Total</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            if (!empty($detail)) {
                                foreach ($detail as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>$value[nama]</td>";
                                    echo "<td>$value[satuan]</td>";
                                    echo "<td>$value[qty]</td>";
                                    echo "<td>" . rupiah($value['harga']) . "</td>";
                                    echo "<td>" . rupiah($value['total']) . "</td>";
                                    echo "</tr>";
                                }
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>