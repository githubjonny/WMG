<?php
// Standard config file and local library.

require_once(__DIR__ . '/../../config.php');
require_capability('local/webguides:view', context_system::instance());








// Setting up the page.
$PAGE->set_context(context_system::instance());
$PAGE->set_pagelayout('standard');
$PAGE->set_title("WebsiteMigrationGuides.com Plugin Backup Tool");
$PAGE->set_heading("WebsiteMigrationGuides.com Plugin Backup Tool");
$PAGE->set_url(new moodle_url('/local/webguides/index.php'));
header('Cache-Control: no-cache');

// Ouput the page header.
echo $OUTPUT->header();
?>

<style>
    #page-navbar {display:none;!important}
    #page-header {display:none;!important}
    .smalltext {
        font-size:13px;
    }
    .breakword {
        word-break: break-all;
    }
</style>

<div class="jumbotron text-center" style="padding:20px 0px 10px 0px; margin:0px 0 20px 0; background:#2B7A78; background-image: url('background.jpg');">
    <a href="https://websitemigrationguides.com?moodleplugin"><img src="https://websitemigrationguides.com/website-migration-guides.png" style="padding-bottom:10px;"><h1 style="border:none!important; padding:none!important; color:#fff!important; ">WebsiteMigrationGuides.com</h1></a>
    <p style="color:#fff!important;">Moodle Plugin Backup Script</p> 
</div>

<div class="container" style="text-align:left;">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td width="50%">WMG Plugin Version:</td>
                <td>0.1.1</td>
            </tr>
            <tr>
                <td>Your Moodle Version</td>
                <td><?php $coreVersion = get_config( '', 'version' ); echo $coreVersion;?></td>
            </tr>
            <tr>
                <td>Your Moodle data folder (full path)</td>
                <td><?php $datafolder = $CFG->dataroot; echo $datafolder;?>/</td>
            </tr>            
            <tr>
                <td>Your Moodle site location (where the config.php is located)</td>
                <td>
                    
                    <?php 
                    $fullpath=getcwd();
                    $moodle_config_path= str_replace('local/webguides', '', $fullpath);
                    echo $moodle_config_path;
                    ?>
                    
                </td>
            </tr>            
            
        </tbody>
    </table>

    <h2>What is it and what does it do?</h2>
    <p>When you are upgrading moodle, you need to locate and copy any non-default plugins you have added to your moodle site (e.g. a Theme or Analylitcs plugin). This can be a laborious task if you have a lot of plugins and they are stored in various locations.</p>
    <p>This plugin removes the need to manually locate and copy all of the additional plugins you have installed onto your site. With one click, it will locate the folders where the plugins are installed and make a direct copy of them into a folder called WMGBackup. You can then copy the contents of this folder into your new moodle install.</p>
    <p>This Plugin will provide:</p>
        <ul>
            <li>A list of plugins that did not come shipped with moodle by default (the plugins you have installed).</li>
            <li>The folder location where the plugin's files are stored.</li>
            <li>The ability to back up all of your non default moodle plugins files/folders which you can then drop straight into your new moodle install.</li>
        </ul>
    <p>For plugins that have more than one folder, the plugin will be repeated.</p>
    <p>As always, we suggest manually checking plugin directories are correct and that none have been missed. However, the below should speed up the folder detection process.</p>

    <div class="alert alert-danger" role="alert">
        <h2>IMPORTANT:</h2>
            <ul>
                <li>This plugin is distributed in the hope that it will help you when upgrading moodle. It comes WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. </li>
                <li>Do not leave this plugin on your hosting as it may be a security risk. Use it only to collect the required information and back up the plugin folders. As such <b>treat this plugin as if it is open to security exploits</b>. </li>
                <li>Do not copy it to your new moodle install. </li>
                <li>This plugin was created to function on a linux platform.</li>
                <li>Please make sure that you have made a complete tested backup of your moodle site before proceeding. </li>
                <li>This plugin was designed to help you when upgrading moodle. I can not guarantee everything will be correct or even if it will work so always check everything manually. </li>
                <li>Always test this plugin on a copy of your moodle site (e.g. a non live version). </li>
            </ul>
    </div>
    
    <h2>How do I use it?</h2>
        <ol>
            <li>First, back up your site and database.</li>
            <li>You should see a list of all the plugins you have added to your moodle site below plus the corresponding folders.</li>
            <li>Click the 'create copy' link next to each plugin to make a copy of the plugin's files and folders. They will be copied to a folder called WMGBackup in your hosting's public folder (usually public_html, htdocs or www). It will also copy the folders recursively (so all the folders and files for that particular plugin).</li>
            <li>Move the contents of the WMGBackup folder (not the WMGBackup folder itself) to your new moodle install. e.g. the same location as your new moodle's config.php file. To make this easy to do, I have added a zip function at the bottom of the page. This will zip up all the modules you have created a copy of and provide it as a download.</li>
            <li>Optional : To speed up the migration, I have also provided you with a link to download your config.php file (since you will need to replace the new config.php file in your upgrade with your current one).</li>
        </ol>

    <h2 id="plugins">Step1 : Generate copies of your plugins</h2>
    <p>Below are a list of your non default moodle plugins. To generate a copy of the plugin (and all its required files) click the "create copy" button. In the "Installed Version" column you will see the version number of the plugin. Click the "Check supported versions" link to make sure the plugin is the latest version and can run on the version of moodle you are upgrading to.</p>

    <table class="table table-bordered" width="100%">
        <tbody>
            <tr>
		        <td>
		        <p>Plugin Name</p>
		        </td>
		        
		        <td>
		        <p>Installed Version</p>
		        </td>
		        <td>
		        <p>Plugin folder path</p>
		        </td>
            </tr>
		
		<?php
        // script loop to collect the plugin details
        $plugintypes = core_component::get_plugin_types();

        foreach ($plugintypes as $plugintype => $plugintypedir) {
	        $plugins = core_component::get_plugin_list($plugintype);
	        $standardplugins = core_plugin_manager::standard_plugins_list($plugintype);

	            foreach ($plugins as $pluginname => $directory) {
		            if ($pluginname == "webguides" OR $standardplugins !== false && in_array($pluginname, $standardplugins))  {
			        continue;
		            }
		
                     //echo $plugintype . "<br>"; //This will echo the type of plugin e.g. block, filter, auth
                     //echo $pluginname . "<br>"; //This will echo the plugin name e.g. googleauth2
        ?>
		
		    
		    <tr>
		    
		        <td class="smalltext" >
                <?php
                    $plugin = $plugintype. '_' . $pluginname;  //  The plugin type with an _ followed by the plugin name e.g. auth_googleauth2.
                    $plugin_name = get_string('pluginname',$plugin); // This collects the proper plugin name as seen in the moodle admin e.g. Oauth2 using the $plugin variable.
                 $version = get_config($plugin, 'version');
                 
                
                 
            		echo $plugin_name; // display the plugin name
		            echo "<br>(".$plugin.")";
                ?>
		        </td>

				<td width="16%" class="smalltext">
				    <?php echo $version;?> 
				    <br><a href="https://moodle.org/plugins/pluginversions.php?plugin=<?php echo $plugin ?>" target="new">Check supported versions</a>
				</td>
		        <td class="smalltext breakword">
		            <?php echo $directory; ?>
		        </td>
		        <td>
                <?php

                $the_plugin_folder_path = $directory;
                // converts the moodle directory from a var called $directory to $the_plugin_folder_path. Purely for ease of reading. Shown in col 3 "plugin folder path"
                // echo $the_plugin_folder_path;
                // e.g. /home/domain/public_html/mod/kalmediares

                $the_current_folder = getcwd();
                // Full server path to the moodle folder converted into a var called $thecurrentfolder 
                // e.g. /home/domain/public_html/local/webguides


                // Next we remove the /local/webguides from the $thecurrentfolder
                $the_current_folder_without_local_webguides = str_replace('local/webguides', '', $the_current_folder);
                // e.g. /home/domain/public_html/


                // New we remove $the_current_folder_without_local_webguides from $the_current_folder
                // e.g. /home/domain/public_html/ from /home/ourmessa/public_html/mod/kalmediares
                $the_location_for_the_backup_inc_sub_folders = str_replace($the_current_folder_without_local_webguides, '', $the_plugin_folder_path);

                $backupfolder = "WMGBackup/"; 
                // $backupfolder = the folder where the backup of the plugins will go. 
                // If you want a different folder you can change this. This could be updated later to use an input from the user to specify their own desired folder.

                // this collects the name of the folder that moodle is installed into.
                $the_public_folder_name = basename(getcwd());
                // e.g. /home/domain/public_html/

                // this creates the full path for the backup folder plus any additional folders for
                // the plugin. e.g. if your plugin is in folder/1/3/4 it will create 
                // WMGbackup/folder/1/3/4/
                $combine = $the_current_folder_without_local_webguides.$backupfolder.$the_location_for_the_backup_inc_sub_folders;

                //returns the current URL where this file is located. This is passed on via the URL GET so the user can return to this page after coping the plugin.
                $moodleconfiglocationhttpurl = $_SERVER['REQUEST_URI']; 
                $parts = explode('/',$moodleconfiglocationhttpurl);
                $dir = $_SERVER['SERVER_NAME'];
                for ($i = 0; $i < count($parts) - 1; $i++) {
                    $dir .= $parts[$i] . "/";
                }   

                // checks/assigns http or https
                $protocol = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://';

                echo "<a class=\"btn btn-outline-primary btn-sm\" href='wmg-create.php?dst=$combine&src=$directory&return=$protocol$dir'>Create Copy</a></td>";
				
				echo "<td>";
		            
		            if(file_exists($combine)) 
                    echo "<img src=\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA3OTI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA2MTIgNzkyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM0MUFENDk7fQo8L3N0eWxlPjxnPjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01NjIsMzk2YzAtMTQxLjQtMTE0LjYtMjU2LTI1Ni0yNTZTNTAsMjU0LjYsNTAsMzk2czExNC42LDI1NiwyNTYsMjU2UzU2Miw1MzcuNCw1NjIsMzk2TDU2MiwzOTZ6ICAgIE01MDEuNywyOTYuM2wtMjQxLDI0MWwwLDBsLTE3LjIsMTcuMkwxMTAuMyw0MjEuM2w1OC44LTU4LjhsNzQuNSw3NC41bDE5OS40LTE5OS40TDUwMS43LDI5Ni4zTDUwMS43LDI5Ni4zeiIvPjwvZz48L3N2Zz4=\" height=\"35px\";>";
                    else {
                    echo "<img src=\"data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/PjxzdmcgaWQ9IkxheWVyXzEiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDYxMiA3OTI7IiB2ZXJzaW9uPSIxLjEiIHZpZXdCb3g9IjAgMCA2MTIgNzkyIiB4bWw6c3BhY2U9InByZXNlcnZlIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIj48c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiNFNDQwNjE7fQo8L3N0eWxlPjxnPjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01NjIsMzk2YzAtMTQxLjQtMTE0LjYtMjU2LTI1Ni0yNTZTNTAsMjU0LjYsNTAsMzk2czExNC42LDI1NiwyNTYsMjU2UzU2Miw1MzcuNCw1NjIsMzk2TDU2MiwzOTZ6IE0zNTYuOCwzOTYgICBMNDc1LDUxNC4yTDQyNC4yLDU2NUwzMDYsNDQ2LjhMMTg3LjgsNTY1TDEzNyw1MTQuMkwyNTUuMiwzOTZMMTM3LDI3Ny44bDUwLjgtNTAuOEwzMDYsMzQ1LjJMNDI0LjIsMjI3bDUwLjgsNTAuOEwzNTYuOCwzOTYgICBMMzU2LjgsMzk2eiIvPjwvZz48L3N2Zz4=\" height=\"35px\";>";
                    }
    
        	    }
	        }
		echo "</tr></table></p>";
        ?>
        
        <h2 id="download">Step 2 : Generate a Zip File of your plugin backups</h2>
        <p>Click the below button to generate a zip file of all the plugins you have created copies of in step one. If you make any changes to step one, you will need to click the below button again to update the zip.</p>
        


<p>
    <?php if(file_exists("WMGBackup.zip")) 
        echo "<a href=\"zipup.php?saveto=$the_current_folder_without_local_webguides$backupfolder&return=$dir\" class=\"btn btn-outline-warning btn-sm\">Regenerate the zip</a>";
        else {
        echo "<a href=\"zipup.php?saveto=$the_current_folder_without_local_webguides$backupfolder&return=$dir\" class=\"btn btn-outline-primary btn-sm\">Generate a zip</a>";
        } 
    ?>
    <?php if(file_exists("WMGBackup.zip")) 
        echo "<a href=\"WMGBackup.zip\" class=\"btn btn-outline-success btn-sm\">Download the zip</a>";
         
    ?>
    </p>
        <h2 id="download">Step 3 (optional): Download config.php backup</h2>
        <p>As well as a copy of your plugins, you will also need to copy your moodle's config.php file from your old moodle install to the new one. For your convenience, you can use the below button to download a copy of your current config.php file.</p>
   <a href="config_backup.php" class="btn btn-outline-primary btn-sm" target="_NEW">Download config.php</a>
    
    
    
    </div>
<?php echo $OUTPUT->footer();?>