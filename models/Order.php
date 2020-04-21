<?php

namespace models;

use core\ActiveModel;

/**
 * Class Order
 *
 * @property string  $username
 * @property string  $email
 * @property integer $status
 *
 * @package models
 */
class Order extends ActiveModel
{
	public $username;
	public $email;
	public $status;

	public function tableName()
	{
		return '';
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'username' => "Сортувати за ім'ям",
			'email' => 'Сортувати за поштовою скринькою',
			'status' => 'Сортувати за статусом',
		];
	}

	public function getCriteria()
	{
		return array_filter([
			'username' => $this->username,
			'email' => $this->email,
			'status' => $this->status
		]);
	}

}