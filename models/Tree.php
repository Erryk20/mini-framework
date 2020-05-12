<?php


namespace models;


use core\ActiveModel;

class Tree
{
	public function __construct (array $items)
	{
		$this->_items = $items;
	}


	/**
	 * @param int $parentId
	 *
	 * @return array
	 */
	public function generate(int $parentId = 0): array
	{
		foreach ($this->_items as $item) {
			$this->_parents[$item->parent_id][$item->categories_id] = $item->categories_id;
		}

		$tree = $this->createBranch($parentId);

		return $tree[$parentId] ?? [];
	}


	/**
	 * @var ActiveModel[]
	 */
	private $_items = [];

	/**
	 * @var array
	 */
	private $_parents = [];


	/**
	 * @param int $parentId
	 *
	 * @return array
	 */
	private function createBranch(int $parentId): array
	{
		$tree = $childIDs = [];
		foreach ($this->getChildren($parentId) as $childId) {
			if ($this->isParent($childId)) {
				$childIDs = $this->createBranch($childId);
			}

			if ($childIDs) {

				if (isset($tree[$parentId])) {
					$tree[$parentId] += $childIDs;
				} else {
					$tree[$parentId] = $childIDs;
				}

				continue;
			}

			$tree[$parentId][$childId] = $childId;
		}

		return $tree;
	}


	/**
	 * @param $categories_id
	 *
	 * @return bool
	 */
	private function isParent($categories_id): bool
	{
		return isset($this->_parents[$categories_id]);
	}

	/**
	 * @param int $parentId
	 *
	 * @return array
	 */
	private function getChildren(int $parentId): array
	{
		return $this->_parents[$parentId] ?? [];
	}
}