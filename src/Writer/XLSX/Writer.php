<?php

namespace Rocky114\Excel\Writer\XLSX;

use Rocky114\Excel\Common\FunctionHelper;
use Rocky114\Excel\Common\ZipHelper;
use Rocky114\Excel\Writer\XLSX\Style\Style;

class Writer
{
    protected static $headerContentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

    protected $fileHandle;

    protected $zipHelper;
    protected $workbook;

    protected $outputFilename;

    protected $columnType;

    protected $tempFolder;

    protected $style;

    public function __construct(array $config = [])
    {
        $this->tempFolder = isset($config['temp_folder']) ? $config['temp_folder'] : sys_get_temp_dir();

        $this->zipHelper = new ZipHelper();
        $this->workbook = new Workbook();

        $this->style = new Style;
    }

    public function openToFile($filename, $dir)
    {

    }

    public function openToBrowser($filename)
    {
        if (FunctionHelper::isXLSXFile($filename)) {
            throw new \Exception('filename extension error');
        }

        $this->outputFilename = $filename;

        functionHelper::flushBuffer();

        $this->fileHandle = fopen('php://output', 'w');

        header('Content-Type: ' . 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $this->outputFilename . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        return $this;
    }

    public function addRow()
    {

    }

    public function addRows()
    {

    }

    public function addSheet()
    {

    }

    public function setColumnType(Type $type, Sheet $sheet = null)
    {
        $this->columnType = $type;

        return $this;
    }

    public function getCurrentSheet()
    {

    }

    public function setCurrentSheet()
    {

    }

    public function setStyle()
    {

    }

    public function close()
    {
        $this->zipHelper->writeToZipArchive($this->workbook);
    }
}