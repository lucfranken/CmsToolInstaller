<?PHP

/*
 * HOW TO INSTALL THIS INSTALLER
 *
 *
 */
//login with ssh to the webserver
//move to the root folder of your application, most of the time: accountsname/domainname.com/

//enter command:
//git clone git@github.com:lucfranken/CmsToolInstaller.git';

//run the install.php script

/*
 * HOW TO USE
 *
 *
 */
 
//go to the directory of the website, for example /schijvens/schijvens.nl/
//cd schijvens
//cd schijvens.nl


$root=$_SERVER['DOCUMENT_ROOT'].'../';
$sshDir=$root.'.ssh/';
$pluginsDir=$_SERVER['DOCUMENT_ROOT'].'plugins/';
//clone command

//install ssh key
$command='ssh-keygen -t rsa -N "" -f '.$sshDir.'github';
shell_exec($command);

//copy config file
copy('config', $sshDir.'config');

//remove plugins directory
rmdir($pluginsDir);

//install first version of repository in plugins directory
$command='git clone git@github.com:lucfranken/CmsTool.git plugins';
shell_exec($command);

echo '<pre>';

echo file_get_contents($sshDir.'github');

echo "\n\n\n";

print_R($_SERVER);