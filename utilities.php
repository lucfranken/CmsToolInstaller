<?PHP

/*
 * CmsTool Installer Utilities
 *
 * Utilities for cross-platform modifications.
 *
 */

function rrmdir($path) {
	if(!file_exists($path)) {
		throw new RecursiveDirectoryException('Directory doesn\'t exist.');
	}
	
	$directoryIterator = new DirectoryIterator($path);

	foreach($directoryIterator as $fileInfo) {
		$filePath = $fileInfo->getPathname();

		if(!$fileInfo->isDot()) {
			if($fileInfo->isFile()) {
				unlink($filePath);
			}
			else if($fileInfo->isDir()) {
				if( !rmdir($filePath) ) {
					rrmdir($filePath);
				}
			}
		}
	}
	
	rmdir($path);
}