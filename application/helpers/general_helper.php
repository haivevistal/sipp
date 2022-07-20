<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function initialize_elfinder($value=''){
	$CI =& get_instance();
	$CI->load->helper('path');
	$opts = array(
	    'debug' => true, 
	    'roots' => array(
	      array( 
	        'driver' => 'LocalFileSystem', 
	        'path'   => $_SERVER['DOCUMENT_ROOT'].'/assets/plugins/elFinder/files', 
	        'URL'    => $_SERVER['DOCUMENT_ROOT'].'/assets/plugins/elFinder/php/connector.minimal.php', 
	        // more elFinder options here
	      ),
          array(
            'driver'        => 'MySQL',
            'host'          => 'localhost',
            'socket'        => '/tmp/mysql.sock',
            'user'          => 'ebookingsystems_sipp',
            'pass'          => '*eQYH38seNKb',
            'db'            => 'ebookingsystems_sipp',
            'files_table'   => 'elfinder_file',
            'path'          => 1,
            'tmpPath'       => '/tmp'
          )
	    )
	);

	return $opts;
}
?>