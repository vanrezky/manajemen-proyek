<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Proyek</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Proyek</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-header-action">
                        <?php
                        if (isAdmin()) {
                            echo "<a href='" . base_url('proyek/data') . "' class='btn btn-primary'>
                            Tambah Data
                        </a>";
                        }

                        ?>

                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width='1%'>No</th>
                                    <th>Nama</th>
                                    <!-- <th>No SPK</th> -->
                                    <!-- <th>Alamat</th> -->
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Nilai Kontrak</th>
                                    <th>Status</th>
                                    <th width="17%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($data)) {
                                    $no = 1;
                                    foreach ($data as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>$no</td>";
                                        echo "<td>$value[nama]</td>";
                                        // echo "<td>$value[no_spk]</td>";
                                        // echo "<td>$value[alamat]</td>";
                                        echo "<td>" . tanggal($value['mulai']) . "</td>";
                                        echo "<td>" . tanggal($value['selesai']) . "</td>";
                                        echo "<td>" . rupiah($value['nilai_kontrak']) . "</td>";

                                        echo "<td><div class='badge " . ($value['status'] == 'aktif' ? 'badge-success' : 'badge-warning') . "'>$value[status]</div></td>";
                                        echo "<td>";
                                        // if (isVendor()) {
                                        //     echo "<a href='" . base_url('proyek/detail/' . $value['id_proyek_vendor']) . "' class='mr-2 mb-2 btn btn-primary btn-sm'>Detail</a>";
                                        // }
                                        echo "<a href='" . base_url('proyek/detail_pekerjaan/' . $value['id_proyek']) . "' class='mr-2 mb-2 btn btn-primary btn-sm'>Detail Kerja</a>";

                                        if (isAdmin()) {
                                            echo "<a href='" . base_url('proyek/data/' . $value['id_proyek']) . "' class='mr-2 mb-2 btn btn-warning btn-sm'>Edit</a>";
                                            echo "<a href='" . base_url('proyek/delete/' . $value['id_proyek']) . "' class='mr-2 mb-2 btn btn-danger btn-sm btn-delete'>Delete</a>";
                                        }

                                        echo "</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                } else {
                                    echo "<tr><td colspan='6'>";
                                    echo pesan2("Data tidak ditemukan!..", 'warning');
                                    echo "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
    });
</script>