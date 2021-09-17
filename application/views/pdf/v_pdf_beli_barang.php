<!DOCTYPE html>
<html>

<head>
    <title>
        <?= $data['title']; ?>
    </title>
    <link href="<?= base_url('public/assets/css/table.css?' . time()); ?>" rel="stylesheet">
</head>


<body>
    <htmlpageheader name="MyHeader1">
        <img width="600px" align="center" src="<?= base_url('public/assets/kop.png'); ?>" />

    </htmlpageheader>
    <sethtmlpageheader name="MyHeader1" value="on" page="ALL" show-this-page="1" />
    <div style="font-size: 18px; margin-top:10px; margin-bottom:10px; text-align:center;"><strong>PEMBELIAN BARANG</strong></div>
    <hr class="garis">
    <table class="tbl_head font8">
        <thead>
            <tr>
                <td width="30mm">Nama Proyek</td>
                <td width="2mm">:</td>
                <td><b><?= $data['data']['nama_proyek']; ?></b></td>
                <td width="70mm"></td>
                <td width="30mm">Nama Suplier</td>
                <td width="2mm">:</td>
                <td><?= $data['data']['nama_suplier']; ?></td>
            </tr>

            <tr>
                <td colspan="4"></td>
                <td>Tanggal Pembelian</td>
                <td>:</td>
                <td><b><?= tanggal($data['data']['tgl_beli_barang']); ?></b></td>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
    <table class="tbl_body" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="5mm" class="borderleft">No</th>
                <th>Nama Barang</h>
                <th>Satuan</th>
                <th>Jumlah (qty)</th>
                <th>Harga</th>
                <th class="borderright">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            $total = 0;
            if (!empty($data['detail'])) {
                foreach ($data['detail'] as $key => $value) {
                    $total += $value['total'];

                    echo "<tr>";
                    echo "<td class='borderleft tcenter'>" . ++$no . "</td>";
                    echo "<td class='tcenter'>$value[nama]</td>";
                    echo "<td class='tcenter'>$value[satuan]</td>";
                    echo "<td class='tcenter'>$value[qty]</td>";
                    echo "<td class='tcenter'>" . rupiah($value['harga']) .  "</td>";
                    echo "<td  class='tright borderright'>" . rupiah($value['total']) .  "</td>";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td colspan='4' class='borderleft tright borderbottomblack'><b> >>>>>>> Grand total</b></td>";
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