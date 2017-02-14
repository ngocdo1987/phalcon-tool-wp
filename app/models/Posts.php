<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class Posts extends Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $post_title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $post_slug;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $post_image;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $post_content;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $post_status;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $post_mt;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $post_md;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $post_mk;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $created_at;

    /**
     *
     * @var string
     * @Column(type="string", nullable=true)
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("fw_phalcon_tool");

        $this->hasMany(
            "id",
            "CategoriesPosts",
            "post_id"
        );

        $this->hasManyToMany(
            "id",
            "CategoriesPosts",
            "post_id", "category_id",
            "Categories",
            "id"
        ); 

        $this->hasMany(
            "id",
            "PostsTags",
            "post_id"
        );

        $this->hasManyToMany(
            "id",
            "PostsTags",
            "post_id", "tag_id",
            "Tags",
            "id"
        );
    }

    public function getCategoriesPosts($params = null)
    {
        return $this->getRelated("CategoriesPosts", $params);
    }

    public function getCategories($params = null)
    {
        return $this->getRelated("Categories", $params);
    }

    public function getPostsTags($params = null)
    {
        return $this->getRelated("PostsTags", $params);
    }

    public function getTags($params = null)
    {
        return $this->getRelated("Tags", $params);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts[]|Posts
     */
    public static function find($params = null)
    {
        return parent::find($params);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts
     */
    public static function findFirst($params = null)
    {
        return parent::findFirst($params);
    }

}
