<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1><?= !$empty ? 'Update' : 'Tambah'; ?> Pembelian Barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item"><?= !$empty ? 'Update' : 'Tambah'; ?> Pembelian Barang</div>
            </div>
        </div>
        <div class="section-body">
            <form method="post" action="<?= base_url('beli_barang/' . ($empty ? 'save' : 'update/' . $data['id_beli_barang'])); ?>" id="form-submit">

                <?= csrf_field('csrf_protection'); ?>
                <input type="hidden" name="grand_total" value="<?= isset($data['grand_total']) ? $data['grand_total'] : ''; ?>" class="grand-total">
                <div class="card">
                    <div class="card-header">
                        <h4><?= !$empty ? 'Update' : 'Tambah'; ?> Data Pembelian Barang</h4>
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
                            <label for="id_suplier">Pilih Suplier</label>
                            <select class="form-control" id="id_suplier" name="id_suplier" required>
                                <option value="">Pilih Suplier</option>
                                <?php

                                foreach ($suplier as $key => $value) {
                                    $s = isset($data['id_suplier']) ? ($data['id_suplier'] == $value['id_suplier'] ? 'selected' : '') : '';
                                    echo "<option $s value='$value[id_suplier]'>" . $value['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tgl_beli_barang">Tanggal Beli Barang</label>
                            <input type="date" class="form-control" name="tgl_beli_barang" value="<?= isset($data['tgl_beli_barang']) ? $data['tgl_beli_barang'] : ''; ?>" id="tgl_beli_barang" required>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" style="height: 90px;" class="form-control"><?= isset($data['deskripsi']) ? $data['deskripsi'] : ''; ?></textarea>
                        </div>
                        <table class="table table-striped table-detail">
                            <thead>
                                <tr>
                                    <td>Nama Barang</td>
                                    <td>Satuan</td>
                                    <td>Jumlah (qty)</td>
                                    <td>Harga</td>
                                    <td>Total</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($detail)) {

                                    foreach ($detail as $key => $value) :
                                ?>
                                        <tr class="form-detail">
                                            <td>
                                                <select name="detail[<?= $key; ?>][id_barang]" namaform="id_barang" required>
                                                    <option value="">Pilih Barang</option>
                                                    <?php

                                                    foreach ($barang as $k => $v) {
                                                        $s = isset($value['id_barang']) ? ($value['id_barang'] == $v['id_barang'] ? 'selected' : '') : '';
                                                        echo "<option $s value='$v[id_barang]'>" . $v['nama'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                            <td><input type="text" name="detail[<?= $key; ?>][satuan]" class="satuan" namaform="satuan" value="<?= $value['satuan']; ?>" required></td>
                                            <td><input type="number" name="detail[<?= $key; ?>][qty]" class="qty" namaform="qty" value="<?= $value['qty']; ?>" required></td>
                                            <td><input type="number" name="detail[<?= $key; ?>][harga]" class="harga" namaform="harga" value="<?= $value['harga']; ?>" required></td>
                                            <td><input type="number" name="detail[<?= $key; ?>][total]" class="total" namaform="total" value="<?= $value['total']; ?>" required readonly></td>
                                            <td>
                                                <input namaform='id_beli_barang_detail' value="<?= $value['id_beli_barang_detail']; ?>" type='hidden'>
                                                <button data-id="<?= $value['id_beli_barang_detail']; ?>" type="button" id="btn-delete-detail" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button>
                                            </td>
                                        </tr>
                                <?php
                                    endforeach;
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr class="btn-tr">
                                    <td colspan="5"></td>
                                    <td><button type="button" id="btn-add" class="btn btn-sm btn-info"><i class="fas fa-plus"></i></button></td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="text-right"> >>>>>>>>>>></td>
                                    <td colspan="2">
                                        <h5 class="grand-total-text"><?= isset($data['grand_total']) ? rupiah($data['grand_total']) : ''; ?></h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit"><?= !$empty ? 'Update' : 'Submit'; ?></button>
                        <a class="btn btn-warning" href="<?= base_url('beli_barang'); ?>">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
<style>
    [readonly] {
        background-color: tan;
    }
</style>
<script>
    $(document).ready(function() {

        <?php
        if (empty($detail)) {
            echo 'form_detail();';
        }
        ?>

        $("#btn-add").click(function(e) {
            e.preventDefault();
            form_detail();
        });

        $(document).on('keyup', '.qty, .harga', function(e) {
            let form_detail = $(this).closest('.form-detail');
            let qty = form_detail.find('.qty').val();
            let harga = form_detail.find('.harga').val();
            let total = form_detail.find('.total');
            if (qty && harga) {
                total.val(qty * harga);
                grand_total();
            }
        });


        $(document).on('click', '#btn-delete-temp', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
            grand_total();

        });
        $(document).on('click', '#btn-delete-detail', function(e) {
            e.preventDefault();
            btn = $(this);
            let id = btn.data('id');
            Swal.fire({
                title: "Konfirmasi Ulang",
                text: "Yakin menghapus detail ?",
                icon: "warning",
                showCancelButton: true,
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    let input_delete = "<input namaform='beli_barang_deleted' value='" + id + "' type='hidden'>";
                    btn.closest('tr').addClass('form-detail-deleted').removeClass('form-detail').hide();
                    btn.closest('td').append(input_delete);
                    grand_total();
                }
            });
        });

        $("#form-submit").submit(function(e) {
            e.preventDefault();

            $.each($(".form-detail, .form-detail-deleted"), function(index, value) {

                $.each($(value).find('input, select'), function(indexInArray, valueOfElement) {
                    let name = $(valueOfElement).attr('namaform');
                    $(valueOfElement).attr('name', 'detail[' + index + '][' + name + ']');

                });
            });

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
                            window.location = "<?= base_url('beli_barang'); ?>";
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                        error_message(response.errors);
                    }
                }
            });

        });
    });

    function form_detail() {
        let form = `<tr class="form-detail">
            <td>
                <select name="id_barang" namaform="id_barang" required>
                    <option value="">Pilih Barang</option>
                    <?php

                    foreach ($barang as $key => $value) {
                        echo "<option $s value='$value[id_barang]'>" . $value['nama'] . "</option>";
                    }
                    ?>
                </select>
            </td>
            <td><input type="text" class="satuan" namaform="satuan" required></td>
            <td><input type="number" class="qty" namaform="qty" required></td>
            <td><input type="number" class="harga" namaform="harga" required></td>
            <td><input type="number" class="total" namaform="total" required readonly></td>
            <td><button type="button" id="btn-delete-temp" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></button></td>
        </tr>`;

        $(".table-detail").find('tbody').append(form);
    }

    function grand_total() {
        let grand_total = 0;
        $('.table-detail .form-detail').find('.total:input').each(function() {

            let total = parseFloat($(this).val());
            if (total) {
                grand_total += total;
            }
        });

        $('.grand-total-text').text(format(grand_total));
        $('.grand-total').val(grand_total);
    }

    let format = function(num) {
        let str = num.toString().replace("", ""),
            parts = false,
            output = [],
            i = 1,
            formatted = null;
        if (str.indexOf(".") > 0) {
            parts = str.split(".");
            str = parts[0];
        }
        str = str.split("").reverse();
        for (let j = 0, len = str.length; j < len; j++) {
            if (str[j] != ",") {
                output.push(str[j]);
                if (i % 3 == 0 && j < len - 1) {
                    output.push(",");
                }
                i++;
            }
        }
        formatted = output.reverse().join("");
        return "" + formatted + (parts ? "." + parts[1].substr(0, 2) : "");
    };
</script>