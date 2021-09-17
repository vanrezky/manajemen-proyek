<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> Kas Masuk</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> Kas Masuk</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('kas_masuk/' . ($empty ? 'save' : 'update/' . $data['id_kas_masuk'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data Kas Masuk</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="id_proyek">Pilih Proyek</label>
                            <select class="form-control" id="id_proyek" name="id_proyek" required>
                                <option value="">Pilih Proyek</option>
                                <?php

                                foreach ($proyek as $key => $value) {
                                    $s = isset($data['id_proyek']) ? ($data['id_proyek'] == $value['id_proyek'] ? 'selected' : '') : '';
                                    echo "<option $s value='$value[id_proyek]'>" . $value['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Kas Masuk</label>
                            <input type="text" class="form-control" name="jumlah" id="jumlah" value="<?= isset($data['jumlah']) ? $data['jumlah'] : ''; ?>" required>
                            <div class="invalid-feedback feedjumlah"></div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" value="<?= isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?>" id="deskripsi">
                            <div class="invalid-feedback feeddeskripsi"></div>
                        </div>
                        <div class="form-group">
                            <label for="tgl_kas_masuk">Tanggal Kas Masuk</label>
                            <input type="date" class="form-control" name="tgl_kas_masuk" value="<?= isset($data['tgl_kas_masuk']) ? $data['tgl_kas_masuk'] : date('Y-m-d'); ?>" id="tgl_kas_masuk">
                            <div class="invalid-feedback feedtgl_kas_masuk"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('kas_masuk'); ?>">Kembali</a>
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
                            window.location = "<?= base_url('kas_masuk'); ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                        error_message(response.errors);
                    }
                }
            });

        });
    });
</script>