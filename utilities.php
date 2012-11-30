<?PHP

/*
 * CmsTool Installer Utilities
 *
 * Utilities for cross-platform modifications.
 *
 */

/**
 * Remove a directory recursively completely
 *
 * Removes a directory even if there are files in it. It will run through
 * all levels and delete everything in it. In the end it will destroy the
 * directory supplied as $path. So nothing will be left.
 *
 * @param string $path Path to the root of which the delete should start. It will be deleted also.
 * @return void
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
				if(@!rmdir($filePath) ) {
					rrmdir($filePath);
				}
			}
		}
	}
	
	rmdir($path);
}