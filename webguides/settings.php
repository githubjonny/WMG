<?php
// Add the settings page to the navigation block
//$settings = new admin_settingpage(
//    'local_webguides', 
//    get_string('pluginname', 'local_webguides')
//);
//$ADMIN->add('localplugins', $settings);

// defined('MOODLE_INTERNAL') || die;


$external = new admin_externalpage('local_webguides', "WMG Admin", $CFG->wwwroot . '/local/webguides/index.php');
$ADMIN->add('modules', $external); // <- Is there something other than 'modules' to put it under blocks?


?>
