<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Relation;
use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength as StringLength;
use Phalcon\Validation\Validator\Uniqueness;

class Users extends Model
{
	public $id;

	public $name;

	public $email;

	public $password;

	public $remember_token;

	public $created_at;

	public $updated_at;

	public function initialize()
    {
    	$this->setSchema("fw_phalcon_tool");


    }

    public function getSource()
    {
        return 'users';
    }

    public static function find($params = null)
    {
        return parent::find($params);
    }

    public static function findFirst($params = null)
    {
        return parent::findFirst($params);
    }
}