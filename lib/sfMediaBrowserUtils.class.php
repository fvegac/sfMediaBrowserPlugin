<?php

class sfMediaBrowserUtils
{
  protected $type_extension = array(
    'document' => array('doc', 'xls', ''),
  );

  public static $icons_path;

  static public function getTypeFromExtension($extension)
  {
    $extension = self::cleanString($extension);
    $types = self::getFileTypes();
    foreach($types as $type => $data)
    {
      if(in_array($extension, $data['extensions']))
      {
        return $type;
      }
    }
    return 'file';
  }
  

  static public function getIconFromType($type)
  {
    $types = self::getFileTypes();
    $dir = self::getIconsDir();
    if(array_key_exists($type, $types))
    {
      $icon = array_key_exists('icon', $types[$type])
            ? $types[$type]['icon']
            : $type
            ;
      return $dir.'/'.$icon.'.png';
    }
    return $dir.'/file.png';
    
  }

  static public function getExtensionFromFile($file)
  {
    return strtolower(substr(strrchr($file, '.'), 1));
  }


  static public function getIconFromExtension($extension)
  {
    $dir = '/sfMediaBrowserPlugin/images/icons';
    $path = self::getIconsPath();
    if(file_exists($path.'/'.$extension.'.png'))
    {
      return $dir.'/'.$extension.'.png';
    }
    return self::getIconFromType(self::getTypeFromExtension($extension));
  }

  static public function getTypeFromMime($file)
  {

  }


  static public function getFileTypes()
  {
    return sfConfig::get('app_sf_media_browser_file_types', array());
  }


  /**
   * Clean a string : lower cased and trimmed
   * @param string string to clean
   * @return string cleaned string
   */
  static public function cleanString($value)
  {
    return strtolower(trim($value));
  }


  static public function getIconsPath()
  {
    if(!self::$icons_path)
    {
      self::$icons_path = sfConfig::get('sf_web_dir').self::getIconsDir();
    }
    return self::$icons_path;
  }

  static public function getIconsDir()
  {
    return '/sfMediaBrowserPlugin/images/icons';
  }
}