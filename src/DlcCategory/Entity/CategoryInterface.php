<?php
namespace DlcCategory\Entity;

/**
 * The category entity interface
 */
interface CategoryInterface
{
    /**
     * Setter for $id
     *
     * @param int $id
     */
    public function setId($id);

    /**
     * Getter for $name
     *
     * @return string $name
     */
    public function getName();

    /**
     * Setter for $name
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Getter for $title
     *
     * @return string $title
     */
    public function getTitle();

    /**
     * Setter for $title
     *
     * @param string $title
     */
    public function setTitle($title);

    /**
     * Getter for $description
     *
     * @return string $description
     */
    public function getDescription();

    /**
     * Setter for $description
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * Getter for $thumbnail
     *
     * @return string $thumbnail
     */
    public function getThumbnail();

    /**
     * Setter for $thumbnail
     *
     * @param  string $thumbnail
     * @return Category
     */
    public function setThumbnail($thumbnail);
}