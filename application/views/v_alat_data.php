<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> Alat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> Alat</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('alat/' . ($empty ? 'save' : 'update/' . $data['id_alat'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data Alat</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama Alat</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($data['nama']) ? $data['nama'] : ''; ?>" required autofocus>
                            <div class="invalid-feedback feednama"></div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control" name="deskripsi" value="<?= isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?>" id="deskripsi">
                            <div class="invalid-feedback feeddeskripsi"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('alat'); ?>">Kembali</a>
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
                            window.location = "<?= base_url('alat'); ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                        if (response.errors.telp) {
                            $('#telp').addClass('is-invalid');
                            $('.feedtelp').html(response.errors.telp);
                        } else {
                            $('#telp').removeClass('is-invalid');
                            $('.feedtelp').html("");
                        }
                    }
                }
            });

        });
    });
</script>