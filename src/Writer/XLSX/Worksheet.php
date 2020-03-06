<?php

namespace Rocky114\Spreadsheet\Writer\XLSX;

use Rocky114\Spreadsheet\Common\FileHelper;
use Rocky114\Spreadsheet\Common\FunctionHelper;

class Worksheet
{
    public $id;

    public $name;

    public $filename;

    public $filePath;

    protected $fileHandle;

    protected $typeHandle;

    protected $rowHandle;

    protected $lastWrittenRowIndex = 0;

    protected $workbook;

    protected $columnNumber = 0;

    protected $hasClosed = false;

    protected $hasSetStyle = false;

    protected $mergeCells = [];

    public function __construct($id, $name, Workbook $workbook)
    {
        $this->id = $id;
        $this->name = $name;
        $this->workbook = $workbook;

        $this->filename = FunctionHelper::createUniqueId('.xml');
        $this->filePath = $workbook->temp_folder . $this->filename;
        $this->fileHandle = new FileHelper($this->filePath);

        $this->rowHandle = new Row($this->workbook->getStyle(), $this->id);

        $this->startSheet();
    }

    public function addHeader(array $header, $formats = [])
    {
        $this->columnNumber = count($header);

        if (!empty($formats)) {
            $this->workbook->getStyle()->getType()->setNumberFormats($formats);
        }

        $this->rowHandle->setTableHeader(true);

        $this->addRow($header);

        $this->rowHandle->setTableHeader(false);

        return $this;
    }

    public function addRow(array $row = [])
    {
        if (!$this->hasSetStyle) {
            $this->workbook->getStyle()->createCoordinateStyle()->createColumnTypeStyle();
            $this->hasSetStyle = true;
        }

        $this->lastWrittenRowIndex++;

        $rowXML = $this->rowHandle->setCells($this->lastWrittenRowIndex, $row)->getRowXML();

        $this->fileHandle->write($rowXML);

        return $this;
    }

    protected function startSheet()
    {
        $this->workbook->getStyle()->setSheetId($this->id);

        $html = <<<HTML
<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <sheetData>
HTML;

        $this->fileHandle->write($html);
    }

    public function mergeCell($startCoordinate, $endCoordinate)
    {
        $this->mergeCells[] = [$startCoordinate, $endCoordinate];
    }

    public function closeSheet()
    {
        if (!$this->hasClosed) {
            $html = '';
            if (!empty($this->mergeCells)) {
                $html .= '<mergeCells count="' . count($this->mergeCells) . '">';
                foreach ($this->mergeCells as $cells) {
                    $html .= '<mergeCell ref="' . $cells[0] . ':' . $cells[1] . '"/>';
                }
                $html .= '</mergeCells>';
            }

            $html .= '</sheetData></worksheet>';

            $this->fileHandle->write($html);
            $this->fileHandle->close();

            $this->hasClosed = true;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $coordinate
     *
     * @return \Rocky114\Spreadsheet\Writer\XLSX\Style
     */
    public function getStyle($coordinate)
    {
        return $this->workbook->getStyle()->setCoordinate($coordinate, $this->id);
    }
}