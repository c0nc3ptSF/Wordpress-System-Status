<?php
//Upload changes to DB if saved.
if(isset($_POST['ss-message-submit'])){
	
	$ssMessageData = array(
		'message' => wpautop($_POST['ss-system-message']),
		'type' => $_POST['ss-message-type-val'],
		'posttypes' => $_POST['ss-message-apply']
	);
	
	update_option('ss_message_enabled',$_POST['ss-message-enabled']);
	update_option('ss_message_data',$ssMessageData);
	
}

//Pull down DB values.
$ssMessageEnabled = get_option('ss_message_enabled');
$ssMessageData = get_option('ss_message_data');

global $posttypes;
$posttypes = $ssMessageData['posttypes'];

//Setup options in Wordpress if they aren't detected.
if(!$ssMessageEnabled){
	add_option('ss_message_enabled',0,'','yes');
	$ssMessageEnabled = 0;
}

if(!$ssMessageData){
	$ssMessageData = array(
		'message' => '',
		'type' => 0,
		'posttypes' => NULL
	);
	
	add_option('ss_message_data',$ssMessageData,'','no');
	
}

//Switch on or off depending on value
$switch = ($ssMessageEnabled == 0) ? "Disabled" : "Enabled";

?>
<div id="system-status-admin" class="wrap">
    <h2>System Status</h2>
    <form method="post" action="">
        <div id="system-status-wrap">
            <div id="ss-left-col">
                <div id="system-message-setting" class="ss-sec">
                	<div id="ss-message-wrap">
                    	<h3>System Message</h3>
                        <?php wp_editor(stripslashes($ssMessageData['message']),'ss-system-message',array('media_buttons' => false,'textarea_rows' => 8)); ?>
                    </div>
                    <div id="ss-message-controls">
                    	<input type="button" class="button button-large <?php if($ssMessageEnabled == 1) echo "button-primary" ?>" id="ss-message-switch" value="<?php echo $switch; ?>" />
                        <input type="hidden" id="ss-message-enabled" name="ss-message-enabled" value="<?php echo $ssMessageEnabled; ?>" />
                        <div id="ss-message-types">
                        	<h4>Message Type</h4>
                        	<input type="button" class="button ss-message-type <?php if($ssMessageData['type'] == 1) echo "button-primary" ?>" id="ss-message-notice" value="Notice" data-type="1" />
                            <input type="button" class="button ss-message-type <?php if($ssMessageData['type'] == 2) echo "button-primary" ?>" id="ss-message-warning" value="Warning" data-type="2" />
                            <input type="button" class="button ss-message-type <?php if($ssMessageData['type'] == 3) echo "button-primary" ?>" id="ss-message-critical" value="Critical" data-type="3" />
                            <input type="hidden" id="ss-message-type-val" name="ss-message-type-val" value="<?php echo $ssMessageData['type'] ?>" />
                        </div>
                        <div id="ss-message-apply">
                        	<h4>Apply To</h4>
                            <input type="button" id="ss-message-apply-home" class="button ss-message-apply <?php echo $this->postTypeStatus($posttypes['home'],'button'); ?>" value="Home"/>
                            <input type="hidden" id="ss-message-apply-home-val" name="ss-message-apply[home]" value="<?php echo $this->postTypeStatus($posttypes['home'],'value'); ?>" data-posttype="home" />
                            <?php $this->postTypes(); ?>
                        </div>
                        <input type="hidden" name="ss-message-submit" value="1" />
                        <input type="submit" class="button button-primary button-large" id="ss-message-save" value="Save" />
                    </div>
                </div>
            </div>
            <div id="ss-right-col">
            </div>
        </div>
    </form>
</div>