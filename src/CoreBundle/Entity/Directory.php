<?php

namespace CoreBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\Request;

/**
 * Directory
 *
 * @ORM\Table(name="directory")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\DirectoryRepository")
 */
class Directory
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updateAt", type="datetime")
     */
    private $updateAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User", inversedBy="directories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\File",mappedBy="directory")
     */
    private $files;

    /**
     * @ORM\OneToMany(targetEntity="Directory", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Directory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var boolean
     *
     * @ORM\Column(name="shared", type="boolean")
     */
    private $shared;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, unique=true)
     */
    private $token;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Directory
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

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Directory
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Directory
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updateAt
     *
     * @param \DateTime $updateAt
     *
     * @return Directory
     */
    public function setUpdateAt($updateAt)
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    /**
     * Get updateAt
     *
     * @return \DateTime
     */
    public function getUpdateAt()
    {
        return $this->updateAt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Directory
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set user
     *
     * @param \CoreBundle\Entity\User $user
     *
     * @return Directory
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add file
     *
     * @param \CoreBundle\Entity\File $file
     *
     * @return Directory
     */
    public function addFile(\CoreBundle\Entity\File $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \CoreBundle\Entity\File $file
     */
    public function removeFile(\CoreBundle\Entity\File $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

  //RECUPERATION DU PATH
    public  function getCreatDir(){
        return 'Dossier/'.$this->user->getId();
    }

    public  function getCreateFolderDir(){
        $path = $this->getCreatDir();
        if(!empty($this->getParent())) {
            $path = $this->getParent()->getCreateFolderDir();
        }
        if($this->name == '..') {
            return $path;
        } else {
            return $path .'/'.$this->name;
        }
    }

    public  function getRenameFolderDir(){
        $path = $this->getCreatDir();
        if(!empty($this->getParent())) {
            $path = $this->getParent()->getPath();
        }
        return $path .'/';
    }

    public function getAbsolutePath(){
        $path = __DIR__.'/../../../web/'.$this->getCreatDir();
        if(!empty($this->getParent())) {
            $path = $this->getParent()->getAbsolutePath();
        }

        if($this->name == '..') {
            return $path;
        } else {
            return $path .'/'.$this->name;
        }
    }

    public function getRealPath(Request $request) {
        $baseUrl = $request->getScheme() . '://' . $request->getHttpHost() . $request->getBasePath().'/' . $this->getCreatDir();

        if(!empty($this->getParent())) {
            $baseUrl = $this->getParent()->getRealPath($request);
        }


        return $baseUrl . '/'.$this->name;
    }

    public function getRootDir(){
        return __DIR__.'/../../../web/';
    }

    /**
     * Add child
     *
     * @param \CoreBundle\Entity\Directory $child
     *
     * @return Directory
     */
    public function addChild(\CoreBundle\Entity\Directory $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \CoreBundle\Entity\Directory $child
     */
    public function removeChild(\CoreBundle\Entity\Directory $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \CoreBundle\Entity\Directory $parent
     *
     * @return Directory
     */
    public function setParent(\CoreBundle\Entity\Directory $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \CoreBundle\Entity\Directory
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set shared
     *
     * @param boolean $shared
     *
     * @return Directory
     */
    public function setShared($shared)
    {
        $this->shared = $shared;

        return $this;
    }

    /**
     * Get shared
     *
     * @return boolean
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Directory
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }


}
