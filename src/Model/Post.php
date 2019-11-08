<?php


namespace App\Model;


use App\Helpers\Text;

class Post
{
    private $id;

    private $name;

    private $content;

    private $created_at;

    private $slug;

    private $categories = [];

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }


    public function setContent(string $content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }


    public function getFormattedContent()
    {
        return nl2br(htmlentities($this->content));
    }

    public function getExcerpt (){
        if($this->content ===null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function getCreatedAt()
    {
        return new \DateTime($this->created_at);
    }

    public function setCreatedAt(string $date)
    {
        $this->created_at = $date;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }


    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    public function getID ()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }


    public function setCategories(array $categories)
    {
        $this->categories = $categories;
        return $this;
    }


    public function getCategoriesIds()
    {
        $ids = [];
        foreach ($this->categories as $category){
            $ids[] = $category->getId();
        }
        return $ids;
    }

    public function addCategory (Category $category){
        $this->categories[] = $category;
        $category->setPost($this);
    }


}