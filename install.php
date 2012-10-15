<?PHP

/*
 * HOW TO INSTALL THIS INSTALLER
 *
 *
 */
//login with ssh to the webserver
//move to the root folder of your application, most of the time: accountsname/domainname.com/

//enter command:
//git clone git@github.com:lucfranken/CmsToolInstaller.git

//CHECK THE RESULT!: You now should have: accountsname/domainname.com/CmsToolInstaller/install.php
//IF NOT DO NOT PROCEED, REMOVE ALL and try again

//run the install.php script

//check this can only be run from CLI
if(PHP_SAPI != 'cli') {
	die('Install only directly on server allowed.');
}

/*
 * HOW TO USE
 *
 *
 */
 
//go to the directory of the website, for example /schijvens/schijvens.nl/
//cd schijvens
//cd schijvens.nl


/*
 * Works with structure as explained above only
 *
 */
//directory from which the installer is started
$currentDir=$_SERVER['PWD'];
if(basename($_SERVER['PWD'])!='CmsToolInstaller') {
	die('Run this script from directory CmsToolInstaller');
}

//ROOT directories as explained above
$hostingDir=realpath($_SERVER['PWD'].'/../../').'/';
$domainDir=realpath($_SERVER['PWD'].'/../').'/';

//specific directories
$sshDir=$hostingDir.'.ssh/';
$pluginsDir=$domainDir.'plugins/';

//temporary directory to clone cakephp in
$tmpCakeDir=$domainDir.'caketmp/';

var_dump($currentDir);
var_dump($hostingDir);
var_dump($domainDir);
var_dump($sshDir);
var_dump($pluginsDir);
var_dump($tmpCakeDir);

/*
 * Check and configure directories
 *
 *
 */
@mkdir($sshDir);

if(!is_dir($sshDir)) {
	var_dump($sshDir);
	die('SSH Directory is not available at this path');
}


/*
 * SSH SETUP
 *
 *
 */
//install ssh key
$command='ssh-keygen -t rsa -N "" -f '.$sshDir.'github';
shell_exec($command);

//copy config file
copy('sshconfig/config', $sshDir.'config');


/*
 * CakePHP SETUP
 *
 * We install CakePHP from the GitHub account into a tmp folder. From that
 * folder we move the needed directories for our setup.
 *
 * We create an app_example directory but we suggest using a pre-defined template
 * installation with all CMS presets defined.
 *
 *
 */
 

mkdir($tmpCakeDir);

$command='git clone git://github.com/cakephp/cakephp.git '.$tmpCakeDir;
shell_exec($command);

//move lib folder to definitive location
shell_exec('mv '.$tmpCakeDir.'lib'.' '.$domainDir.'lib');

//move htaccess file
shell_exec('mv '.$tmpCakeDir.'.htaccess'.' '.$domainDir.'.htaccess');

//remove the tmp CakePHP folder
shell_exec('rm -Rf '.$tmpCakeDir);

/*
 * INSTALL CmsTool plugins SETUP
 *
 *
 */
/*
//install first version of repository in plugins directory
$command='git clone git@github.com:lucfranken/CmsTool.git '.$pluginsDir;
shell_exec($command);
*/



/*
 * Finalize and inform user
 *
 *
 */
echo 'CmsToolInstaller

Installation complete. Congratulations!

Your next steps:

1. For updates add following SSH key to GitHub deploy keys:

https://github.com/lucfranken/CmsTool/admin/keys

';

echo file_get_contents($sshDir.'github.pub');

echo '

2. Upload a 

';





