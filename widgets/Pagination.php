<?php

namespace widgets;

use core\App;


/**
 * Class Pagination
 *
 * @property int $limit
 * @property int $offset
 *
 * @package core
 */
class Pagination
{
	/**
	 * @var int
	 */
	public $limit;

	/**
	 * @var int
	 */
	public $offset = 0;

	/**
	 * Pagination constructor.
	 *
	 * @param array $properties
	 */
	public function __construct (array $properties)
	{
		$this->limit = $properties['limit'];
		$this->_count = $properties['count'];

		$this->run();
	}

	/**
	 * @return string
	 */
	public function getPaginationHtml(): string
	{
		$linksHtml = "<nav aria-label='Page navigation example'><ul class='pagination justify-content-center'>";

		if($this->_currentPage != 1) {
			$linksHtml .= "<li class='page-item'><a class='page-link' href='{$this->createUrl($this->_currentPage - 1)}'>Попередня</a></li>";
		}

		for($i = 1; $i <= $this->_countPages; $i++) {
			$active = $this->_currentPage == $i ? 'active' : '';

			$linksHtml .= "<li class='page-item {$active}'><a class='page-link' href='{$this->createUrl($i)}'>{$i}</a></li>";
		}

		if($this->_countPages != 0 && $this->_currentPage != $this->_countPages) {
			$linksHtml .= "<li class='page-item'><a class='page-link' href='{$this->createUrl($this->_currentPage + 1)}'>Наступна</a></li>";
		}

		$linksHtml .= "</ul></nav>";

		return $linksHtml;
	}

	public function getPage()
	{
		return $this->_currentPage;
	}


	/**
	 * @var int
	 */
	private $_count;

	/**
	 * @var string
	 */
	private $_currentPage;

	/**
	 * @var integer
	 */
	private $_countPages;

	private function run()
	{
		$get = App::request()->get();
		$this->_countPages = ceil($this->_count/$this->limit);
		$this->_currentPage = $get['page'] ?: 1;

		$this->offset = ($this->_currentPage == 1) ? 0 : $this->limit * ($this->_currentPage - 1);
	}

	/**
	 * @param int $page
	 *
	 * @return string
	 */
	private function createUrl(int $page): string
	{
		$get = App::request()->get();
		$get['page'] = $page;

		return '?' . http_build_query($get);
	}

}