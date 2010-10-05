<?php

/*
 * This file is part of the sfMediaBrowserPlugin package.
 * (c) Vincent Agnano <vincent.agnano@particul.es>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormInput represents an HTML input file browser tag.
 *
 * @package    sfMediaBrowser
 * @subpackage model
 * @author     Vincent Agnano <vincent.agnano@particul.es>
 */
class sfMediaBrowserImageObject extends sfMediaBrowserFileObject
{
  protected $dimensions = null,
            $thumbnail = null
            ;
  
  public function __construct($file)
  {
    parent::__construct($file);
//    if($this->getType() != 'image')
//    {
//      throw new sfException(sprintf('The file "%s" is not an image', $file));
//    }
  }
  

  public function isImage()
  {
    return true;
  }
  
  
  public function getDimensions()
  {
    if(!$this->dimensions)
    {
      $this->dimensions = getimagesize($this->getPath());
    }
    return $this->dimensions;
  }

  public function getWidth()
  {
    $dimensions = $this->getDimensions();
    return $dimensions[0];
  }

  public function getHeight()
  {
    $dimensions = $this->getDimensions();
    return $dimensions[1];
  }
  
  
  
  
  public function getIcon()
  {
   
    return url_for('jsThumbnail/thumbnail').'?img='.$this->file_url.'&maxx='.sfConfig::get('app_sf_media_browser_thumbnails_max_width', 48).'&maxy='.sfConfig::get('app_sf_media_browser_thumbnails_max_height', 48).'&mode=crop';
   
   // return parent::getIcon();
  }
  
  
  
  public function delete()
  {
    // try to delete the thumbnail if exists
    try
    {
      $thumbnail = $this->getThumbnail();
      if($thumbnail)
      {
        $thumbnail->delete();
      }
    }
    catch(sfException $e){}
    
    // delete current file
    parent::delete();
  }
}
