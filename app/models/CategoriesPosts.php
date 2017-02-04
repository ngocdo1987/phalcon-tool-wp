<?php

class CategoriesPosts extends \Phalcon\Mvc\Model
{

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
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CategoriesPosts
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
