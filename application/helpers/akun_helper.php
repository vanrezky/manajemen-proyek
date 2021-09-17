<?php

function session_data($var = "")
{

    $CI = get_instance();

    if (!empty($var)) {
        return $CI->session->userdata('user')[$var];
    }

    return $CI->session->userdata('user');
}

function session_logincheck($var)
{
    $CI = get_instance();
    if ($CI->session->userdata('user')['level'] == $var) {
        return true;
    }

    return false;
}

function isVendor()
{
    return session_logincheck('vendor');
}

function isAdmin()
{
    return session_logincheck('administrator');
}

function isManager()
{
    return session_logincheck('manager');
}
