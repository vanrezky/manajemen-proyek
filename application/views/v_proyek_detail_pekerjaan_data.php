<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Update Detail Pekerjaan Proyek</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Update Detail Pekerjaan Proyek</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('proyek/detail_pekerjaan_update/' . $data['id_detail']); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <?= form_hidden('tipe', $data['tipe']); ?>
                <div class="card">
                    <div class="card-header">
                        <h4>Update Detail Pekerjaan Proyek</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <input class="form-control" name="deskripsi" id="deskripsi" value="<?= isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?>" required>
                        </div>
                        <?php
                        if ($data['tipe'] == 'header') { ?>
                            <div class="form-group summary-option">
                                <label for="summary">Jenis Summary</label>
                                <select class="form-control" name="summary" id="summary" required>
                                    <?php
                                    foreach (['material', 'jasa'] as $k => $v) {
                                        $s = $data['summary'] == $v ? 'selected' : '';
                                        echo "<option $s value='$v'>" . ucwords($v) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        <?php } else { ?>
                            <div class="form-group parent-option">
                                <label for="parent_detail">Header</label>
                                <select class="form-control" name="parent_detail" id="parent_detail" required>
                                    <option value="">Pilih Header</option>
                                    <?php

                                    foreach ($parent as $key => $value) {
                                        $s = isset($data['parent_detail']) ? ($data['parent_detail'] == $value['id_detail'] ? 'selected' : '') : '';
                                        echo "<option $s value='$value[id_detail]'>" . ucwords($value['deskripsi']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row" id="detail-input">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="qty">Jumlah (Qty)</label>
                                        <input type="number" class="form-control" value="<?= isset($data['qty']) ? $data['qty'] : ''; ?>" name="qty" id="qty" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="harga_satuan">Harga Satuan</label>
                                        <input type="number" class="form-control" value="<?= isset($data['harga_satuan']) ? $data['harga_satuan'] : ''; ?>" name="harga_satuan" id="harga_satuan" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="satuan">Satuan</label>
                                        <select class="form-control" name="satuan" id="satuan" required>
                                            <option value="">Pilih Satuan</option>
                                            <?php
                                            foreach (satuan() as $key => $value) {
                                                $s = isset($data['satuan']) ? ($data['satuan'] == $value ? 'selected' : '') : '';
                                                echo "<option $s value='$value'>" . ucwords($value) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="total_harga">Total Harga</label>
                                        <input class="form-control" name="total_harga" id="total_harga" value="<?= isset($data['total_harga']) ? $data['total_harga'] : ''; ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit">Update</button>
                        <a class="btn btn-warning" href="<?= base_url('proyek/detail_pekerjaan/' . $data['id_proyek']); ?>">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<script>
    $(document).ready(function() {

        $("#qty,#harga_satuan").keyup(function(e) {
            let qty = $("#qty").val();
            let harga_satuan = $("#harga_satuan").val();
            if (qty && harga_satuan) {
                $("#total_harga").val(qty * harga_satuan);
            } else {
                $("#total_harga").val('');
            }

            return false;
        });
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
                            window.location = BASEURL + "proyek/detail_pekerjaan/<?= $data['id_proyek']; ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                    }
                }
            });

        });
    });
</script>