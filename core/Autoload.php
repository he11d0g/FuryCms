<?php
/**
 * @author: Pavlovskiy 
 * @date:   26.05.15
 */

class Autoload
{
    const debug = 1;
    public function __construct(){}

    public static function init($file)
    {
        $dirList = array('core/controller','core/model');

        foreach($dirList as $dir){
            $file = str_replace('\\', '/', $file);
            $path = APP_PATH . '/' . $dir;
            $filePath = $path . '/' . $file . '.php';

            if (file_exists($filePath))
            {
                require_once($filePath);

            }
            else
            {
                $flag = true;
                self::recursive_autoload($file, $path, &$flag);
            }
        }

    }

    public static function recursive_autoload($file, $path, $flag)
    {
        if (FALSE !== ($handle = opendir($path)) && $flag)
        {
            while (FAlSE !== ($dir = readdir($handle)) && $flag)
            {

                if (strpos($dir, '.') === FALSE)
                {
                    $path2 = $path .'/' . $dir;
                    $filePath = $path2 . '/' . $file . '.php';
                    if (file_exists($filePath))
                    {
                        $flag = FALSE;
                        require_once($filePath);
                        break;
                    }
                    self::recursive_autoload($file, $path2, &$flag);
                }
            }
            closedir($handle);
        }
    }

}