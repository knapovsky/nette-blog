<?php
class ImageStorage
{
    use Nette\SmartObject;

    private $dir;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    public function save($file, $contents)
    {
        file_put_contents($this->dir . '/' . $file, $contents);
    }

    public function getDir() {
        return $this->dir;
    }
}
?>
