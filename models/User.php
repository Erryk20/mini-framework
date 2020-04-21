<?php

namespace models;

use core\ActiveModel;

class User extends ActiveModel
{
	/**
	 * @var int
	 */
	public $user_id;

	public function tableName()
	{
		return '';
	}

	/**
	 * @param string $login
	 * @param string $password
	 *
	 * @return null|User
	 */
	public static function findUser(string $login, string $password)
	{
		foreach (self::$_users AS $key => $user) {
			if ($user['login'] === $login && $user['password'] === $password) {
				$user = new self();
				$user->user_id = $key;

				return $user;
			}
		}

		return null;
	}

	/**
	 * @return bool
	 */
	public static function isAuthorized(): bool
	{
		return $_SESSION['user_id'] ?? false;
	}



	public function login(): bool
	{
		$_SESSION['user_id'] = $this->user_id;

		return true;
	}

	/**
	 * @var array
	 */
	private static $_users = [
		1 => [
			'login' => 'admin',
			'password' => '123',
		]
	];
}