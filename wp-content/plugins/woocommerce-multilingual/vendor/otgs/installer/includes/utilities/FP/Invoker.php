<?php

namespace OTGS\Installer\FP;

class _Invoker {

	/**
	 * @var string
	 */
	private $fnName;
	/**
	 * @var mixed[]
	 */
	private $args = [];

	/**
	 * _Invoker constructor.
	 *
	 * @param string $fnName
	 */
	public function __construct( $fnName ) {
		$this->fnName = $fnName;
	}

	/**
	 * @param mixed ...$args
	 *
	 * @return _Invoker
	 */
	public function with( ...$args ) {
		$this->args = $args;
		return $this;
	}

	/**
	 * @param mixed $instance
	 *
	 * @return mixed
	 */
	public function __invoke( $instance ) {
		/** @var callable $callback */
		$callback = [ $instance, $this->fnName ];
		return call_user_func_array( $callback, $this->args );
	}
}