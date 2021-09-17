<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Daftar User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="<?= base_url(); ?>">Dashboard</a></div>
                <div class="breadcrumb-item">User</div>
            </div>
        </div>
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4></h4>
                    <div class="card-header-action">
                        <a href="<?= base_url('user/data'); ?>" class="btn btn-primary">
                            Tambah Data
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width='1%'>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>No Telp</th>
                                <th>Level Akses</th>
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
                                    echo "<td>$value[username]</td>";
                                    echo "<td>$value[nama]</td>";
                                    echo "<td>$value[no_telp]</td>";
                                    echo "<td>" . ucfirst($value['level']) . "</td>";
                                    echo "<td>";
                                    echo "<a href='" . base_url('user/data/' . $value['id_user']) . "' class='mr-2 mb-2 btn btn-warning btn-sm'>Edit</a>";
                                    echo "<a href='" . base_url('user/delete/' . $value['id_user']) . "' class='mb-2 btn btn-danger btn-sm btn-delete'>Delete</a>";
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