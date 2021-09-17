<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Detail Pekerjaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Detail Pekerjaan Proyek</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Proyek <?= $data['nama']; ?></h4>
                    <div class="card-header-action">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#modal-detail">
                            Tambah Item
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-middle">
                        <thead>
                            <tr>
                                <th width='1%'>No</th>
                                <th>Deskripsi</th>
                                <th>Qty</th>
                                <th>Satuan</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th width="17%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $grand_total = 0;
                            $sub_total_material = 0;
                            $sub_total_jasa = 0;
                            if (!empty($detail)) {
                                foreach ($detail as $key => $value) {

                                    if ($value['tipe'] == 'header') {
                                        echo "<tr>";
                                        echo "<td>$no</td>";
                                        echo "<td colspan='5' class='blue'><b>$value[deskripsi]</b> (" . ucfirst($value['summary']) . ")</td>";
                                        echo "<td>";
                                        echo "<a href='" . base_url('proyek/detail_pekerjaan_data/' . $value['id_detail']) . "' class='mr-2 mb-2 btn btn-warning btn-sm'>Edit</a>";
                                        echo "<a href='" . base_url('proyek/detail_pekerjaan_delete/' . $value['id_detail']) . "' class=' mb-2 btn btn-danger btn-sm btn-delete'>Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                        $no++;

                                        $sub_total = 0;
                                        foreach ($detail as $k => $v) {

                                            if ($v['parent_detail'] == $value['id_detail']) {

                                                $grand_total += $v['total_harga'];
                                                $sub_total += $v['total_harga'];

                                                if ($value['summary'] == 'jasa') {
                                                    $sub_total_jasa += $v['total_harga'];
                                                }

                                                if ($value['summary'] == 'material') {
                                                    $sub_total_material += $v['total_harga'];
                                                }
                                                echo "<tr>";
                                                echo "<td>$no</td>";
                                                echo "<td>$v[deskripsi]</td>";
                                                echo "<td>$v[qty]</td>";
                                                echo "<td>$v[satuan]</td>";
                                                echo "<td>" . rupiah($v['harga_satuan']) . "</td>";
                                                echo "<td>" . rupiah($v['total_harga']) . "</td>";
                                                echo "<td>";
                                                echo "<a href='" . base_url('proyek/detail_pekerjaan_data/' . $v['id_detail']) . "' class='mr-2 mb-2 btn btn-warning btn-sm'>Edit</a>";
                                                echo "<a href='" . base_url('proyek/detail_pekerjaan_delete/' . $v['id_detail']) . "' class=' mb-2 btn btn-danger btn-sm btn-delete'>Delete</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                        }

                                        if ($sub_total > 0) {
                                            echo "<tr  class='crimson'>";
                                            echo "<td colspan='5'><b>Sub Jumlah $value[deskripsi]</b></td>";
                                            echo "<td colspan='2'><b>" . rupiah($sub_total) . "</b></td>";
                                            echo "</tr>";
                                        }
                                    }
                                }

                                echo "<tr class='salmon'>";
                                echo "<td colspan='5'><b>Grand Total Proyek " . $data['nama'] . "</b></td>";
                                echo "<td colspan='2'><b>" . rupiah($grand_total) . "</b></td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='7'>";
                                echo pesan2("Data tidak ditemukan!..", 'warning');
                                echo "</td></tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Summary</h4>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered table-midde bold">
                        <?php
                        $ppn_material = ($sub_total_material * 10) / 100;
                        $grand_total_material = $sub_total_material + $ppn_material;
                        $ppn_jasa = ($sub_total_jasa * 10) / 100;
                        $grand_total_jasa = $sub_total_jasa + $ppn_jasa;

                        ?>
                        <tbody>
                            <tr>
                                <td rowspan="3" width="50%" class="text-center">Material</td>
                                <td>Subtotal</td>
                                <td><?= rupiah($sub_total_material); ?></td>
                            </tr>

                            <tr>
                                <td>PPN (10%)</td>
                                <td><?= rupiah($ppn_material); ?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?= rupiah($grand_total_material); ?></td>
                            </tr>

                            <!-- batas -->
                            <tr>
                                <td rowspan="3" class="text-center">Jasa</td>
                                <td>Subtotal</td>
                                <td><?= rupiah($sub_total_jasa); ?></td>
                            </tr>

                            <tr>
                                <td>PPN (10%)</td>
                                <td><?= rupiah($ppn_jasa); ?></td>
                            </tr>
                            <tr>
                                <td>Total</td>
                                <td><?= rupiah($grand_total_jasa); ?></td>
                            </tr>
                            <!-- Total -->
                            <tr>
                                <td class="text-center">======></td>
                                <td>Grandtotal</td>
                                <td><?= rupiah($grand_total_material + $grand_total_jasa); ?></td>
                            </tr>


                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
<form id="form-delete" action="#">
    <?= csrf_field("csrf_delete"); ?>
</form>
<div class="modal fade " tabindex="-1" role="dialog" id="modal-detail">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Detail Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('proyek/detail_pekerjaan_save'); ?>" method="POST" id="form-submit">
                <?= csrf_field('csrf_protection'); ?>
                <?= form_hidden('id_proyek', $data['id_proyek']); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="d-block" for="tipe">Tipe Data</label>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input tipe-data" type="radio" name="tipe" id="inlineradio1" value="header">
                            <label class="custom-control-label" for="inlineradio1">Header</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input tipe-data" type="radio" name="tipe" id="inlineradio2" value="detail" checked>
                            <label class="custom-control-label" for="inlineradio2">Detail</label>
                        </div>
                    </div>
                    <div class="parent-detail"></div>
                    <div class="summary-detail"></div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input class="form-control" name="deskripsi" id="deskripsi" required>
                    </div>
                    <div class="row" id="detail-input">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="qty">Jumlah (Qty)</label>
                                <input type="number" class="form-control" name="qty" id="qty" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="number" class="form-control" name="harga_satuan" id="harga_satuan" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select class="form-control" name="satuan" id="satuan" required>
                                    <option value="">Pilih Satuan</option>
                                    <?php

                                    foreach (satuan() as $key => $value) {
                                        echo "<option value='$value'>" . ucwords($value) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input class="form-control" name="total_harga" id="total_harga" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn-submit" class="btn btn-success">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div style="display: none;">
    <div class="form-group parent-option">
        <label for="parent_detail">Header</label>
        <select class="form-control" name="parent_detail" id="parent_detail" required>
            <option value="">Pilih Header</option>
            <?php

            foreach ($parent as $key => $value) {
                echo "<option value='$value[id_detail]'>" . ucwords($value['deskripsi']) . "</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group summary-option">
        <label for="summary">Jenis Summary</label>
        <select class="form-control" name="summary" id="summary" required>
            <?php
            foreach (['material', 'jasa'] as $k => $v) {
                echo "<option value='$v'>" . ucwords($v) . "</option>";
            }
            ?>
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        clone_parent();

        $(".btn-delete").click(function(e) {
            e.preventDefault();
            deleteData(this);
        });

        $(".tipe-data").change(function(e) {
            if ($(this).val() == 'header') {
                clone_summary();
                $(".parent-detail").empty();
                $("#detail-input").find('input,select').attr('disabled', true);
            } else {
                clone_parent();
                $(".summary-detail").empty();
                $("#detail-input").find('input,select').attr('disabled', false);
            }
        });

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
                dataType: 'json',
                beforeSend: function() {
                    $('#btn-submit').addClass('btn-progress btn-disabled');
                },
                success: function(response) {
                    $('#btn-submit').removeClass('btn-progress btn-disabled');

                    if (response.csrf) {
                        $("#csrf_protection").val(response.csrf);
                    }

                    if (response.success) {
                        Swal.fire("Sukess..", response.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire("Opps..", response.message, 'error');
                    }
                }
            });

        });
    });

    function clone_parent() {
        $(".parent-detail").html($(".parent-option").clone());
    }

    function clone_summary() {
        $(".summary-detail").html($(".summary-option").clone());
    }
</script>