
<?php

// Standard config file and local library.

require_once(__DIR__ . '/../../config.php');
require_capability('local/webguides:view', context_system::instance());


//admin_externalpage_setup('local_webguides');


// Setting up the page.

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');

$PAGE->set_title("Copy Completed");

$PAGE->set_heading("Copying...");
$PAGE->set_headingmenu("<img src='animated.gif' class='ring'>");
$PAGE->set_url(new moodle_url('/local/webguides/wmg-create.php'));

// Ouput the page header.
echo "";
echo $OUTPUT->header();

?>





<?php
  $combine = $_GET['dst'];
  $directory = $_GET['src'];
  $returnurl = $_GET['return'];


if (!is_dir($combine)) {
    mkdir($combine, 0755, true);
}



function recurse_copy($src,$dst) {
$dir = opendir($src);
mkdir($dst);
while(false !== ( $file = readdir($dir)) ) {
if (( $file != '.' ) && ( $file != '..' )) {
if ( is_dir($src . '/' . $file) ) {
recurse_copy($src . '/' . $file,$dst . '/' . $file);
}
else {
copy($src . '/' . $file,$dst . '/' . $file);
}
}
}
closedir($dir);
}
$src = $directory;
$dst = $combine;
recurse_copy($src,$dst);
?>
<style>
    #page-navbar {display:none;!important}
    #page-header {display:none;!important}
    .ring {display:none;!important}
</style>
<div class="jumbotron text-center" style="padding:20px 0px 10px 0px; margin:0px 0 20px 0; background:#2B7A78; background-image: url('background.jpg');">
  <a href="https://websitemigrationguides.com?moodleplugin"><img src="https://websitemigrationguides.com/website-migration-guides.png" style="padding-bottom:10px;"><h1 style="border:none!important; padding:none!important; color:#fff!important; ">WebsiteMigrationGuides.com</h1></a>
  <p style="color:#fff!important;">Moodle Plugin Backup Script</p> 
</div>

<div class="container" style="text-align:left;">



<style>

body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 14px;
	color: #333;
}
font
</style>
</head>

<body>

<?php


echo "<p>This plugin's files (and the folders leading up to it) have been copied to:<br>";
echo $dst;
echo "<br>Click the back button to continue</p>";
?>
<p>

<a href="<?php echo $returnurl; ?>#plugins" class="btn btn-outline-secondary btn-sm" >Back</a>
</p>

</div>
<?php echo $OUTPUT->footer(); ?>