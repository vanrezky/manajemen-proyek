<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Proyek</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Detail Proyek</div>
            </div>
        </div>
        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4>Detail Data Proyek</h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('proyek'); ?>" class="btn btn-primary">
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Proyek</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['nama']; ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">No SPK</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['no_spk']; ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Alamat</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['alamat']; ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Mulai Proyek - Selesai</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= tanggal($data['mulai']); ?> >>> <?= tanggal($data['selesai']); ?></b></label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nilai Kontrak</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= rupiah($data['nilai_kontrak']); ?></b></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Status</label>
                        <div class="col-sm-9">
                            <label class="col-form-label"><b><?= $data['status']; ?></b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>