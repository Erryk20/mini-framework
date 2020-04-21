<?php

namespace models;

use core\ActiveModel;

/**
 * Class Login
 *
 * @property string $login
 * @property string $password
 *
 * @package models
 */
class Login extends ActiveModel
{
	public $login;
	public $password;

	public function tableName()
	{
		return '';
	}

	/**
	 * @return array
	 */
	public function rules(): array
	{
		return [
			[['login', 'password'], 'required', 'message' => "Поле '{attribute}' не може бути порожнім"],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'login' => "Логін",
			'password' => 'Пароль',
		];
	}
}