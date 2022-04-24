<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function index()
	{

		$this->load->view('auth/verify_otp');
	}

	public function test()
	{
		echo "test 123";
		die();
	}
}