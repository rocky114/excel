<?php

namespace Rocky114\Excel\Writer\Common\Helper;

use Rocky114\Excel\Common\Helper\FileSystemHelperInterface;

/**
 * Class FileSystemHelperInterface
 * This interface describes helper functions to help with the file system operations
 * like files/folders creation & deletion
 */
interface FileSystemWithRootFolderHelperInterface extends FileSystemHelperInterface
{
    /**
     * Creates all the folders needed to create a spreadsheet, as well as the files that won't change.
     *
     * @throws \Rocky114\Excel\Common\Exception\IOException If unable to create at least one of the base folders
     * @return void
     */
    public function createBaseFilesAndFolders();

    /**
     * @return string
     */
    public function getRootFolder();
}
