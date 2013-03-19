<?php
// We can also put HTML here

$this->load->view('header');
$this->load->view('nav'); 
echo $content_for_layout; 
$this->load->view('footer');