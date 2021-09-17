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
        <img width="600" align="center" src="<?= base_url('public/assets/kop.png'); ?>" />
    </htmlpageheader>
    <sethtmlpageheader name="MyHeader1" value="on" page="ALL" show-this-page="1" />
    <div style="font-size: 18px; margin-top:10px; margin-bottom:10px; text-align:center;"><strong>DAFTAR PROYEK</strong></div>
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
    <h2>Detail Pekerjaan</h2>
    <table class="tbl_body" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th width="5mm" class="borderleft">No</th>
                <th>Deskripsi</th>
                <th>Qty</th>
                <th>Satuan</th>
                <th>Harga Satuan</th>
                <th class="borderright">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $grand_total = 0;
            $sub_total_material = 0;
            $sub_total_jasa = 0;
            $detail = $data['detail'];
            $parent = $data['parent'];
            if (!empty($detail)) {
                foreach ($detail as $key => $value) {

                    if ($value['tipe'] == 'header') {
                        echo "<tr class=' odd'>";
                        echo "<td class='borderleft'>$no</td>";
                        echo "<td colspan='5' class='blue borderright'><b>$value[deskripsi]</b> (" . ucfirst($value['summary']) . ")</td>";
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
                                echo "<tr class=''>";
                                echo "<td class='borderleft'>$no</td>";
                                echo "<td>$v[deskripsi]</td>";
                                echo "<td class='tcenter'>$v[qty]</td>";
                                echo "<td class='tcenter'>$v[satuan]</td>";
                                echo "<td class='tcenter'>" . rupiah($v['harga_satuan']) . "</td>";
                                echo "<td class='blue borderright tcenter'>" . rupiah($v['total_harga']) . "</td>";
                                echo "</tr>";
                                $no++;
                            }
                        }

                        if ($sub_total > 0) {
                            echo "<tr class='crimson'>";
                            echo "<td colspan='5' class='borderleft'><b>Sub Jumlah $value[deskripsi]</b></td>";
                            echo "<td  class='blue borderright tcenter'><b>" . rupiah($sub_total) . "</b></td>";
                            echo "</tr>";
                        }
                    }
                }

                echo "<tr class='salmon'>";
                echo "<td colspan='5' class='borderleft borderbottomblack'><b>Grand Total Proyek " . $data['nama'] . "</b></td>";
                echo "<td  class='blue borderright tcenter borderbottomblack'><b>" . rupiah($grand_total) . "</b></td>";
                echo "</tr>";
            } else {
                echo "<tr><td colspan='6' class='tcenter' >";
                echo 'Data tidak ditemukan!';
                echo "</td></tr>";
            }

            ?>
        </tbody>
    </table>
    <h2>Summary</h2>
    <table class="tbl_body" cellpadding="0" cellspacing="0">
        <?php
        $ppn_material = ($sub_total_material * 10) / 100;
        $grand_total_material = $sub_total_material + $ppn_material;
        $ppn_jasa = ($sub_total_jasa * 10) / 100;
        $grand_total_jasa = $sub_total_jasa + $ppn_jasa;

        ?>
        <thead>
            <tr>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="3" width="50%" class="tcenter borderleft">Material</td>
                <td>Subtotal</td>
                <td class="borderright"><?= rupiah($sub_total_material); ?></td>
            </tr>

            <tr>
                <td>PPN (10%)</td>
                <td class="borderright"><?= rupiah($ppn_material); ?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td class="borderright"><?= rupiah($grand_total_material); ?></td>
            </tr>

            <!-- batas -->
            <tr>
                <td rowspan="3" class="tcenter borderleft borderbottomblack">Jasa</td>
                <td>Subtotal</td>
                <td class="borderright "><?= rupiah($sub_total_jasa); ?></td>
            </tr>

            <tr>
                <td>PPN (10%)</td>
                <td class="borderright"><?= rupiah($ppn_jasa); ?></td>
            </tr>
            <tr>
                <td class="borderbottomblack">Total</td>
                <td class="borderright borderbottomblack"><?= rupiah($grand_total_jasa); ?></td>
            </tr>
            <!-- Total -->
            <tr>
                <td class="tcenter borderleft borderbottomblack">======></td>
                <td class="borderbottomblack">Grandtotal</td>
                <td class="borderright borderbottomblack"><?= rupiah($grand_total_material + $grand_total_jasa); ?></td>
            </tr>


        </tbody>

    </table>

</body>

</html>