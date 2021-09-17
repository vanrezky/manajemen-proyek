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
    <div style="font-size: 18px; margin-top:10px; margin-bottom:10px; text-align:center;"><strong>DAFTAR KAS MASUK</strong></div>
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
            <tr>
                <td>Nilai Kontrak</td>
                <td>:</td>
                <td><b><?= rupiah($data['data']['nilai_kontrak']); ?></b></td>
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
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th class="borderright">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $total = 0;
            if (!empty($data['detail'])) {
                foreach ($data['detail'] as $key => $value) {
                    $total += $value['jumlah'];

                    echo "<tr>";
                    echo "<td class='borderleft tcenter'>" . ++$no . "</td>";
                    echo "<td class='tcenter'>" . tanggal($value['tgl_kas_masuk']) .  "</td>";
                    echo "<td class='tcenter '>$value[deskripsi]</td>";
                    echo "<td  class='tright borderright'>" . rupiah($value['jumlah']) .  "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td colspan='2' class='borderleft tright borderbottomblack'><b> >>>>>>> Grand total</b></td>";
                echo "<td colspan='2' class='tright borderright borderbottomblack'><b>" . rupiah($total) . "</b></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='4'>Maaf, data tidak ditemukan!</td></tr>";
            }
            ?>
        </tbody>

    </table>

</body>

</html>