<?php

namespace models;

use core\ActiveModel;

/**
 * Class Task
 *
 * @property string  $username
 * @property string  $email
 * @property string  $description
 * @property boolean $status
 * @property boolean $is_change
 *
 * @package models
 */
class Task extends ActiveModel
{

	/**
	 * @return string
	 */
	public static function tableName(): string
	{
		return 'tasks';
	}

	/**
	 * @return array
	 */
	public function rules(): array
	{
		return [
			[['username', 'email', 'description'], 'required', 'message' => "Поле '{attribute}' не може бути порожнім"],
			['email', 'match', 'pattern'=>'/^.+@.+\..+$/mi', 'message' => "Невірний '{attribute}'"],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'username' => "Користувач",
			'email' => 'E-mail',
			'description' => 'Текст задачі',
			'status' => 'Виконана',
			'is_change' => 'Відредаговано адміністратором',
		];
	}

	public function save($isValidate = true): bool
	{
		if (User::isAuthorized() && !$this->_isNewRecord && $this->checkChanges('description')) {
			$this->setAttribute('is_change', 1);
		}

		return parent::save($isValidate);
	}


}