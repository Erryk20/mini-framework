<?php
namespace core;

class ActiveModel extends SqlQuery implements ModelInterface
{
	public function __construct()
	{
		if (static::tableName()) {
			parent::__construct(static::tableName());

			$this->addAttributes();
		}
	}

	/**
	 * @param string $attribute
	 *
	 * @return mixed
	 */
	public function __get(string $attribute)
	{
		if (array_key_exists($attribute, $this->_attribetes)) {
			return $this->_attribetes[$attribute];
		}

		return $this->$attribute;
	}

	/**
	 * @return array
	 */
	public function rules(): array
	{
		return [];
	}

	/**
	 * @param string $name
	 * @param mixed  $value
	 */
	public function __set(string $name, $value): void
	{
		if (array_key_exists($name, $this->_attribetes)) {
			$this->_attribetes[$name] = $value;
		}
	}

	public function addAttributes(): void
	{
		$fields = $this->getFields();

		foreach ($fields AS $field) {
			$this->_attribetes[$field] = null;
		}
	}

	public function refresh(): void
	{
		foreach ($this->_attribetes AS &$value) $value = null;
	}

	/**
	 * @return array
	 */
	public function attributeLabels()
	{
		$labels = [];
		foreach ($this->_attribetes AS $key => $value) {
			$labels[$key] = $this->getLabelFromName($key);
		}

		return $labels;
	}

	/**
	 * @param string $attribute
	 *
	 * @return string
	 */
	public function getLabel(string $attribute): string
	{
		$labels = $this->attributeLabels();

		return $labels[$attribute] ?? $this->getLabelFromName($attribute);
	}

	/**
	 * @param array $data
	 *
	 * @return bool
	 * @throws \ReflectionException
	 */
	public function load(array $data): bool
	{
		$reflection = new \ReflectionClass($this);
		$className = $reflection->getShortName();

		if (isset($data[$className])) {
			foreach ($data[$className] AS $attribute => $value) {
				$this->$attribute = htmlentities($value);
			}

			return true;
		}

		return false;
	}

	/**
	 * @param bool $isValidate
	 *
	 * @return bool
	 */
	public function save($isValidate = true): bool
	{
		if ($isValidate) {
			if ($this->validate() === false) return false;
		}

		[$fields, $values] = $this->prepareDataForSql();

		return $this->_isNewRecord
			? $this->insert($this->_tableName, $fields, $values)
			: $this->update($this->_tableName, $fields, $values);
	}

	public function validate(): bool
	{
		return (new Validation($this))->run();
	}

	/**
	 * @param string $id
	 *
	 * @return ActiveModel|null
	 */
	public static function findById($id)
	{
		$model = new static();
		$model->where([$model->_primaryKey => (int) $id]);
		$data = $model->limit(1)->query();

		if(empty($data)) return null;

		$model->setAttributes($data[0]);

		return $model;
	}

	/**
	 * @return ActiveModel
	 */
	public static function find(): ActiveModel
	{
		return new static();
	}

	/**
	 * @return array|ActiveModel[]
	 */
	public function all()
	{
		if($records = $this->query()) {
			$models = [];
			$model = new static();
			$model->_isNewRecord = false;

			foreach ($records AS $record) {
				$cloneModel = clone $model;
				$cloneModel->setAttributes($record);
				$models[] = $cloneModel;
			}

			return $models;
		}

		return [];
	}

	/**
	 * @param string $attribute
	 *
	 * @return string
	 */
	public function getLabelFromName(string $attribute): string
	{
		return ucfirst($attribute);
	}

	/**
	 * @return bool
	 */
	public function hasErrors(): bool
	{
		return !empty($this->getErrors());
	}

	/**
	 * @param string $attribute
	 * @param string $message
	 */
	public function addError(string $attribute, string $message): void
	{
		$this->_errors[$attribute][] = $message;
	}

	/**
	 * @return array
	 */
	public function getErrors(): array
	{
		return $this->_errors;
	}

	/**
	 * @param string $attribute
	 *
	 * @return array
	 */
	public function getError(string $attribute)
	{
		return $this->_errors[$attribute] ?? [];
	}

	/**
	 * @param string $attribute
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	public function setAttribute(string $attribute, $value): bool
	{
		if (array_key_exists($attribute, $this->_attribetes)) {
			$this->_attribetes[$attribute] = $value;

			return true;
		}

		return false;
	}

	/**
	 * @param string $attribute
	 *
	 * @return mixed|null
	 */
	public function getAttribute(string $attribute)
	{
		if (array_key_exists($attribute, $this->_attribetes)) {
			return $this->_attribetes[$attribute];
		}

		return null;
	}

	/**
	 * @param string $attribute
	 *
	 * @return mixed|null
	 */
	public function getOldAttribute(string $attribute)
	{
		if (array_key_exists($attribute, $this->_oldAttributes)) {
			return $this->_oldAttributes[$attribute];
		}

		return null;
	}


	/**
	 * @param string $attribute
	 *
	 * @return bool|null
	 */
	public function checkChanges(string $attribute)
	{
		if(array_key_exists($attribute, $this->_oldAttributes)) {
			return $this->getAttribute($attribute) !== $this->getOldAttribute($attribute);
		}

		return null;
	}



	/**
	 * @var array
	 */
	private $_attribetes = [];


	/**
	 * @var array
	 */
	private $_oldAttributes = [];

	/**
	 * @var array
	 */
	private $_errors = [];

	/**
	 * @var bool
	 */
	protected $_isNewRecord = true;

	/**
	 * @param array $fields
	 */
	private function setAttributes(array $fields): void
	{
		$this->_attribetes = $fields;
		$this->_oldAttributes = $fields;
		$this->_isNewRecord = false;
	}

	/**
	 * @return array
	 */
	protected function prepareDataForSql(): array
	{
		$fields = $values = [];
		$primaryKey = $this->_primaryKey;

		$attributes = array_filter($this->_attribetes, function($value, $key) use ($primaryKey){
			if ($primaryKey === $key) return false;

			return !is_null($value);
		}, ARRAY_FILTER_USE_BOTH);

		foreach ($attributes AS $key => $value) {
			$fields["`{$key}`"] = ":$key";
			$values[":{$key}"] = $value;
		}

		return [$fields, $values];
	}
}