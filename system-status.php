<?php
/*
Plugin Name: Wordpress System Status
Author: Reactor 5
License: MIT License (http://opensource.org/licenses/MIT)
Description: Allows admins to add system message to pages in Wordpress.
Version: 1.0

The MIT License (MIT)

Copyright (c) 2015 Reactor 5, LLC

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

*/

//Defined variables.
define("SS_DIR",dirname(__FILE__));
define("SS_URI",plugin_dir_url(__FILE__));
define("SS_NAME","System Status");
$systemStatus = new systemStatus;

class systemStatus{
	
	function __construct(){
	
		add_action('admin_menu', array($this,'addWPOption'));
		add_action('admin_enqueue_scripts',array($this,'adminEnqueue'));
	
	}
	
	public function addWPOption(){
		
		add_options_page(SS_NAME,SS_NAME,'manage_options','system-status',array($this,'optionPage'));
		
	}
	
	public function adminEnqueue(){
	
		if($_GET['page']!= 'system-status') return;
		
		wp_enqueue_style('system-status', SS_URI . "/css/system-status.css");
		wp_enqueue_script('system-status-js', SS_URI . "/js/system-status.js",'','',true);
		wp_localize_script('system-status-js','systemStatusLocal',array('ajaxurl' => admin_url( 'admin-ajax.php' )));
	
	}
	
	public function postTypes(){
	
		$posttype_args = array(
			'public' => true,
		);
		$posttypes = get_post_types($posttype_args);
		
		foreach($posttypes as $type){
			if($type == 'attachment') continue;
			
			global $posttypes;
			
			echo "<input type=\"button\" id=\"ss-message-apply-$type\" class=\"button ss-message-apply " .  $this->postTypeStatus($posttypes[$type],'button') . "\" value=\"" . ucfirst($type) . "\"/>";
			echo "<input type=\"hidden\" id=\"ss-message-apply-$type-val\" name=\"ss-message-apply[$type]\" value=\"" . $this->postTypeStatus($posttypes[$type],'value') . "\" />";
		}
	
	}
	
	public function postTypeStatus($data,$mode){
	
		switch($mode){
			case "button":
				if($data == 1) return "button-primary";
				break;
			case "value":
				$data = ($data == 1) ? 1 : 0;
				return $data;
				break;
		}
	
	}
	
	public function optionPage(){
	
		require_once(SS_DIR . "/inc/ss.inc.php");
	
	}
	
	public function systemMessage(){
		
		global $post;
		$home = is_home();
		
		$status = get_option('ss_message_enabled');
		if($status == 0) return;
		
		$data = get_option('ss_message_data');
		$posttypes = $data['posttypes'];
		
		switch($home){
			case true:
				if($posttypes['home'] == 0) return;
				break;
			case false:
				if($posttypes[$post->post_type] == 0) return;
				break;
		}
			
		switch($data['type']){
			case 1:
				$class = "ss-message-notice";
				break;
			case 2:
				$class = "ss-message-warning";
				break;
			case 3:
				$class = "ss-message-critical";
				break;
			default:
				$class = '';
				break;
		}
		
		require_once(SS_DIR . "/inc/system-message.inc.php");
	
	}
	
}

?>