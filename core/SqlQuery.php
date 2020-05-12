<?php

namespace core;

use PDO;


class SqlQuery
{
	/**
	 * SqlQuery constructor.
	 *
	 * @param string $tableName
	 */
	public function __construct(string $tableName)
	{
		$this->_tableName = $tableName;

		$this->connectToDB();
		$this->setPrimaryKey();
	}

	/**
	 * @param array $select
	 *
	 * @return $this
	 */
	public function select(array $select)
	{
		$this->_select =  implode(', ', $select);

		return $this;
	}

	/**
	 * @param array $criteria
	 *
	 * @return $this
	 */
	public function where(array $criteria)
	{
		$this->_criteria[] = $criteria;

		return $this;
	}

	/**
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return SqlQuery
	 */
	public function limit(int $limit, int $offset = 0): SqlQuery
	{
		$this->_limit = $limit;
		$this->_offset = $offset;

		return $this;
	}

	/**
	 * @param array $criteria
	 *
	 * @return SqlQuery
	 */
	public function order(array $criteria): SqlQuery
	{
		$this->_order = $criteria;

		return $this;
	}

	/**
	 * @return int
	 */
	public function count(): int
	{
		if($result = $this->query(true)){
			return (int) $result[0]['COUNT(*)'];
		}

		return 0;
	}

	/**
	 * @param bool $count
	 *
	 * @return array
	 */
	public function query($count = false)
	{
		$selectSql = $this->getSelect($count);
		$fromSql = $this->getFrom();
		[$whereSql, $criteriaWhere] = $this->getWhere();
		[$limitSql, $criteriaLimit] = $this->getLimit();
		$orderSql = $this->getOrder();

		$sql = $selectSql . $fromSql . $whereSql . $orderSql . $limitSql;

		$stmt = $this->_pdo->prepare($sql);
		foreach (array_merge($criteriaWhere, $criteriaLimit) AS $field => $value){

				if (is_int($value)) 		$type = PDO::PARAM_INT;
				elseif (is_null($value)) 	$type = PDO::PARAM_NULL;
				else 						$type = PDO::PARAM_STR;

				$stmt->bindValue($field, $value,  $type);
		}

		if ($stmt->execute()) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		return [];
	}

	/**
	 * @return array
	 */
	public function getFields()
	{
		$query = "
			SELECT *
			FROM `INFORMATION_SCHEMA`.`COLUMNS` 
			WHERE `TABLE_NAME` = :table
		";
		$stmt =  $this->_pdo->prepare($query);
		$stmt->execute([':table' => $this->_tableName]);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$fields = [];
		foreach ($data as $row) {
			$fields[$row['COLUMN_NAME']] = $row['DATA_TYPE'];
		}

		return $fields;
	}


	/**
	 * @var int|null
	 */
	private $_limit;

	/**
	 * @var int|null
	 */
	private $_offset;

	/**
	 * @var array|null
	 */
	private $_order;

	/**
	 * @var string
	 */
	private $_select = '*';

	/**
	 * @var \PDO
	 */
	private $_pdo;

	/**
	 * @var array
	 */
	private $_criteria;

	/**
	 * @var string
	 */
	protected $_primaryKey;

	/**
	 * @var string
	 */
	protected $_tableName;


	private function connectToDB(): void
	{
		$db = App::getConfig('db');

		$dsn = $db['dsn'] ?? null;
		$username = $db['username'] ?? null;
		$password = $db['password'] ?? null;

		$this->_pdo = new \PDO($dsn, $username, $password);
	}

	/**
	 * @return array|null
	 */
	private function getWhere(): array
	{
		if ($this->_criteria) {
			$formatCriteria = [];
			$values = [];

			foreach ($this->_criteria AS $key => $item){

				if(array_key_exists(0, $item)) {
					$formatCriteria[] = "`{$item[1]}` {$item[0]} :{$item[1]}";
					$values[":{$item[1]}"] = $item[2];
					continue;
				}

				foreach ($item AS $attribute => $value) {
					$formatCriteria[] = "`$attribute` = :$attribute";
					$values[":{$attribute}"] = $value;
				}

			}
			$formatCriteria = implode(' AND ', $formatCriteria);

			return [" WHERE {$formatCriteria}", $values];
		}

		return [null, []];
	}

	/**
	 * @param bool $count
	 *
	 * @return string
	 */
	private function getSelect(bool $count): string
	{
		return $count ? "SELECT COUNT(*)" : "SELECT {$this->_select}";
	}

	/**
	 * @return string
	 */
	private function getFrom(): string
	{
		return " FROM `$this->_tableName`";
	}

	/**
	 * @return array
	 */
	private function getLimit(): array
	{
		if (is_null($this->_offset)  && is_null($this->_limit)) {
			return [null, []];
		}

		return [
			" LIMIT :offset, :limit",
			[
				':offset' => $this->_offset,
				':limit' => $this->_limit,
			]
		];
	}

	/**
	 * @return string
	 */
	private function getOrder(): string
	{
		if (empty($this->_order)) {
			return '';
		}

		$masks = [];
		foreach ($this->_order AS $field => $value) {
			$masks[] = "`$field` " . ($value > 0 ? " ASC" : " DESC");
		}

		return " ORDER BY " . implode(', ', $masks);
	}

	private function setPrimaryKey(): void
	{
		$query = "SHOW KEYS FROM `{$this->_tableName}` WHERE Key_name = 'PRIMARY'";

		$stmt = $this->_pdo->query($query);

		if($stmt){
			$dataInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			$this->_primaryKey = $dataInfo['Column_name'] ?? '';
		}
	}

	/**
	 * @param string $table
	 * @param array  $attributes
	 * @param array  $values
	 *
	 * @return bool
	 */
	protected function insert(string $table, array $attributes, array $values): bool
	{
		$keys = implode(', ', array_keys($attributes));
		$attributes = implode(', ', array_values($attributes));

		$query = "INSERT INTO `{$table}` ({$keys}) VALUES ({$attributes})";
		$stmt = $this->_pdo->prepare($query);

		return $stmt->execute($values);
	}

	/**
	 * @param string $table
	 * @param array  $attributes
	 * @param array  $values
	 *
	 * @return bool
	 */
	protected function update(string $table, array $attributes, array $values): bool
	{
		$listForSet = array_map(function($attribute, $mask){
			return "$attribute=$mask";
		}, array_keys($attributes), array_values($attributes));

		$listForSet = implode(', ', $listForSet);
		[$whereSql, $criteriaWhere] = $this->getWhere();

		$query = "UPDATE `{$table}` SET {$listForSet}" . $whereSql;
		$stmt =  $this->_pdo->prepare($query);

		return $stmt->execute(array_merge($values, $criteriaWhere));
	}
}