<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Pembelian Barang</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Pembelian Barang</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>
                        <form id="form-filter">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" id="id_proyek" name="id_proyek" required>
                                        <option value="">Pilih Proyek</option>
                                        <?php

                                        foreach ($proyek as $key => $value) {
                                            $s = isset($filter['id_proyek']) ? ($filter['id_proyek'] == $value['id_proyek'] ? 'selected' : '') : '';
                                            echo "<option $s value='$value[id_proyek]'>" . $value['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" id="id_suplier" name="id_suplier" required>
                                        <option value="">Pilih Suplier</option>
                                        <?php

                                        foreach ($suplier as $key => $value) {
                                            $s = isset($filter['id_suplier']) ? ($filter['id_suplier'] == $value['id_suplier'] ? 'selected' : '') : '';
                                            echo "<option $s value='$value[id_suplier]'>" . $value['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                        </form>
                    </h4>
                    <div class="card-header-action">

                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width='1%'>No</th>
                                <th>Nama Proyek</th>
                                <th>Deskripsi</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($data) {
                                $no = 1;
                                foreach ($data as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>$no</td>";
                                    echo "<td>" . $value['nama_proyek'] .  "</td>";
                                    echo "<td>$value[deskripsi]</td>";
                                    echo "<td>" . tanggal($value['tgl_beli_barang']) .  "</td>";
                                    echo "<td>" . rupiah($value['grand_total']) .  "</td>";
                                    echo "<td>";
                                    echo "<a target='_blank' href='" . base_url('pdf/beli_barang/' . $value['id_beli_barang']) . "' class='mr-2 mb-2 btn btn-info btn-sm'>Cetak</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
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
        </div>
    </section>
</div>
<form id="form-delete" action="#">
    <?= csrf_field("csrf_delete"); ?>
</form>

<script>
    $(document).ready(function() {
        $(".btn-delete").click(function(e) {
            e.preventDefault();
            deleteData(this);
        });

        $("#id_proyek,#id_suplier").change(function(e) {
            e.preventDefault();
            $("#form-filter").submit();

        });
    });
</script>