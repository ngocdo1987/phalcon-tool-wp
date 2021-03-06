<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class CategoriesPosts extends Model
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
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $category_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $post_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("fw_phalcon_tool");

        $this->belongsTo(
            "category_id",
            "Categories",
            "id"
        );

        $this->belongsTo(
            "post_id",
            "Posts",
            "id"
        );
    }

    public function getCategories($params = null)
    {
        return $this->getRelated("Categories", $params);
    }

    public function getPosts($params = null)
    {
        return $this->getRelated("Posts", $params);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categories_posts';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoriesPosts[]|CategoriesPosts
     */
    public static function find($params = null)
    {
        return parent::find($params);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoriesPosts
     */
    public static function findFirst($params = null)
    {
        return parent::findFirst($params);
    }

}
