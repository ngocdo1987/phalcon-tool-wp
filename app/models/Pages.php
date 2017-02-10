<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

class Pages extends Model
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
    public $page_title;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_slug;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=true)
     */
    public $page_image;

    /**
     *
     * @var string
     * @Column(type="string", nullable=false)
     */
    public $page_content;

    /**
     *
     * @var integer
     * @Column(type="integer", length=4, nullable=false)
     */
    public $page_status;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_mt;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_md;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $page_mk;

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
        return 'pages';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pages[]|Pages
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pages
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
