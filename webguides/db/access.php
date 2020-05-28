<?php 
defined('MOODLE_INTERNAL') || die();

$capabilities = array(

    'local/webguides:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
        ),
    ),

);
?>