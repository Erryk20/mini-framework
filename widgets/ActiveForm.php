<?php
namespace widgets;


class ActiveForm extends ActiveField
{
	/**
	 * @var string
	 */
	private $action = '';

	/**
	 * @var string
	 */
	private $method = "GET";

	/**
	 * @param array $attributes
	 *
	 * @return ActiveForm
	 * @throws \ErrorException
	 */
	public static function begin(array $attributes = [])
	{
		$form = new self();

		$form->setAttributes($attributes);
		$form->generateForm();

		return new self();
	}

	public static function end()
	{
		echo "</form></div>";

		echo ob_get_clean();
	}

	/**
	 * @param array $attributes
	 *
	 * @throws \ErrorException
	 */
	private function setAttributes(array $attributes = [])
	{

		foreach ($attributes AS $name => $attribute) {
			if (property_exists($this, $name)) {
				$this->$name = $attribute;
			} else {
				throw new \ErrorException("The '{$name}' property does not exist in ActiveForm class");
			}
		}
	}

	private function generateForm()
	{
		$attributes = '';

		if ($this->action) {
			$attributes .= " action='{$this->action}'";
		}

		if ($this->method) {
			$attributes .= " method='{$this->method}'";
		}

		ob_start();
		ob_implicit_flush(false);

		echo "<div class='container'><form {$attributes}>";
	}





}