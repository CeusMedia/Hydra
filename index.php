<?php
require_once 'vendor/autoload.php';
require_once 'vendor/ceus-media/common/compat.php';

define( 'CMC_PATH', 'vendor/ceus-media/common/src/' );
define( 'CMF_PATH', 'vendor/ceus-media/hydrogen-framework/src/' );

Loader::registerNew( 'php5', 'Tool_Hydrogen_Setup_', 'classes/' );
Loader::registerNew( 'php5', '', 'classes/' );

/*  --  RUN APPLICATION  --  */
try{
	Tool_Hydrogen_Setup_App::$classEnvironment		= "Tool_Hydrogen_Setup_Environment";
	Tool_Hydrogen_Setup_Environment::$configFile		= "config/config.ini";
	$app	= new Tool_Hydrogen_Setup_App();
	$app->run();
}
catch( Exception $e ){
	UI_HTML_Exception_Page::display( $e );
}
?>
