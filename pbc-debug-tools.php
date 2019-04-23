<?php
/**
 * Plugin Name
 *
 * @package     Powered By Coffee Debug Tools
 * @author      Stewart Ritchie
 * @copyright   2019 Powered By Coffee
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: Powered By Coffee Debug Tools
 * Plugin URI:  https://poweredbycoffee.co.uk
 * Description: Description of the plugin.
 * Version:     1.0.0
 * Author:      stewarty
 * Author URI:  https://poweredbycoffee.co.uk
 * Text Domain: pbc-debug-tools
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */



use \Exception as BaseException;
use \Whoops\Handler\PrettyPageHandler;
use \Whoops\Run;

$whoops = new \Whoops\Run;
$whoops->silenceErrorsInPaths([ABSPATH . "/content/plugins"]);
$handler = new PrettyPageHandler();
$handler->setApplicationPaths([__FILE__]);
$whoops->pushHandler($handler);
$whoops->register();







//throw new Exception("Something broke!");
//askdk

function pbc_backtrace(){
	
	$trace = debug_backtrace();

	//echo "<pre>";
	//var_dump($trace);

	echo "<table>";

	foreach($trace as $key => $line){

		if($line['function'] == "pbc_backtrace"){
			continue;
		}

		if(($line['function'] == "do_action") && (($line['class'] == "WP_Hook") )){
			continue;
		}

		echo "<tr style='background-color:#f5f5f5;'>";
			echo "<td>";
				echo $line['function'];
				if($line['function'] == "do_action"){
					echo " [" . $line['args'][0] . "]";
				}
			echo "</td>";

			echo "<td>";
				echo (isset($line['class']) ? $line['class'] : "" );
			echo "</td>";

			echo "<td>";
				echo (isset($line['type']) ? $line['type'] : "" );
			echo "</td>";

			echo "<td>";
				echo (isset($line['file']) ? $line['file'] : "" );
			echo "</td>";
		echo "</tr>";
	}

	echo "</table>";
	
}


function pbc_dump($trace, $kill = false){

	echo "<pre>";
	var_dump($trace);
	echo "</pre>";

	if($kill == true){
		die();
	}
}

function pbc_log($log){
	write_log($log);
}


if ( ! function_exists('write_log')) {
   function write_log ( $log )  {
      if ( is_array( $log ) || is_object( $log ) ) {
         error_log( print_r( $log, true ) );
      } else {
         error_log( $log );
      }
   }
}

