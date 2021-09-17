<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> Suplier</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> Suplier</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('suplier/' . ($empty ? 'save' : 'update/' . $data['id_suplier'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data Suplier</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="nama">Nama Suplier</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($data['nama']) ? $data['nama'] : ''; ?>" required autofocus>
                            <div class="invalid-feedback feednama"></div>

                        </div>
                        <div class="form-group">
                            <label for="pic">PIC (Penanggung Jawab)</label>
                            <input type="text" class="form-control" name="pic" id="pic" value="<?= isset($data['pic']) ? $data['pic'] : ''; ?>" required>
                            <div class="invalid-feedback feedpic"></div>

                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= isset($data['alamat']) ? $data['alamat'] : ''; ?>" id="alamat">
                        </div>
                        <div class="form-group">
                            <label for="telp">No Telp</label>
                            <input type="text" class="form-control" name="telp" value="<?= isset($data['telp']) ? $data['telp'] : ''; ?>" id="telp">
                            <div class="invalid-feedback feedtelp"></div>
                        </div>
                        <div class="form-group">
                            <label for="fax">Fax</label>
                            <input type="text" class="form-control" name="fax" value="<?= isset($data['fax']) ? $data['fax'] : ''; ?>" id="fax">
                            <div class="invalid-feedback feedfax"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" value="<?= isset($data['email']) ? $data['email'] : ''; ?>" <?= isset($data['email']) ? 'disabled' : ''; ?> id="email" required>
                            <div class="invalid-feedback feedemail"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('suplier'); ?>">Kembali</a>
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
                            window.location = "<?= base_url('suplier'); ?>";
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