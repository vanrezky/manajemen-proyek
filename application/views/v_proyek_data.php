<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> Proyek</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> Proyek</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('proyek/' . ($empty ? 'save' : 'update/' . $data['id_proyek'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data Proyek</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nama">Nama Proyek</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($data['nama']) ? $data['nama'] : ''; ?>" required autofocus>
                            <div class="invalid-feedback feednama"></div>

                        </div>
                        <div class="form-group">
                            <label for="no_spk">No. SPK</label>
                            <input type="text" class="form-control" name="no_spk" value="<?= isset($data['no_spk']) ? $data['no_spk'] : ''; ?>" id="no_spk">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= isset($data['alamat']) ? $data['alamat'] : ''; ?>" id="alamat" required>
                            <div class="invalid-feedback feedalamat"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mulai">Mulai Proyek</label>
                                    <input type="date" class="form-control" name="mulai" value="<?= isset($data['mulai']) ? $data['mulai'] : ''; ?>" id="mulai" required>
                                    <div class="invalid-feedback feedmulai"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="selesai">Selesai Proyek</label>
                                    <input type="date" class="form-control" name="selesai" value="<?= isset($data['selesai']) ? $data['selesai'] : ''; ?>" id="selesai" required>
                                    <div class="invalid-feedback feedselesai"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nilai_kontrak">Nilai Kontrak</label>
                            <input type="number" class="form-control" name="nilai_kontrak" value="<?= isset($data['nilai_kontrak']) ? $data['nilai_kontrak'] : ''; ?>" id="nilai_kontrak" required>
                            <div class="invalid-feedback feednilai_kontrak"></div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status Proyek</label>
                            <select class="form-control" name="status" id="status">
                                <?php
                                foreach (['aktif', 'selesai'] as $key => $value) {
                                    $s = isset($data['status']) ? ($data['status'] == $value ? 'selected' : '') : '';
                                    echo "<option $s value='$value'>" . ucwords($value) . "</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback feedstatus"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('proyek'); ?>">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {

        $("#form-submit").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(response) {

                    if (response.csrf) {
                        $("#csrf_protection").val(response.csrf);
                    }

                    if (response.success) {
                        Swal.fire("Sukess..", response.message, 'success').then(() => {
                            window.location = "<?= base_url('proyek'); ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                    }
                }
            });

        });
    });
</script>