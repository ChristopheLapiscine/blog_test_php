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

    public function getSlug()
    {
        return $this->slug;
    }

    public function getID ()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function addCategory (Category $category){
        $this->categories[] = $category;
        $category->setPost($this);
    }
}