<?php
ini_set("gd.jpeg_ignore_warning", 1);
ini_set('memory_limit', '4000M');
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
	
		// set_time_limit(-1);
		// /*
		// //$config['image_library'] = 'gd2';
		// 	$config['create_thumb'] = TRUE;
		// 	$config['maintain_ratio'] = TRUE;
		// 	//$config['width']         = 128 - 20;
		// 	$config['height']       = 165 - 20;
		// 	$config['mater_dim'] = 'auto';
		// 	$comfig['source_image'] = FCPATH.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'books'.DIRECTORY_SEPARATOR.$file;
			
		// 	$this->load->library('image_lib', $config);
		// 	if(!$this->image_lib->resize())
		// 		echo $this->image_lib->display_errors();
			
		// 	$this->image_lib->clear();
		// */
		// $files = @scandir(FCPATH.'assets/img/books');
		// unset($files[0]);
		// unset($files[1]);
		// foreach($files as $file)
		// {
		// 	if(strpos($file, '_thumb') || !file_exists(FCPATH.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'books'.DIRECTORY_SEPARATOR.$file)) continue;

		// 	$width = 128 - 20;
		// 	$height = 165 - 20;
		// 	$filename =  FCPATH.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'books'.DIRECTORY_SEPARATOR.$file;
		// 	$basename = basename($filename, '.jpg');
		// 	// load image
		// 	[$realW, $realH] = getimagesize($filename);
		// 	// Load
		// 	$thumb  = imagecreatetruecolor($width, $height);
		// 	$source = imagecreatefromjpeg($filename);
		// 	imagecopyresized($thumb, $source, 0, 0, 0, 0, $width, $height, $realW, $realH);
		// 	imagejpeg($thumb, FCPATH.'assets'.DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.'books'.DIRECTORY_SEPARATOR.$basename.'_thumb.jpg');
			
		// }

		$this->load->view('welcome_message');
	}
}
