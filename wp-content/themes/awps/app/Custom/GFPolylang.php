<?php
/**
 * Enqueue theme assets
 *
 * @package atlex
 */

namespace Awps\Custom;


use GFAPI;

class GFPolylang {

	private $whitelist;
	private $blacklist;
	private $registered_strings;
	private $form;


	public function __construct() {

		$this->whitelist = array(
			'title',
			'description',
			'text',
			'content',
			'message',
			'defaultValue',
			'errorMessage',
			'placeholder',
			'label',
			'customLabel',
			'value',
			'subject',
			'tooltiptext',
			'checkboxLabel'
		);

		$this->blacklist = array();

		$this->registered_strings = array();

	}

	public function register() {
		add_action( 'init', [ $this, 'register_strings' ] );

		add_filter( 'gform_pre_render', [ $this, 'translate_strings' ] );

		add_filter( 'gform_pre_process', [ $this, 'translate_strings' ] );
	}


	private function is_translatable( $key, $value ) {
		return
			$key &&
			in_array( $key, $this->whitelist ) &&
			is_string( $value ) &&
			! in_array( $value, $this->registered_strings );

	}


	private function iterate_form( &$value, $key, $callback = null ) {

		if ( ! $callback && is_callable( $key ) ) {
			$callback = $key;
		}

		if ( is_array( $value ) || is_object( $value ) ) {
			foreach ( $value as $new_key => &$new_value ) {
				if ( ! ( in_array( $new_key, $this->blacklist ) && ! is_numeric( $new_key ) ) ) {
					$this->iterate_form( $new_value, $new_key, $callback );
				}
			}
		} else {
			if ( $this->is_translatable( $key, $value ) ) {
				$callback( $value, $key );
			}
		}
	}


	public function register_strings() {

		if ( ! class_exists( 'GFAPI' ) || ! function_exists( 'pll_register_string' ) ) {
			return;
		}

		$forms = GFAPI::get_forms();
		foreach ( $forms as $form ) {
			$this->form               = $form;
			$this->registered_strings = array();
			$this->iterate_form( $form, function ( $value, $key ) {
				$name  = sanitize_title( $this->translit( $value ) );
				$group = "Form #{$this->form['id']}: {$this->form['title']}";
				pll_register_string( $name, $value, $group );
			} );
		}

	}

	public function translate_strings( $form ) {

		if ( function_exists( 'pll__' ) ) {
			$this->iterate_form( $form, function ( &$value, $key ) {
				$value = pll__( $value );
			} );
		}

		return $form;

	}

    /**
	 * Translit string
	 */
	public function translit( $value ) {
		$converter = array(
			'а' => 'a',
			'б' => 'b',
			'в' => 'v',
			'г' => 'g',
			'д' => 'd',
			'е' => 'e',
			'ё' => 'e',
			'ж' => 'zh',
			'з' => 'z',
			'и' => 'i',
			'й' => 'y',
			'к' => 'k',
			'л' => 'l',
			'м' => 'm',
			'н' => 'n',
			'о' => 'o',
			'п' => 'p',
			'р' => 'r',
			'с' => 's',
			'т' => 't',
			'у' => 'u',
			'ф' => 'f',
			'х' => 'h',
			'ц' => 'c',
			'ч' => 'ch',
			'ш' => 'sh',
			'щ' => 'sch',
			'ь' => '',
			'ы' => 'y',
			'ъ' => '',
			'э' => 'e',
			'ю' => 'yu',
			'я' => 'ya',

			'А' => 'A',
			'Б' => 'B',
			'В' => 'V',
			'Г' => 'G',
			'Д' => 'D',
			'Е' => 'E',
			'Ё' => 'E',
			'Ж' => 'Zh',
			'З' => 'Z',
			'И' => 'I',
			'Й' => 'Y',
			'К' => 'K',
			'Л' => 'L',
			'М' => 'M',
			'Н' => 'N',
			'О' => 'O',
			'П' => 'P',
			'Р' => 'R',
			'С' => 'S',
			'Т' => 'T',
			'У' => 'U',
			'Ф' => 'F',
			'Х' => 'H',
			'Ц' => 'C',
			'Ч' => 'Ch',
			'Ш' => 'Sh',
			'Щ' => 'Sch',
			'Ь' => '',
			'Ы' => 'Y',
			'Ъ' => '',
			'Э' => 'E',
			'Ю' => 'Yu',
			'Я' => 'Ya',
		);

		$value = strtr( $value, $converter );

		return $value;
	}

}
