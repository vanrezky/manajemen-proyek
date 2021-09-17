<?php

function is_logged_in()
{
    $CI = &get_instance();

    if (empty($CI->session->has_userdata('user'))) {
        redirect('auth');
    } else {
        $uri = $CI->uri->segment('1');
        if ($uri != 'pdf') {
            $uri = empty($uri) ? '/' : ($uri == 'dashboard' ? '/' : $uri);
            $level = $CI->session->userdata('user')['level'];

            $exist = $CI->db
                ->join('menu M', 'M.id_menu = MG.id_menu', 'INNER')
                ->where('MG.level', $level)
                ->like('M.url', $uri, 'after')
                ->get('menu_group MG')->row_array();

            if (empty($exist)) {
                redirect('404');
            }
        }
    }
}

function csrf_field($id = "")
{
    $ci = get_instance();

    if (!empty($id)) {
        return "<input type='hidden' id='$id' name='" . $ci->security->get_csrf_token_name() . "' value='" . $ci->security->get_csrf_hash() . "'>";
    }

    return "<input type='hidden' name='" . $ci->security->get_csrf_token_name() . "' value='" . $ci->security->get_csrf_hash() . "'>";
}

function csrf_hash()
{
    $CI = get_instance();
    return $CI->security->get_csrf_hash();
}

function d($var)
{
    echo '<pre>' . var_export($var, true) . '</pre>';
}

function dd($var)
{
    echo '<pre>' . var_export($var, true) . '</pre>';
    die;
}

function pesan($pesan, $status = "success")
{
    return "<div class='alert alert-$status' role='alert'>$pesan<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
}

function pesan2($pesan, $status = "success")
{
    return "<div class='alert alert-$status' role='alert'>$pesan</div>";
}

function notAllow()
{
    exit('No direct script access allowed');
}

function current_timestamp()
{
    date_default_timezone_set("Asia/Jakarta");
    return date("Y-m-d H:i:s");
}

function rupiah($uang)
{
    return "Rp " . number_format($uang);
}

function satuan()
{
    return ['pcs', 'unit', 'lusin', 'kilogram', 'gram'];
}


function toUang($nominal = 0, $sparator = ".")
{
    $dec = "";
    if (strpos($nominal, '.') !== false) {
        $nominal = explode(".", $nominal);
        $dec = "," . $nominal[1];
        $nominal = $nominal[0];
    }
    return number_format((float)$nominal, 0, '', $sparator) . $dec;
}

function terbilang($nominal = 0)
{
    $last = "";
    if (strpos($nominal, ".") !== FALSE) {
        $z = explode(".", $nominal);
        $nominal = $z[0];
        $last = " Koma " . terbilang($z[1]);
    }
    if (!function_exists('x')) {
        function x($v = 0)
        {
            $v = (float)$v;
            $bil = ['Nol', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];
            $sat = ['', 'Belas', 'Puluh', 'Ratus'];
            if ($v < 12) return $bil[$v];
            else if ($v < 20) return trim($bil[$v % 10] . ' ' . $sat[1]);
            else if ($v < 100) return trim($bil[$v / 10] . ' ' . $sat[2] . ' ' . $bil[$v % 10]);
            else if ($v < 200) return trim(sprintf('Seratus %s', x($v - 100)));
            else return trim($bil[$v / 100] . ' ' . $sat[3] . ' ' . x($v % 100));
        }
    }
    $angka = toUang($nominal);
    $ex    = explode('.', $angka);
    $sat   = ['', 'Ribu', 'Juta', 'Milyar', 'Triliun'];
    $no    = count($ex);
    $hasil = "";
    if ($no > 5) return 'Nominal Terlalu Besar';
    foreach ($ex as $v) {
        $no--;
        if (count($ex) > 1 and $no == 1 and $v == 1) {
            $hasil .= 'Seribu ';
        } else {
            $n = trim(x($v));
            $p = str_replace(' ', '', $n);
            $hasil .= trim($n . ' ' . (empty($p) ? '' : $sat[$no])) . ' ';
        }
        $hasil = str_replace('  ', ' ', $hasil);
    }
    return trim($hasil) . $last;
}


function nama_bulan($i)
{
    $bulan = array(
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );
    return $bulan[$i - 1];
}

function tanggal($tanggal, $hari = FALSE, $time = FALSE, $short = FALSE)
{
    if (empty($tanggal) or $tanggal == '0000-00-00') return "";
    $get_bulan = $short ? 'nama_bulan2' : 'nama_bulan';
    $get_hari  = $short ? 'getShortHari' : 'getHari';

    $days = ($hari === TRUE ? $get_hari(date('w', strtotime($tanggal))) . ", " : "") . date('d', strtotime($tanggal)) . '  ' . $get_bulan(date('m', strtotime($tanggal))) . ' ' . date('Y', strtotime($tanggal));
    if ($time) {
        $time = date('H:i:s', strtotime($tanggal));
        $days = $time . " # " . $days;
    }
    return $days;
}

function encode($var)
{
    return urlencode(base64_encode(json_encode($var)));
}

function decode($var)
{
    return json_decode(base64_decode(urldecode($var)), true);
}
