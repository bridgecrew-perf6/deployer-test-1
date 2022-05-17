<?php


namespace Awps\Models;

use Awps\Core\PostType;

class Book {
	private $post_type;
	private $type_args = [];
	private $type_labels = [];

	public function register() {
		$this->set_labels();
		$this->set_args();
		$this->post_type = new PostType( 'Book', $this->type_labels, $this->type_args );
	}

	public function set_args() {
		$this->type_args = [
			'menu_icon' => 'dashicons-book'
		];
	}

	public function set_labels() {
		$this->type_labels = [];
	}
}
