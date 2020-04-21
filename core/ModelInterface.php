<?php

namespace core;


interface ModelInterface
{

	/**
	 * @return array
	 */
	public function rules(): array;


	/**
	 * @param string $attribute
	 *
	 * @return string
	 */
	public function getLabel(string $attribute): string;

	/**
	 * @return bool
	 */
	public function hasErrors(): bool;

	/**
	 * @param string $attribute
	 * @param string $message
	 */
	public function addError(string $attribute, string $message): void;
}