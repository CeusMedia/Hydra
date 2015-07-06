<?php
function _detectVendorPath(){
	if( file_exists( __DIR__.'/vendor/' ) )
		return 'vendor/';
	$outer	= dirname( dirname( __DIR__ ) );
	if( basename( $outer ) === 'vendor' )
		return $outer.'/';
	die( "Please install using composer!" );
}

$pathLibraries	= _detectVendorPath();

require_once $pathLibraries.'autoload.php';

/*  --  BOOT  --  */
function _cmRealize( $constant, $variable, $default ){
	$var	= isset( $GLOBALS[$variable] ) ? $GLOBALS[$variable] : $default;
	if( strlen( $constant ) ){
		if( !defined( $constant ) )
			define( $constant, $var );
		$var	= constant( $constant );
	}
	return $var;
}
/*  --  LOAD LIBRARIES  --  */
$pathLibraries	= isset( $pathLibraries ) ? $pathLibraries : '/var/www/lib/';
_cmRealize( 'CML_PATH', 'pathLibraries', $pathLibraries );
require_once $pathLibraries.'ceus-media/common/autoload.php';
require_once $pathLibraries.'ceus-media/hydrogen-framework/autoload.php5';
//require_once CML_PATH.'cmModules/'._cmRealize( 'CMM_VERSION', 'versionCMM', 'trunk' ).'/autoload.php5';

/*  --  LOAD CLASS PATHS  --  */
if( isset( $autoloadPaths ) && is_array( $autoloadPaths ) )
	foreach( $autoloadPaths as $library )
		if( $library = (object) array_merge( array( 'path' => NULL, 'exts' => NULL, 'prefix' => NULL ), $library ) )	//  
			Loader::registerNew( NULL, $library->prefix, $library->path );

?>
