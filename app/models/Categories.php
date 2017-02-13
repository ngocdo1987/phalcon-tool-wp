<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class Categories extends Model
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
    public $category_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $category_slug;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $category_description;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $parent_id;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $category_mt;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $category_md;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $category_mk;

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
            "category_id"
        );

        $this->hasManyToMany(
            "id",
            "CategoriesPosts",
            "category_id", "post_id",
            "Posts",
            "id"
        );
    }

    public function getCategoriesPosts($parameters = null)
    {
        return $this->getRelated("CategoriesPosts", $parameters);
    }

    public function getPosts($parameters = null)
    {
        return $this->getRelated("Posts", $parameters);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categories';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories[]|Categories
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categories
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public function validation()
    {
        $validation = new Validation();

        $validation->add('category_name', new PresenceOf([
            'message' => 'Category name is required.'
        ]));
        $validation->add('category_name', new StringLength([
            'min' => 3,
            'messageMinimum' => 'Category name must be at least 3 characters.'
        ]));

        $validation->add('category_slug', new PresenceOf([
            'message' => 'Category slug is required.'
        ]));
        $validation->add('category_slug', new Uniqueness([
            'message' => 'Category slug has already been taken.'
        ]));

        return $this->validate($validation);
    }
}
