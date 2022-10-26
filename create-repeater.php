<?php

/**
 * @package  DwqPlugin
 */

use RepeaterMetaCallback;

/**
 * 
 */
class RepeaterCustomeFields
{
	public $repeater_callback;

	public function register()
	{
		$this->repeater_callback = new RepeaterMetaCallback();

		add_action('admin_init', [$this, 'single_repeater_meta_boxes'], 2);

		add_action('save_post', [$this, 'single_repeatable_meta_box_save']);
	}

	public function single_repeater_meta_boxes()
	{
		add_meta_box(
			'single-repeater-data',
			'Single Rapeater',
			[$this, 'single_repeatable_meta_box_callback'],
			'cursos',
			'normal',
			'default'
		);
	}

	public function single_repeatable_meta_box_save($post_id)
	{

		if (!isset($_POST['single_repeater_meta_boxes_nonce'])) return $post_id;

		$nonce = $_POST['single_repeater_meta_boxes_nonce'];
		$data = 'single_repeater_meta_boxes_data';

		if (!wp_verify_nonce($nonce, $data)) return $post_id;

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

		if (!current_user_can('edit_post', $post_id)) return $post_id;

		$old = get_post_meta($post_id, 'single_repeater_group', true);

		$new = [];
		$titles = $_POST['title'];
		$tdescs = $_POST['tdesc'];
		$count = count($titles);
		for ($i = 0; $i < $count; $i++) {
			if ($titles[$i] != '') {
				$new[$i]['title'] = stripslashes(strip_tags($titles[$i]));
				$new[$i]['tdesc'] = stripslashes($tdescs[$i]);
			}
		}

		if (!empty($new) && $new != $old) {
			update_post_meta($post_id, 'single_repeater_group', $new);
		} elseif (empty($new) && $old) {
			delete_post_meta($post_id, 'single_repeater_group', $old);
		}
		$repeter_status = $_REQUEST['repeter_status'];
		update_post_meta($post_id, 'repeter_status', $repeter_status);
	}
}
