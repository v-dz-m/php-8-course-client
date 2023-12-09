<?php

function debug($data, $die = false)
{
    echo '<pre>' . print_r($data, 1) . '</pre>';
    if ($die) {
        die;
    }
}

function h($str)
{
    return htmlspecialchars($str);
}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = $_SERVER['HTTP_REFERER'] ?? PATH;
    }

    header("Location: $redirect");
    die;
}

function base_url()
{
    return PATH . '/' . (\wfm\App::$app->getProperty('lang') ? (\wfm\App::$app->getProperty('lang') . '/') : '');
}

/**
 * @param $key
 * @param $type
 * @return float|int|string
 */
function get($key, $type = 'i')
{
    $param = $key;
    $$param = $_GET[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

/**
 * @param $key
 * @param $type
 * @return float|int|string
 */
function post($key, $type = 's')
{
    $param = $key;
    $$param = $_POST[$param] ?? '';
    if ($type == 'i') {
        return (int)$$param;
    } elseif ($type == 'f') {
        return (float)$$param;
    } else {
        return trim($$param);
    }
}

function __($key)
{
    echo \wfm\Language::get($key);
}

function ___($key)
{
    return \wfm\Language::get($key);
}

function get_cart_icon($id)
{
    if (!empty($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'])) {
        $icon = '<i class="fas fa-luggage-cart"></i>';
    } else {
        $icon = '<i class="fas fa-shopping-cart"></i>';
    }

    return $icon;
}

function get_field_value($name)
{
    return isset($_SESSION['form_data'][$name]) ? h($_SESSION['form_data'][$name]) : '';
}
