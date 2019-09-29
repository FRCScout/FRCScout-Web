<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//start session
if (session_status() == PHP_SESSION_NONE)
    session_start();

/**
 * CONSTANTS
 */
define('VERSION', '4.0.0');
define('ROOT_DIR', __DIR__);

/**
 * REQUIRED FILES
 */
require_once(ROOT_DIR . '/classes/Keys.php');
require_once(ROOT_DIR . '/classes/Database.php');
require_once(ROOT_DIR . '/classes/tables/Table.php');
require_once(ROOT_DIR . '/classes/tables/local/Users.php');
require_once(ROOT_DIR . '/classes/tables/local/Config.php');
require_once(ROOT_DIR . '/classes/tables/core/CoreConfig.php');
require_once(ROOT_DIR . '/classes/tables/core/Accounts.php');
require_once(ROOT_DIR . '/interfaces/AllianceColors.php');

/**
 * LOAD CONFIGS
 */
if(coreLoggedIn())
    define('DB_NAME', getCoreAccount()->DbId);
else if($_SERVER['SCRIPT_NAME'] != '/index.php' &&
    $_SERVER['SCRIPT_NAME'] != '/api/index.php' &&
    $_SERVER['SCRIPT_NAME'] != '/signup.php' &&
    strpos($_SERVER['REQUEST_URI'], 'ajax') === false)
    header('Location: ' . '/');


if(coreLoggedIn())
{
    foreach (Config::getObjects() as $config)
    {
        define($config->Key, $config->Value);
    }
}

foreach(CoreConfig::getObjects() as $config)
{
    define($config->Key, $config->Value);
}

define('ROOT_URL', 'https://' . $_SERVER['SERVER_NAME']);
define('URL_PATH', ((coreLoggedIn()) ? '/' . getCoreAccount()->TeamId . '/' : '/'));

/**
 * MEDIA FILES
 */
define('ROBOT_MEDIA_DIR', ROOT_DIR . '/assets/robot-media/originals/');
define('ROBOT_MEDIA_THUMBS_DIR', ROOT_DIR . '/assets/robot-media/thumbs/');
define('INCLUDES_DIR', ROOT_DIR . '/includes/');
define('ROBOT_MEDIA_URL', '/assets/robot-media/originals/');
define('ROBOT_MEDIA_THUMBS_URL', '/assets/robot-media/thumbs/');
define('YEAR_MEDIA_URL', '/assets/year-media/');
define('IMAGES_URL', '/assets/images/');
define('CSS_URL', '/css/');
define('JS_URL', '/js/');
require_once(ROOT_DIR . "/classes/Header.php");
require_once(ROOT_DIR . "/classes/NavBar.php");
require_once(ROOT_DIR . "/classes/NavBarArray.php");
require_once(ROOT_DIR . "/classes/NavBarLink.php");
require_once(ROOT_DIR . "/classes/NavBarLinkArray.php");

//set the user var
$user = getUser();

//These are held as placeholders for programming usage
//Primarily so the IDE will auto-complete
if(false)
{
    define('APP_NAME', '');
    define('API_KEY', '');
    define('PRIMARY_COLOR', '');
    define('PRIMARY_COLOR_DARK', '');

    define('BLUE_ALLIANCE_KEY', '');
}

/**
 * Returns if the current page was reuqested back from itself
 * @return bool
 */
function isPostBack()
{
    return $_SERVER['REQUEST_METHOD'] == 'POST';
}

/**
 * Returns if the current user is logged in
 * @return bool
 */
function loggedIn()
{
    return !is_null(getUser());
}

/**
 * Returns if the current user is logged into the core of the app
 * @return bool
 */
function coreLoggedIn()
{
    return !is_null(getCoreAccount());
}

/**
 * Returns the currently logged in user, if any
 * @return Accounts|null
 */
function getCoreAccount()
{
    return !empty($_SESSION['coreAccount']) ? unserialize($_SESSION['coreAccount']) : null;
}

/**
 * Returns the currently logged in user, if any
 * @return Users|null
 */
function getUser()
{
    return !empty($_SESSION['user']) ? unserialize($_SESSION['user']) : null;
}
?>
