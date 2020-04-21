<?php

namespace core;


class Validation
{
	public function __construct (ModelInterface $model)
	{
		$this->_model = $model;
	}

	/**
	 * @return bool
	 * @throws \ErrorException
	 */
	public function run(): bool
	{
		foreach ($this->_model->rules() as $value) {
			[$attributes, $rule] = $value;

			$property = [];
			if($value['message'] ?? false) {
				$property['message'] = $value['message'];
			}

			if($value['pattern'] ?? false) {
				$property['pattern'] = $value['pattern'];
			}

			if(method_exists($this, $rule)) {
				$this->$rule($attributes, $property);
				continue;
			}

			throw new \ErrorException("The '" . ucfirst($rule) . "' rule is not exist");
		};

		return !$this->_model->hasErrors();
	}


	/**
	 * @param string $attribute
	 * @param string $message
	 */
	public function addError(string $attribute, string $message): void
	{
		$labelAttribute = $this->_model->getLabel($attribute);
		$message = str_replace('{attribute}', $labelAttribute, $message);

		$this->_model->addError($attribute, $message);
	}


	/**
	 * @var ActiveModel
	 */
	private $_model;

	/**
	 * @param string|array $attributes
	 * @param array   $property
	 */
	private function required($attributes, $property): void
	{
		$message = $property['message'] ?? 'Поле {attribute} не може бути порожнім';
		if (is_array($attributes)) {
			foreach ($attributes as $attribute) {
				$value = $this->_model->$attribute;
				if (empty($value)) {
					$this->addError($attribute, $message);
				}
			}
		}  elseif(is_string($attributes)) {
			if (empty($this->_model->$attributes)) {
				$this->addError($attributes, $message);
			}
		}
	}

	/**
	 * @param string|array $attributes
	 * @param array   $property
	 */
	private function match($attributes, $property): void
	{
		$message = $property['message'] ?? 'Невірний {attribute}';

		if (is_array($attributes)) {
			foreach ($attributes as $attribute) {
				$value = $this->_model->$attribute;
				if(!preg_match($property['pattern'], $value)){
					$this->addError($attribute, $message);
				}
			}
		}  elseif(is_string($attributes)) {
			$value = $this->_model->$attributes;
			if(!preg_match($property['pattern'], $value)){
				$this->addError($attributes, $message);
			}
		}
	}
}