<?php

/*
 * --------------------------------------------------------------------
 * Đường dẫn ứng dụng
 * --------------------------------------------------------------------
 */

$app_path = dirname(__FILE__);
define('APPPATH', $app_path);
/*
 * --------------------------------------------------------------------
 * Đường dẫn thư mục lõi
 * --------------------------------------------------------------------
 */
$core_folder = 'core';
define('COREPATH', APPPATH . DIRECTORY_SEPARATOR . $core_folder);

/*
 * --------------------------------------------------------------------
 * Đường dẫn thư mục module
 * --------------------------------------------------------------------
 */
$modules_folder = 'modules';
define('MODULESPATH', APPPATH . DIRECTORY_SEPARATOR . $modules_folder);

/*
 * --------------------------------------------------------------------
 * Đường dẫn thư mục trợ giúp (helper)
 * --------------------------------------------------------------------
 */

$helper_folder = 'helper';
define('HELPERPATH', APPPATH . DIRECTORY_SEPARATOR . $helper_folder);

/*
 * --------------------------------------------------------------------
 * Đường dẫn thư viện
 * --------------------------------------------------------------------
 */
$lib_folder = 'libraries';
define('LIBPATH', APPPATH . DIRECTORY_SEPARATOR . $lib_folder);

/*
 * --------------------------------------------------------------------
 * Đường dẫn giao diện (layout)
 * --------------------------------------------------------------------
 */
$layout_folder = 'layout';
define('LAYOUTPATH', APPPATH . DIRECTORY_SEPARATOR . $layout_folder);

/*
 * --------------------------------------------------------------------
 * Đường dẫn cấu hình
 * --------------------------------------------------------------------
 */
$config_folder = 'config';
define('CONFIGPATH', APPPATH . DIRECTORY_SEPARATOR . $config_folder);

require COREPATH . DIRECTORY_SEPARATOR . 'appload.php';
