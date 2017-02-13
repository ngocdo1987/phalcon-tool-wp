<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class Tags extends Model
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
    public $tag_name;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tag_slug;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tag_description;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tag_mt;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tag_md;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $tag_mk;

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
            "PostsTags",
            "tag_id"
        );

        $this->hasManyToMany(
            "id",
            "PostsTags",
            "tag_id", "post_id",
            "Posts",
            "id"
        );
    }

    public function getPostsTags($parameters = null)
    {
        return $this->getRelated("PostsTags", $parameters);
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
        return 'tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags[]|Tags
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tags
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
