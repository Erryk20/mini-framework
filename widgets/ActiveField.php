<?php

namespace widgets;


use core\ActiveModel;

/**
 * Class ActiveField
 *
 * @property string $fieldTemplate;
 * @property string $checkboxTemplate;
 *
 * @package widgets
 */
class ActiveField
{
	/**
	 * @var string
	 */
	public $fieldTemplate = "
		<div class='form-group row'>
			<label {for} {classLabel}>{label}</label>
			<div class='col-sm-4'>
				{input}
				{help}
			</div>
		</div>
	";

	/**
	 * @var string
	 */
	public $checkboxTemplate = "
		<div class='form-group row'>
			<div class='form-check'>
				<div class='col-sm-4'>
					{input}
					<label class='form-check-label' {for}>{label}</label>
					{help}
				</div>
			</div>
		</div>
	";

	/**
	 * @param ActiveModel $model
	 * @param string      $attribute
	 *
	 * @return $this
	 * @throws \ReflectionException
	 */
	public function field(ActiveModel $model, string $attribute): self
	{
		$this->_value = $model->{$attribute};
		$reflection = new \ReflectionClass($model);

		$this->_className = $reflection->getShortName();
		$this->_model = $model;
		$this->_attribute = $attribute;

		return $this;
	}

	/**
	 * @return string
	 */
	public function textInput(): string
	{
		$htmlInput = "<input {id} type='text' {classInput} {name}  value='{value}'>";

		return $this->generateHtmlContainer($htmlInput);
	}

	/**
	 * @return string
	 */
	public function checkboxInput(): string
	{
		$checked = $this->_value ? 'checked' : '';
		$htmlInput = "
			<input type='hidden' {name} value='0'>
			<input {id} type='checkbox' class='form-check-input' {name}  value='1' {$checked}>
		";

		return $this->generateHtmlContainer($htmlInput, $this->checkboxTemplate);
	}

	/**
	 * @param array $property
	 *
	 * @return string
	 */
	public function selectInput(array $list = [], array $property = []): string
	{
		$htmlInput = "<select {id} {classInput} {name}  value='{value}'>";
		if (isset($property['prompt'])) {
			$htmlInput .= "<option value=''>{$property['prompt']}</option>";
		}

		foreach ($list AS $key => $value) {
			$selected = $this->_value == $key ? "selected='selected'" : '';
			$htmlInput .= "<option value='{$key}' {$selected} >$value</option>";
		}
		$htmlInput .= "</select>";

		return $this->generateHtmlContainer($htmlInput);
	}

	/**
	 * @return string
	 */
	public function emailInput(): string
	{
		$htmlInput = "<input {id} type='email' {classInput} {name} value='{value}'>";

		return $this->generateHtmlContainer($htmlInput);
	}

	/**
	 * @return string
	 */
	public function passwordInput(): string
	{
		$htmlInput = "<input {id} type='password' {classInput} {name} value='{value}'>";

		return $this->generateHtmlContainer($htmlInput);
	}


	/**
	 * @return string
	 */
	public function textareaInput(): string
	{
		$htmlInput = "<textarea {id} {classInput} rows='3' {name}>{value}</textarea>";

		return $this->generateHtmlContainer($htmlInput);
	}


	/**
	 * @param string      $htmlInput
	 * @param null|string $template
	 *
	 * @return string|string[]
	 */
	private function generateHtmlContainer(string $htmlInput, $template = null)
	{
		$template = $template ?? $this->fieldTemplate;

		$error = current($this->_model->getError($this->_attribute));
		$value = $this->_model->{$this->_attribute};

		$classLabel = 'col-form-label col-sm-3';
		$classInput = 'form-control';
		if($error) {
			$classLabel .= ' text-danger';
			$classInput .= ' is-invalid';
		} elseif ($value) {
			$classLabel .= ' text-success';
			$classInput .= ' is-valid';
		}
		$classLabel = "class='{$classLabel}'";
		$classInput = "class='{$classInput}'";

		$inputId = "input-" . strtolower($this->_className). "-" . $this->_attribute;
		$id = "id='{$inputId}'";
		$for = "for='{$inputId}'";

		$label = $this->_model->getLabel($this->_attribute);
		$inputName = "name='{$this->_className}[{$this->_attribute}]'";

		$help = $error ? "<small class='text-danger'>{$error}</small>" : null;

		$inputHtml = str_replace(
			['{id}', '{classInput}', '{name}', '{value}'],
			[$id, $classInput, $inputName, $value],
			$htmlInput
		);

		return str_replace(
			['{for}', '{classLabel}', '{label}', '{input}', '{help}'],
			[$for, $classLabel, $label, $inputHtml, $help],
			$template
		);
	}


	/**
	 * @var ActiveModel
	 */
	private $_model;

	/**
	 * @var string
	 */
	private $_className;

	/**
	 * @var string
	 */
	private $_attribute;

	/**
	 * @var mixed
	 */
	private $_value;
}