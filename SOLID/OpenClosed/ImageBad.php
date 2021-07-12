<?php

/**
 * (O) Open-closed SOLID prociple / Принцип открытости-закрытости
 * Class Image : не верная архитектура
 * @see video https://www.youtube.com/watch?v=tJkbThtl1D0
 * @hint PHP 8.0 used here
 * @author Mishaikon <mishaikon@mail.ru>
 */

class Image
{
    private int $width;
    private int $height;

    private function __construct($width, $height)
    {
        $this->width  = $width;
        $this->height = $height;
    }

    /**
     * Crate image
     * @param int $width
     * @param int $height
     * @return Image
     */
    public static function CreateImage(int $width, int $height) : Image
    {
        return new Image($width, $height);
    }

    /**
     * Fetch img size
     * @return ImageSize
     */
    public function GetSize() : ImageSize
    {
        return new ImageSize($width, $height);
    }

    /**
     * Save as bmp
     * @param string $path
     */
    public function SaveToBMP(string $path)
    {
        print "Save as BMP to file " . $path . "\n";
        return;
    }

    /**
     * Save img as jpg
     * @param string $path
     */
    public function SaveToJPG(string $path)
    {
        print "Save as JPG to file " . $path . "\n";
        return;
    }

    /**
     * Save img as png
     * @param string $path
     */
    public function SaveToPNG(string $path)
    {
        print "Save as PNG to file " . $path . "\n";
        return;
    }
}

$image = Image::CreateImage(1024, 768);

$image->SaveToBMP("image.bmp");
$image->SaveToJPG("image.jpg");
$image->SaveToPNG("image.png");