<?php

namespace Rocky114\Spreadsheet\Writer\XLSX\Style;

class Font
{
    use Coordinate;

    protected $currentIndex = 0;

    protected $fontFormats = [
        'general' => [
            'id'   => 0,
            'name' => 'Calibri',
            'size' => 12,
            'bold' => false,
        ]
    ];

    public function __construct()
    {
    }

    public function setSize(int $size)
    {
        $key = $this->currentCoordinate . '_' . $this->currentSheetId;
        if (!isset($this->fontFormats[$key])) {
            $this->currentIndex++;
        }

        $this->fontFormats[$key]['size'] = $size;
        $this->fontFormats[$key]['id'] = $this->currentIndex;

        return $this;
    }

    public function setBold(bool $boolean)
    {
        $key = $this->currentCoordinate . '_' . $this->currentSheetId;

        if (!isset($this->fontFormats[$key])) {
            $this->currentIndex++;
        }

        $this->fontFormats[$key]['bold'] = $boolean;
        $this->fontFormats[$key]['id'] = $this->currentIndex;

        return $this;
    }

    public function setName($name)
    {
        $key = $this->currentCoordinate . '_' . $this->currentSheetId;

        if (!isset($this->fontFormats[$key])) {
            $this->currentIndex++;
        }

        $this->fontFormats[$key]['name'] = $name;
        $this->fontFormats[$key]['id'] = $this->currentIndex;

        return $this;
    }

    public function getFontFormats()
    {
        return $this->fontFormats;
    }

    public function getFontId(string $coordinate = 'general')
    {
        if (isset($this->fontFormats[$coordinate])) {
            return $this->fontFormats[$coordinate]['id'];
        }

        return 0;
    }
}