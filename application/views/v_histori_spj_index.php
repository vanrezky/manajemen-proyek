<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar Validasi SPJ</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">Validasi SPJ</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Validasi SPJ</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width='1%'>No</th>
                                <th>No SPK</th>
                                <th>Nama Proyek</th>
                                <th>Tgl Proyek</th>
                                <th>Nama Vendor</th>
                                <th>Target</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($data)) {
                                $no = 1;
                                foreach ($data as $key => $value) {
                                    echo "<tr>";
                                    echo "<td>$no</td>";
                                    echo "<td>$value[no_spk]</td>";
                                    echo "<td>$value[nama_proyek]</td>";
                                    echo "<td>$value[mulai]<br>$value[selesai]</td>";
                                    echo "<td>$value[nama_vendor]</td>";
                                    echo "<td>$value[tgl_mulai]<br>$value[tgl_selesai]</td>";
                                    echo "<td>";
                                    echo "<a href='" . base_url('histori_spj/detail/' . $value['id_proyek_vendor']) . "' class='mr-2 mb-2 btn btn-warning btn-sm'>Detail</a>";
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