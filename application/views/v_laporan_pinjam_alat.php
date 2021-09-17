<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Peminjaman Alat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Peminjaman Alat</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>
                        <form id="form-filter">
                            <select class="form-control" id="id_proyek" name="id_proyek" required>
                                <option value="">Pilih Proyek</option>
                                <?php

                                foreach ($proyek as $key => $value) {
                                    $s = isset($filter['id_proyek']) ? ($filter['id_proyek'] == $value['id_proyek'] ? 'selected' : '') : '';
                                    echo "<option $s value='$value[id_proyek]'>" . $value['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                    </h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('pdf/pinjam_alat/' . encode($filter)); ?>" class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Cetak
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width='1%'>No</th>
                                <th>Nama Alat</th>
                                <th>Deskripsi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($data) {
                                $no = 1;
                                foreach ($data as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>$no</td>";
                                    echo "<td>$value[nama]</td>";
                                    echo "<td>$value[deskripsi]</td>";
                                    echo "<td>" . ($value['status'] == 0 ? 'Aktif' : 'Selesai') . "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='7'>";
                                echo pesan2((!empty($filter['id_proyek']) ? 'Data tidak ditemukan!..' : 'Silahkan pilih proyek dahulu!'), 'warning');
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

        $("#id_proyek").change(function(e) {
            e.preventDefault();
            $("#form-filter").submit();

        });
    });
</script>