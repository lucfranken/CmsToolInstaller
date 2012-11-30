<?PHP

/*
 * CmsTool Installer Configuration
 *
 * Generates configuration of paths needed for the installer steps.
 *
 */

//check this can only be run from CLI
if(PHP_SAPI != 'cli') {
	die('Install only directly on server allowed.');
}

//directory from which the installer is started
$currentDir=dirname(__FILE__);
if(basename($currentDir)!='CmsToolInstaller') {
	die('Run this script from directory CmsToolInstaller');
}

//ROOT directories as explained above
$hostingDir=realpath($currentDir.'/../../').'/';
$domainDir=realpath($currentDir.'/../').'/';

//specific directories
$sshDir=$hostingDir.'.ssh/';
$pluginsDir=$domainDir.'pluginsmanaged/';

//temporary directory to clone cakephp in
$tmpCakeDir=$domainDir.'caketmp/';

//Application directory to put the template in
$appDir=$domainDir.'app/';

