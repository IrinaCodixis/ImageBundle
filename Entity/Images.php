<?php

namespace Mipa\ImageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Images
 * @Vich\Uploadable 
 * @ORM\HasLifecycleCallbacks
 */
class Images
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $image;
	
	public $file;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Images
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Images
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Images
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

	protected function getUploadDir()
	{
		return 'uploads/pics';
	}
	 
	protected function getUploadRootDir()
	{
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	 
	public function getWebPath()
	{
		return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
	}
	 
	public function getAbsolutePath()
	{
		return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
	}

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
         if (null !== $this->file) {
		// do whatever you want to generate a unique name
		$this->image = uniqid().'.'.$this->file->guessExtension();
  }
    }

    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
       if (null === $this->file) {
		return;
	  }
	 
	  // if there is an error when moving the file, an exception will
	  // be automatically thrown by move(). This will properly prevent
	  // the entity from being persisted to the database on error
	  $this->file->move($this->getUploadRootDir(), $this->image);
	 
	  unset($this->file);
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
			unlink($file);
	    }
    }
}
