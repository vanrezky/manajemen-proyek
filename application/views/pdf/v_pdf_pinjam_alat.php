<!DOCTYPE html>
<html>

<head>
    <title>
        <?= $data['title']; ?>
    </title>
    <link href="<?= base_url('public/assets/css/table.css'); ?>" rel="stylesheet">
</head>


<body>
    <htmlpageheader name="MyHeader1">
        <img width="600px" align="center" src="<?= base_url('public/assets/kop.png'); ?>" />
    </htmlpageheader>
    <sethtmlpageheader name="MyHeader1" value="on" page="ALL" show-this-page="1" />
    <div style="font-size: 18px; margin-top:10px; margin-bottom:10px; text-align:center;"><strong>DAFTAR PEMINJAMAN ALAT</strong></div>
    <hr class="garis">
    <table class="tbl_head font8">
        <thead>
            <tr>
                <td width="30mm">Nama Proyek</td>
                <td width="2mm">:</td>
                <td><b><?= $data['data']['nama']; ?></b></td>
            </tr>
            <tr>
                <td>Nomor SPK</td>
                <td>:</td>
                <td><b><?= $data['data']['no_spk']; ?></b></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><b><?= $data['data']['alamat']; ?></b></td>
            </tr>
            <tr>
                <td>Mulai Proyek</td>
                <td>:</td>
                <td><b><?= tanggal($data['data']['mulai']); ?></b></td>
            </tr>
            <tr>
                <td>Selesai Proyek</td>
                <td>:</td>
                <td><b><?= tanggal($data['data']['selesai']); ?></b></td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <br />
    <h2>Detail Kas Masuk</h2>
    <table class="tbl_body" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="5mm" class="borderleft">No</th>
                <th>Nama Alat</th>
                <th>Deskripsi</th>
                <th class="borderright">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            if (!empty($data['detail'])) {
                foreach ($data['detail'] as $key => $value) {

                    echo "<tr>";
                    echo "<td class='borderleft tcenter borderbottomblack'>" . ++$no . "</td>";
                    echo "<td class='tcenter borderbottomblack'>" . $value['nama'] .  "</td>";
                    echo "<td class='tcenter borderbottomblack'>$value[deskripsi]</td>";
                    echo "<td  class='tright tcenter borderright borderbottomblack'>" . ($value['status'] == 0 ? 'Aktif' : 'Selesai') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Maaf, data tidak ditemukan!</td></tr>";
            }
            ?>
        </tbody>

    </table>

</body>

</html>