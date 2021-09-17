<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> User</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('user/' . ($empty ? 'save' : 'update/' . $data['id_user'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data User</h4>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" name="username" id="username" <?= !$empty ? 'disabled' : ''; ?> value="<?= isset($data['username']) ? $data['username'] : ''; ?>" required>
                            <div class="invalid-feedback feedusername"></div>

                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= isset($data['nama']) ? $data['nama'] : ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" name="alamat" value="<?= isset($data['alamat']) ? $data['alamat'] : ''; ?>" id="alamat">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="text" class="form-control" name="no_telp" value="<?= isset($data['no_telp']) ? $data['no_telp'] : ''; ?>" id="no_telp">
                            <div class="invalid-feedback feedno_telp"></div>
                        </div>
                        <div class="form-group">
                            <label for="level">Level Akses</label>
                            <?php $level = ['administrator',  'manager']; ?>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">Pilih Level Akses</option>
                                <?php

                                foreach ($level as $key => $value) {
                                    $s = isset($data['level']) ? ($data['level'] == $value ? 'selected' : '') : '';
                                    echo "<option $s value='$value'>" . ucfirst($value) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <?php

                        if (!$empty) {
                            echo pesan2('Kosongkan password jika tidak ingin mengganti password!', 'warning');
                        }

                        ?>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" <?= !$empty ? '' : 'required'; ?>>
                            <div class="invalid-feedback feedpassword"></div>
                        </div>
                        <div class="form-group">
                            <label for="password2">Konfirmasi Password</label>
                            <input type="password" class="form-control" name="password2" id="password2" <?= !$empty ? '' : 'required'; ?>>
                            <div class="invalid-feedback feedpassword2"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('user'); ?>">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<div style="display: none;">
    <div class="form-group">
        <label for="level">Level Akses</label>
        <?php $level = ['administrator',  'manager', 'vendor']; ?>
        <select class="form-control" id="level" name="level" required>
            <option value="">Pilih Level Akses</option>
            <?php

            foreach ($level as $key => $value) {
                $s = isset($data['level']) ? ($data['level'] == $value ? 'selected' : '') : '';
                echo "<option $s value='$value'>" . ucfirst($value) . "</option>";
            }
            ?>
        </select>
    </div>
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
                            window.location = "<?= base_url('user'); ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');

                        if (response.errors.username) {
                            $('#username').addClass('is-invalid');
                            $('.feedusername').html(response.errors.username);
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('.feedusername').html("");
                        }
                        if (response.errors.password) {
                            $('#password').addClass('is-invalid');
                            $('.feedpassword').html(response.errors.password);
                        } else {
                            $('#password').removeClass('is-invalid');
                            $('.feedpassword').html("");
                        }
                        if (response.errors.password2) {
                            $('#password2').addClass('is-invalid');
                            $('.feedpassword2').html(response.errors.password2);
                        } else {
                            $('#password2').removeClass('is-invalid');
                            $('.feedpassword2').html("");
                        }
                        if (response.errors.no_telp) {
                            $('#no_telp').addClass('is-invalid');
                            $('.feedno_telp').html(response.errors.no_telp);
                        } else {
                            $('#no_telp').removeClass('is-invalid');
                            $('.feedno_telp').html("");
                        }
                    }
                }
            });

        });

        $('#level').change(function(e) {
            e.preventDefault();
            checklevel($(this).val());
        });
    });


    function checklevel(val) {
        let val = $(this).val();
        if (val == 'vendor') {

        } else {

        }
    }
</script>