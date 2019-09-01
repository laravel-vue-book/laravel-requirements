<?php

/**
 * Laravel Requirement Checker
 *
 * This standalone script will check if your server meets the requirements for running the
 * Laravel web application framework.
 *
 * @author Gastón Heim
 * @author Emerson Carvalho
 * @version 0.0.1
 * 
 * forked by buku-laravel-vue.com in order to add 6.0 requirement
 */
$latestLaravelVersion = '6.0';

$laravelVersion = (isset($_GET['v'])) ? (string) $_GET['v'] : $latestLaravelVersion;

if (!in_array($laravelVersion, array('4.2', '5.0', '5.1', '5.2', '5.3', '5.4', '5.5', '5.6', '5.7', '5.8', '6.0'))) {
    $laravelVersion = $latestLaravelVersion;
}

$laravel42Obs = 'As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json.';
$laravel50Obs = 'PHP version should be < 7. As of PHP 5.5, some OS distributions may require you to manually install the PHP JSON extension.
When using Ubuntu, this can be done via apt-get install php5-json';

$reqList = array(
    '4.2' => array(
        'php' => '5.4',
        'mcrypt' => true,
        'pdo' => false,
        'openssl' => false,
        'mbstring' => false,
        'tokenizer' => false,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => $laravel42Obs,
    ),
    '5.0' => array(
        'php' => '5.4',
        'mcrypt' => true,
        'openssl' => true,
        'pdo' => false,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => $laravel50Obs,
    ),
    '5.1' => array(
        'php' => '5.5.9',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => '',
    ),
    '5.2' => array(
        'php' => array(
            '>=' => '5.5.9',
            '<' => '7.2.0',
        ),
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => false,
        'ctype' => false,
        'json' => false,
        'obs' => '',
    ),
    '5.3' => array(
        'php' => array(
            '>=' => '5.6.4',
            '<' => '7.2.0',
        ),
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
    ),
    '5.4' => array(
        'php' => '5.6.4',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
    ),
    '5.5' => array(
        'php' => '7.0.0',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => false,
        'json' => false,
        'obs' => '',
    ),
    '5.6' => array(
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
    ),
    '5.7' => array(
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
    ),
    '5.8' => array(
        'php' => '7.1.3',
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
    ),
    '6.0' => array(
        'php' => '7.2.0',
        'bcmath' => true,
        'mcrypt' => false,
        'openssl' => true,
        'pdo' => true,
        'mbstring' => true,
        'tokenizer' => true,
        'xml' => true,
        'ctype' => true,
        'json' => true,
        'obs' => '',
    )
);

$strOk = '<i class="fa fa-check"></i>';
$strFail = '<i style="color: red" class="fa fa-times"></i>';
$strUnknown = '<i class="fa fa-question"></i>';

$requirements = array();

// PHP Version
if (is_array($reqList[$laravelVersion]['php'])) {
    $requirements['php_version'] = true;
    foreach ($reqList[$laravelVersion]['php'] as $operator => $version) {
        if (!version_compare(PHP_VERSION, $version, $operator)) {
            $requirements['php_version'] = false;
            break;
        }
    }
} else {
    $requirements['php_version'] = version_compare(PHP_VERSION, $reqList[$laravelVersion]['php'], ">=");
}

// OpenSSL PHP Extension
$requirements['openssl_enabled'] = extension_loaded("openssl");

// BCMath PHP Extension
$requirements['bcmath_enabled'] = extension_loaded("bcmath");

// PDO PHP Extension
$requirements['pdo_enabled'] = defined('PDO::ATTR_DRIVER_NAME');

// Mbstring PHP Extension
$requirements['mbstring_enabled'] = extension_loaded("mbstring");

// Tokenizer PHP Extension
$requirements['tokenizer_enabled'] = extension_loaded("tokenizer");

// XML PHP Extension
$requirements['xml_enabled'] = extension_loaded("xml");

// CTYPE PHP Extension
$requirements['ctype_enabled'] = extension_loaded("ctype");

// JSON PHP Extension
$requirements['json_enabled'] = extension_loaded("json");

// Mcrypt
$requirements['mcrypt_enabled'] = extension_loaded("mcrypt_encrypt");

// mod_rewrite
$requirements['mod_rewrite_enabled'] = null;

if (function_exists('apache_get_modules')) {
    $requirements['mod_rewrite_enabled'] = in_array('mod_rewrite', apache_get_modules());
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Server Requirements &dash; Laravel PHP Framework</title>
    <link href="//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        @import url(//fonts.googleapis.com/css?family=Lato:300,400,700);

        body {
            margin: 0;
            font-size: 16px;
            font-family: 'Lato', sans-serif;
            text-align: center;
            color: #999;
        }

        .wrapper {
            width: 300px;
            margin: 50px auto;
        }

        p {
            margin: 0;
        }

        p small {
            font-size: 13px;
            display: block;
            margin-bottom: 1em;
        }

        p.obs {
            margin-top: 20px;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #31708f;
            background-color: #d9edf7;
            border-color: #bce8f1;
        }

        .icon-ok {
            color: #27ae60;
        }

        .icon-remove {
            color: #c0392b;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <a href="http://laravel.com" title="Laravel PHP Framework">
            <svg width="50" height="52" viewBox="0 0 50 52" xmlns="http://www.w3.org/2000/svg">
            <title>Logomark</title><path d="M49.626 11.564a.809.809 0 0 1 .028.209v10.972a.8.8 0 0 1-.402.694l-9.209 5.302V39.25c0 .286-.152.55-.4.694L20.42 51.01c-.044.025-.092.041-.14.058-.018.006-.035.017-.054.022a.805.805 0 0 1-.41 0c-.022-.006-.042-.018-.063-.026-.044-.016-.09-.03-.132-.054L.402 39.944A.801.801 0 0 1 0 39.25V6.334c0-.072.01-.142.028-.21.006-.023.02-.044.028-.067.015-.042.029-.085.051-.124.015-.026.037-.047.055-.071.023-.032.044-.065.071-.093.023-.023.053-.04.079-.06.029-.024.055-.05.088-.069h.001l9.61-5.533a.802.802 0 0 1 .8 0l9.61 5.533h.002c.032.02.059.045.088.068.026.02.055.038.078.06.028.029.048.062.072.094.017.024.04.045.054.071.023.04.036.082.052.124.008.023.022.044.028.068a.809.809 0 0 1 .028.209v20.559l8.008-4.611v-10.51c0-.07.01-.141.028-.208.007-.024.02-.045.028-.068.016-.042.03-.085.052-.124.015-.026.037-.047.054-.071.024-.032.044-.065.072-.093.023-.023.052-.04.078-.06.03-.024.056-.05.088-.069h.001l9.611-5.533a.801.801 0 0 1 .8 0l9.61 5.533c.034.02.06.045.09.068.025.02.054.038.077.06.028.029.048.062.072.094.018.024.04.045.054.071.023.039.036.082.052.124.009.023.022.044.028.068zm-1.574 10.718v-9.124l-3.363 1.936-4.646 2.675v9.124l8.01-4.611zm-9.61 16.505v-9.13l-4.57 2.61-13.05 7.448v9.216l17.62-10.144zM1.602 7.719v31.068L19.22 48.93v-9.214l-9.204-5.209-.003-.002-.004-.002c-.031-.018-.057-.044-.086-.066-.025-.02-.054-.036-.076-.058l-.002-.003c-.026-.025-.044-.056-.066-.084-.02-.027-.044-.05-.06-.078l-.001-.003c-.018-.03-.029-.066-.042-.1-.013-.03-.03-.058-.038-.09v-.001c-.01-.038-.012-.078-.016-.117-.004-.03-.012-.06-.012-.09v-.002-21.481L4.965 9.654 1.602 7.72zm8.81-5.994L2.405 6.334l8.005 4.609 8.006-4.61-8.006-4.608zm4.164 28.764l4.645-2.674V7.719l-3.363 1.936-4.646 2.675v20.096l3.364-1.937zM39.243 7.164l-8.006 4.609 8.006 4.609 8.005-4.61-8.005-4.608zm-.801 10.605l-4.646-2.675-3.363-1.936v9.124l4.645 2.674 3.364 1.937v-9.124zM20.02 38.33l11.743-6.704 5.87-3.35-8-4.606-9.211 5.303-8.395 4.833 7.993 4.524z" fill="#FF2D20" fill-rule="evenodd"/></svg>
        </a>

        <form action="?" method="get" />
        <select name="v" onchange="this.form.submit()">
            <option value="6.0" <?php echo ($laravelVersion == '6.0') ? 'selected' : '' ?>>Laravel 6.0 Latest</option>
            <option value="5.8" <?php echo ($laravelVersion == '5.8') ? 'selected' : '' ?>>Laravel 5.8</option>
            <option value="5.7" <?php echo ($laravelVersion == '5.7') ? 'selected' : '' ?>>Laravel 5.7</option>
            <option value="5.6" <?php echo ($laravelVersion == '5.6') ? 'selected' : '' ?>>Laravel 5.6</option>
            <option value="5.5" <?php echo ($laravelVersion == '5.5') ? 'selected' : '' ?>>Laravel 5.5 LTS</option>
            <option value="5.4" <?php echo ($laravelVersion == '5.4') ? 'selected' : '' ?>>Laravel 5.4</option>
            <option value="5.3" <?php echo ($laravelVersion == '5.3') ? 'selected' : '' ?>>Laravel 5.3</option>
            <option value="5.2" <?php echo ($laravelVersion == '5.2') ? 'selected' : '' ?>>Laravel 5.2</option>
            <option value="5.1" <?php echo ($laravelVersion == '5.1') ? 'selected' : '' ?>>Laravel 5.1 LTS</option>
            <option value="5.0" <?php echo ($laravelVersion == '5.0') ? 'selected' : '' ?>>Laravel 5.0</option>
            <option value="4.2" <?php echo ($laravelVersion == '4.2') ? 'selected' : '' ?>>Laravel 4.2</option>
        </select>
        </form>

        <h1>Server Requirements.</h1>

        <p>
            PHP <?php
                if (is_array($reqList[$laravelVersion]['php'])) {
                    $phpVersions = array();
                    foreach ($reqList[$laravelVersion]['php'] as $operator => $version) {
                        $phpVersions[] = "{$operator} {$version}";
                    }
                    echo implode(" && ", $phpVersions);
                } else {
                    echo ">= " . $reqList[$laravelVersion]['php'];
                }

                echo " " . ($requirements['php_version'] ? $strOk : $strFail); ?>
            (<?php echo PHP_VERSION; ?>)
        </p>

        <?php if ($reqList[$laravelVersion]['bcmath']) : ?>
            <p>BCMath PHP Extension <?php echo $requirements['bcmath_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif; ?>

        <?php if ($reqList[$laravelVersion]['openssl']) : ?>
            <p>OpenSSL PHP Extension <?php echo $requirements['openssl_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif; ?>

        <?php if ($reqList[$laravelVersion]['pdo']) : ?>
            <p>PDO PHP Extension <?php echo $requirements['pdo_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($reqList[$laravelVersion]['mbstring']) : ?>
            <p>Mbstring PHP Extension <?php echo $requirements['mbstring_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($reqList[$laravelVersion]['tokenizer']) : ?>
            <p>Tokenizer PHP Extension <?php echo $requirements['tokenizer_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>


        <?php if ($reqList[$laravelVersion]['xml']) : ?>
            <p>XML PHP Extension <?php echo $requirements['xml_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($reqList[$laravelVersion]['ctype']) : ?>
            <p>CTYPE PHP Extension <?php echo $requirements['ctype_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($reqList[$laravelVersion]['json']) : ?>
            <p>JSON PHP Extension <?php echo $requirements['json_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if ($reqList[$laravelVersion]['mcrypt']) : ?>
            <p>Mcrypt PHP Extension <?php echo $requirements['mcrypt_enabled'] ? $strOk : $strFail; ?></p>
        <?php endif ?>

        <?php if (!empty($reqList[$laravelVersion]['obs'])) : ?>
            <p class="obs"><?php echo $reqList[$laravelVersion]['obs'] ?></p>
        <?php endif; ?>


        <p>magic_quotes_gpc: <?php echo !ini_get('magic_quotes_gpc') ? $strOk : $strFail; ?> (value: <?php echo ini_get('magic_quotes_gpc') ?>)</p>
        <p>register_globals: <?php echo !ini_get('register_globals') ? $strOk : $strFail; ?> (value: <?php echo ini_get('register_globals') ?>)</p>
        <p>session.auto_start: <?php echo !ini_get('session.auto_start') ? $strOk : $strFail; ?> (value: <?php echo ini_get('session.auto_start') ?>)</p>
        <p>mbstring.func_overload: <?php echo !ini_get('mbstring.func_overload') ? $strOk : $strFail; ?> (value: <?php echo ini_get('mbstring.func_overload') ?>)</p>

    </div>
</body>

</html>
