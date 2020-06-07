<?
// main Paths
define('ASSETS_PATH', '../assets/');
define('CONTROLLER_PATH', '../controller/');
define('MODELS_PATH', '../models/');
define('DOC_PATH', '../docs/');

// sub Paths
define('CSS_PATH', ASSETS_PATH.'css/');

// Images
define('IMAGE_PATH',ASSETS_PATH.'images/');
define('PAGE_IMAGE_PATH',IMAGE_PATH.'pageImages/');
define('PICTURE_RASTER_PATH',IMAGE_PATH.'pictureRaster/');
define('ERROR_GIF_PATH',IMAGE_PATH.'errorGif/');
define('USER_PICTURE_PATH', IMAGE_PATH.'upload/users/');

// Password Hash
define('PEPPER', '.m9h-RL=^M/72;tdU\Bz');
define('HASHOPTIONS', $options = ['cost' => 13]);