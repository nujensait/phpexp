<?php

/**
 * (O) Open-closed SOLID prociple / Принцип открытости-закрытости
 * Class Image : Верная архитектура
 * @see video https://www.youtube.com/watch?v=tJkbThtl1D0
 * @hint PHP 8.0 used here
 * @author Mishaikon <mishaikon@mail.ru>
 */

interface ISave
{
    public function Save(string $path, Image $image);
}

/**
 * Class SaveToBMP
 */
class SaveToBMP implements ISave
{
    /**
     * @param string $path
     * @param Image $image
     */
    public function Save(string $path, Image $image)
    {
        $tempPath = $path . ".bmp";
        print "< save to $tempPath >\n";
        return;
    }
}

/**
 * Class SaveToJPG
 */
class SaveToJPG implements ISave
{
    /**
     * @param string $path
     * @param Image $image
     */
    public function Save(string $path, Image $image)
    {
        $tempPath = $path . ".jpg";
        print "< save to $tempPath >\n";
        return;
    }
}

/**
 * Class SaveToPNG
 */
class SaveToPNG implements ISave
{
    /**
     * @param string $path
     * @param Image $image
     */
    public function Save(string $path, Image $image)
    {
        $tempPath = $path . ".png";
        print "< save to $tempPath >\n";
        return;
    }
}

/**
 * Class ImageSize
 */
class ImageSize
{
    private int $x;
    private int $y;

    public function __construct(int $x, int $y)
    {
        $this->x = $x;
        $this->y = $y;
    }
}

/**
 * Class Image
 */
class Image
{
    private int $width;
    private int $height;

    private ISave $saveOption;

    /**
     * Image constructor.
     * @param int $width
     * @param int $height
     * @param ISave $saveOption
     */
    public function __construct(int $width, int $height, ISave $saveOption)
    {
        $this->width = $width;
        $this->height = $height;
        $this->saveOption = $saveOption;
    }

    /**
     * @param int $width
     * @param int $height
     * @param ISave $saveOption
     * @return Image
     */
    public static function CreateImage(int $width, int $height, ISave $saveOption): Image
    {
        return new Image($width, $height, $saveOption);
    }

    /**
     * @return ImageSize
     */
    public function GetSize(): ImageSize
    {
        return new ImageSize($this->width, $this->height);
    }

    /**
     * @param string $path
     */
    public function SaveTo(string $path)
    {
        $this->saveOption->Save($path, $this);
    }
}

$pictures = [
    Image::CreateImage(28, 19, new SaveToBMP()),
    Image::CreateImage(19, 90, new SaveToJPG()),
    Image::CreateImage(15, 36, new SaveToPNG()),
];

foreach ($pictures as $pic) {
    $pic->SaveTo("image_" . time());
}