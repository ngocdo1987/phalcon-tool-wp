<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
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
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Posts
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
