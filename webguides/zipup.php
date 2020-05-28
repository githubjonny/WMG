
<?php

// Standard config file and local library.

require_once(__DIR__ . '/../../config.php');
require_capability('local/webguides:view', context_system::instance());


//admin_externalpage_setup('local_webguides');


// Setting up the page.

$PAGE->set_context(context_system::instance());

$PAGE->set_pagelayout('standard');

$PAGE->set_title("Zipping Complete");

$PAGE->set_heading("Compressing...");
$PAGE->set_headingmenu("<img src='animated.gif' class='ring'>");
$PAGE->set_url(new moodle_url('/local/webguides/zipup.php'));

// Ouput the page header.

echo $OUTPUT->header();

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






    <?php

    $savetoaddess = $_GET['saveto'];
    $returnurl = $_GET['return'];
    $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';


// Get real path for our folder
$rootPath = realpath($savetoaddess);

// Initialize archive object
$zip = new ZipArchive();
$zip->open('WMGBackup.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

$zip->addFile('backup-generated.txt', 'READ-ME.txt');

// Zip archive will be created only after closing object
$zip->close();

?>

<h1>Zip Completed</h1>
<p>You can download your zip using the button below.</p>
<p><a href="WMGBackup.zip" class="btn btn-outline-success btn-sm">Download Zip</a></p>
<p>For your information, the full path to the zip is <?php echo $savetoaddess?>WMGBackup.zip</p>
<a href="<?php echo $protocol.$returnurl; ?>#download" class="btn btn-outline-secondary btn-sm" >Back</a>
<?php echo $OUTPUT->footer(); ?>

