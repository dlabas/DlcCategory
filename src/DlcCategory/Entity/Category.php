<?php
namespace DlcCategory\Entity;

use DlcDoctrine\Entity\AbstractProvidesHistoryEntity;
use Doctrine\ORM\Mapping as ORM;
use DoctrineExtensions\NestedSet\MultipleRootNode;

/**
 * The category entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="categories")
 */
class Category extends AbstractProvidesHistoryEntity 
    implements CategoryInterface,
               MultipleRootNode
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $root;
    
    /**
     * @ORM\Column(name="lft",type="integer")
     */
    protected $lft;
    
    /**
     * @ORM\Column(name="rgt",type="integer")
     */
    protected $rgt;
    
    /**
     * @ORM\Column(type="string",length=100,unique=true)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\Column(type="string",length=100)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $description;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $thumbnail;
    
    public function __toString()
    {
        return $this->getName();
    }
    
    /**
     * Getter for $id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Setter for $id
     *
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * gets Node's root value
     *
     * @return mixed
     */
    public function getRootValue()
    {
        return $this->root;
    }
    
    /**
     * sets Node's root value
     *
     * @param mixed $root
     */
    public function setRootValue($root)
    {
        $this->root = $root;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \DoctrineExtensions\NestedSet\Node::getLeftValue()
     */
    public function getLeftValue()
    {
        return $this->lft;
    }
    
    /**
     * (non-PHPdoc)
     * @see \DoctrineExtensions\NestedSet\Node::setLeftValue()
     */
    public function setLeftValue($left)
    {
        $this->lft = $left;
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \DoctrineExtensions\NestedSet\Node::getRightValue()
     */
    public function getRightValue()
    {
        return $this->rgt;
    }
    
    /**
     * (non-PHPdoc)
     * @see \DoctrineExtensions\NestedSet\Node::setRightValue()
     */
    public function setRightValue($right)
    {
        $this->rgt = $right;
        return $this;
    }
    
    /**
     * Getter for $name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Setter for $name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Getter for $title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Setter for $title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     * Getter for $description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }
    
    /**
     * Setter for $description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * Getter for $thumbnail
     *
     * @return string $thumbnail
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

	/**
     * Setter for $thumbnail
     *
     * @param  string $thumbnail
     * @return Category
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        parent::onPrePersist();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        parent::onPreUpdate();
    }
}