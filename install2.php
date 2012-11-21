<?PHP

require_once('install.php');

echo 'CmsToolInstaller starting step 2/2'."\n\n";

if(!is_dir($pluginsDir)) {
	die('First run install.php to setup the application. Missing pluginsDir.');
}

echo 'Plugins directory found and ok:
  '.$pluginsDir."\n\n";


/*
 * CmsToolTemplate installation
 *
 * Installing the CakePHP template to the /app folder.
 *
 *
 */
echo 'Installing CmsToolTemplate'."\n\n";

$command='git clone git@github.com:lucfranken/CmsToolTemplate.git '.$appDir;
shell_exec($command);
echo 'Installation of CmsToolTemplate complete'."\n\n";


/*
 * CmsToolManager installation
 *
 * Installing the plugin which acts as the manager for the other plugins.
 *
 *
 */
echo 'Installing CmsTool'."\n\n";

$command='git clone git@github.com:lucfranken/CmsTool.git '.$pluginsDir.'CmsTool';
shell_exec($command);

echo 'Installation of CmsTool complete'."\n\n";
