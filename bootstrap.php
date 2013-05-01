<?php
/**
 * Fuel Google Two-step verification Package
 *
 * @copyright  2013 Yusuke NAKA
 * @license    MIT License
 *
 */

Autoloader::add_core_namespace('G2verify');

Autoloader::add_classes(array(

	'G2verify\\G2verify'                => __DIR__.'/classes/g2verify.php',
	'G2verify\\G2verify_Driver'         => __DIR__.'/classes/g2verify/driver.php',
	'G2verify\\G2verify_Base32'         => __DIR__.'/classes/g2verify/base32.php',

));
