<?PHP

/*
 * HOW TO INSTALL THIS INSTALLER
 *
 *
 */
//login with ssh to the webserver
//move to the root folder of your application, most of the time: accountsname/domainname.com/

//enter command:
//git clone git://github.com/lucfranken/CmsToolInstaller.git

//CHECK THE RESULT!: You now should have: accountsname/domainname.com/CmsToolInstaller/install.php
//IF NOT DO NOT PROCEED, REMOVE ALL and try again

//run the install.php script

echo 'CmsToolInstaller starting step 1/2'."\n\n";

//check this can only be run from CLI
if(PHP_SAPI != 'cli') {
	die('Install only directly on server allowed.');
}


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
$pluginsDir=$domainDir.'pluginsmanaged/';

//temporary directory to clone cakephp in
$tmpCakeDir=$domainDir.'caketmp/';

//Application directory to put the template in
$appDir=$domainDir.'app/';

/*
var_dump($currentDir);
var_dump($hostingDir);
var_dump($domainDir);
var_dump($sshDir);
var_dump($pluginsDir);
var_dump($tmpCakeDir);
var_dump($appDir);
*/
echo 'CmsToolInstaller will be installing in:
  '.$domainDir."\n\n";


/*
 * Check and configure directories
 *
 *
 */
echo 'SSH directory setup in: '.$sshDir."\n\n";
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
if(!file_exists($sshDir.'github.pub')) {
	echo 'GitHub SSH key not available so generating'."\n\n";
	
	//install ssh key
	$command='ssh-keygen -t rsa -N "" -f '.$sshDir.'github';
	shell_exec($command);
	
	//copy config file
	copy('sshconfig/config', $sshDir.'config');
	
	echo 'SSH key generated!'."\n\n";
	
	
	echo 'The following key needs to be added to the GitHub account:'."\n\n";
	
	echo file_get_contents($sshDir.'github.pub')."\n\n";
}

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
if(!is_dir($domainDir.'lib')) {
	echo 'Start downloading and installation of CakePHP'."\n\n";
	
	$command='git clone git://github.com/cakephp/cakephp.git '.$tmpCakeDir;
	shell_exec($command);
	
	//move lib folder to definitive location
	shell_exec('mv '.$tmpCakeDir.'lib'.' '.$domainDir.'lib');
	
	//move htaccess file
	shell_exec('mv '.$tmpCakeDir.'.htaccess'.' '.$domainDir.'.htaccess');
	
	//remove the tmp CakePHP folder
	shell_exec('rm -Rf '.$tmpCakeDir);
	echo 'Installation of CakePHP done'."\n\n";
}

/*
 * Create plugins directory
 *
 * Creates a directory and readme for the plugins.
 *
 */
@mkdir($pluginsDir);

//write a note that no one should install plugins here manually
file_put_contents($pluginsDir.'README.txt', 'WARNING: Do not install plugins here manually, plugins in here are automatically installed.');

echo 'Created plugins directory'."\n\n";


/*
 * Finalize and inform user
 *
 *
 */
echo 'CmsToolInstaller

Installation complete. Congratulations!

Your next steps:

1. Add following SSH key to the account

';

echo file_get_contents($sshDir.'github.pub');

echo '

2. After adding the key run php install2.php for installation of the first plugins.

';





