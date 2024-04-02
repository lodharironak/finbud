<?php

namespace WPML\CF7;

class Translations implements \IWPML_Backend_Action {

	/**
	 * Adds the required hooks.
	 */
	public function add_hooks() {
		add_filter( 'icl_job_elements', array( $this, 'remove_body_from_translation_job' ), 10, 2 );
		add_filter( 'wpml_document_view_item_link', array( $this, 'document_view_item_link' ), 10, 5 );
		add_filter( 'wpml_document_edit_item_link', array( $this, 'document_edit_item_link' ), 10, 5 );
		add_action( 'save_post', array( $this, 'fix_setting_language_information' ) );
	}


	/**
	 * Don't translate the post_content of contact forms.
	 *
	 * @param array $elements Translation job elements.
	 * @param int   $post_id  The post ID.
	 *
	 * @return array
	 */
	public function remove_body_from_translation_job( $elements, $post_id ) {
		// Bail out early if its not a CF7 form.
		if ( Constants::POST_TYPE !== get_post_type( $post_id ) ) {
			return $elements;
		}

		// Search for the body element and empty it so that it's not displayed in the TE.
		$field_types = wp_list_pluck( $elements, 'field_type' );
		$index       = array_search( 'body', $field_types, true );
		if ( false !== $index ) {
			$elements[ $index ]->field_data            = '';
			$elements[ $index ]->field_data_translated = '';
		}

		return $elements;
	}

	/**
	 * Remove the 'View' link from translation jobs because Contact
	 * Forms don't have a link to 'View' them.
	 *
	 * @param string $link   The complete link.
	 * @param string $text   The text to link.
	 * @param object $job    The corresponding translation job.
	 * @param string $prefix The prefix of the element type.
	 * @param string $type   The element type.
	 *
	 * @return string
	 */
	public function document_view_item_link( $link, $text, $job, $prefix, $type ) {
		if ( Constants::POST_TYPE === $type ) {
			$link = '';
		}

		return $link;
	}

	/**
	 * Adjust the 'Edit' link from translation jobs because Contact
	 * Forms have a different URL for editing.
	 *
	 * @param string $link             The complete link.
	 * @param string $text             The text to link.
	 * @param object $current_document The document to translate.
	 * @param string $prefix           The prefix of the element type.
	 * @param string $type             The element type.
	 *
	 * @return string
	 */
	public function document_edit_item_link( $link, $text, $current_document, $prefix, $type ) {
		if ( Constants::POST_TYPE === $type ) {
			$url  = sprintf( 'admin.php?page=wpcf7&post=%d&action=edit', $current_document->ID );
			$link = sprintf( '<a href="%s">%s</a>', admin_url( $url ), $text );
		}

		return $link;
	}

	/**
	 * CF7 sets post_ID to -1 for new forms.
	 * WPML thinks we are saving a different post and doesn't save language information.
	 * Removing it fixes the misunderstanding.
	 */
	public function fix_setting_language_information() {
		if ( empty( $_POST['_wpnonce'] ) || empty( $_POST['post_ID'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'wpcf7-save-contact-form_' . $_POST['post_ID'] ) ) {
			return;
		}

		if ( -1 === (int) $_POST['post_ID'] ) {
			unset( $_POST['post_ID'] );
		}
	}

}
