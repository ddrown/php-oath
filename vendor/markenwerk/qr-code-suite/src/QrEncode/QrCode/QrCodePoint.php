<?php

namespace Markenwerk\QrCodeSuite\QrEncode\QrCode;

/**
 * Class QrCodePoint
 *
 * @package Markenwerk\QrCodeSuite\QrEncode
 */
class QrCodePoint
{

	/**
	 * @var bool
	 */
	private $active;

	/**
	 * QrCodePoint constructor.
	 *
	 * @param $active
	 */
	public function __construct($active)
	{
		$this->active = $active;
	}

	/**
	 * @return boolean
	 */
	public function isActive()
	{
		return $this->active;
	}

	/**
	 * @param boolean $active
	 * @return $this
	 */
	public function setActive($active)
	{
		$this->active = $active;
		return $this;
	}

}
