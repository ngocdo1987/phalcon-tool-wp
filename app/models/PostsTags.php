<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class PostsTags extends Model
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
    public $post_id;

    /**
     *
     * @var integer
     * @Primary
     * @Column(type="integer", length=10, nullable=false)
     */
    public $tag_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("fw_phalcon_tool");

        $this->belongsTo(
            "post_id",
            "Posts",
            "id"
        );

        $this->belongsTo(
            "tag_id",
            "Tags",
            "id"
        );
    }

    public function getPosts($params = null)
    {
        return $this->getRelated("Posts", $params);
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
        return 'posts_tags';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PostsTags[]|PostsTags
     */
    public static function find($params = null)
    {
        return parent::find($params);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PostsTags
     */
    public static function findFirst($params = null)
    {
        return parent::findFirst($params);
    }

}
