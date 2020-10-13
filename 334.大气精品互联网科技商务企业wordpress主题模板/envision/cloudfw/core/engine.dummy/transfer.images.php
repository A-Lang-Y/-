<?php

include_once(TMP_PATH.'/cloudfw/core/engine.dummy/core.transfer.php');	

/**
 *	Export/Import Menu Datas
 *
 *	@version 1.0
 *	@since 	 3.0
 */
class CloudFw_Transfer_Images extends CloudFw_Transfer_Dummy
{
	/**
	 *	Construct.
	 */
	function __construct() {
		$this->dir = DUMMY_DIR_PATH . 'images/';
		$this->folder = DUMMY_DIR . 'images/';
		$this->images = array();
	}

	/**
	 *	Get images.
	 */
	public function get_images(){
		foreach( (array) glob( $this->dir . "*.{jpg,png,gif}", GLOB_BRACE ) as $image ){
			$image_basename =  basename( $image );
			$this->images[ $image_basename ]['path'] = $image; 
			$this->images[ $image_basename ]['url'] = $this->folder . $image_basename; 
		}

		return $this->images;

	}

	/**
	 *	Import.	
	 */
	public function import( $filename = NULL ){

		include_once ABSPATH . 'wp-admin/includes/file.php';
		global $wp_filesystem;
		WP_Filesystem( request_filesystem_credentials( '' ) );


		if ( isset($wp_filesystem->errors) && is_wp_error( $wp_filesystem->errors ) && !empty($wp_filesystem->errors->errors) ) {
			return $wp_filesystem->errors;
		}

		$this->get_images();
		if ( empty($this->images) || !is_array($this->images) )
			return false;

		foreach ((array) $this->images as $filename => $file_data) {
			$file = cloudfw_find_folder( CLOUDFW_UPLOADDIR_FULL . $filename );
			$file_abs = cloudfw_abs_path( $file );

			$source_file_abs = cloudfw_abs_path( $file_data['path'] );
			$source_file = cloudfw_find_folder($file_data['path']);

			$copy_result = $wp_filesystem->copy( $source_file, $file, true, FS_CHMOD_FILE);

			if ( !$copy_result || $wp_filesystem->exists($file) ) {
				unset($this->images[$filename]);
			}

			$wp_filetype = wp_check_filetype($filename, null);
			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment($attachment, $file_abs);
			$imagesize = getimagesize($source_file_abs);

			$metadata					= array();
			$metadata['width']			= $imagesize[0];
			$metadata['height']			= $imagesize[1];
			list($uwidth, $uheight)		= wp_constrain_dimensions($metadata['width'], $metadata['height'], 128, 96);
			$metadata['hwstring_small'] = "height='$uheight' width='$uwidth'";
			$metadata['file']			= _wp_relative_upload_path( $file_abs );

			global $_wp_additional_image_sizes;

			foreach (get_intermediate_image_sizes() as $s)
			{
				$sizes[$s] = array('name' => '', 'width' => '', 'height' => '', 'crop' => FALSE);
				$sizes[$s]['name'] = $s;

				if (isset($_wp_additional_image_sizes[$s]['width']))
					$sizes[$s]['width'] = intval($_wp_additional_image_sizes[$s]['width']);
				else
					$sizes[$s]['width'] = get_option("{$s}_size_w");


				if (isset($_wp_additional_image_sizes[$s]['height']))
					$sizes[$s]['height'] = intval($_wp_additional_image_sizes[$s]['height']);
				else
					$sizes[$s]['height'] = get_option("{$s}_size_h");

				if (isset($_wp_additional_image_sizes[$s]['crop']))
					$sizes[$s]['crop'] = intval($_wp_additional_image_sizes[$s]['crop']);
				else
					$sizes[$s]['crop'] = get_option("{$s}_crop");

				if ( empty($sizes[$s]['width']) || empty($sizes[$s]['height']) )
					unset($sizes[$s]);
				
			}

			$sizes = apply_filters('intermediate_image_sizes_advanced', $sizes);			
			@set_time_limit(0);

			foreach ($sizes as $size => $size_data) {
				$metadata['sizes'][$size] = image_make_intermediate_size(
					$file, 
					isset($size['width']) ? $size['width'] : NULL, 
					isset($size['height']) ? $size['height'] : NULL, 
					isset($size['crop']) ? $size['crop'] : NULL
				);
			}

			apply_filters('wp_generate_attachment_metadata', $metadata, $attach_id);
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$att_data = wp_generate_attachment_metadata($attach_id, $file_abs);
			wp_update_attachment_metadata($attach_id, $att_data);

			$attach_ids[] = $attach_id;
			$this->images[ $filename ]['path_uploads'] = $file;
			$this->images[ $filename ]['id'] = $attach_id;

			if ( empty($this->default_image) )
				$this->default_image = $filename; 

		}

		$args = array(
			"post_type" => apply_filters( 'cloudfw_post_types_for_dummy_thumbnails', array( 'page', 'post' ) ),
			"posts_per_page" => "-1"
		);

		if ( !empty($this->images) || is_array($this->images) ) {

			$all_query = new WP_Query($args);
			while ($all_query->have_posts()) : $all_query->the_post();
				if ( has_post_thumbnail( get_the_ID() ) ) {
					$dummy_thumbnail = get_post_meta(get_the_ID(), PFIX.'_dummy_thumbnail', true);

					if ( $dummy_thumbnail && isset( $this->images[ $dummy_thumbnail ] ) )
						$the_thumbnail = $dummy_thumbnail;
					else
						$the_thumbnail = array_rand($this->images);
						
					set_post_thumbnail(get_the_ID(), $this->images[ $the_thumbnail ]['id']);

				}
			endwhile;

		}

	}

}