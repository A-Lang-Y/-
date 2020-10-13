<?php
/**
 * Resize images dynamically using wp built in functions
 * Victor Teixeira
 *
 * php 5.2+
 *
 * Exemplo de uso:
 * 
 * <?php 
 * $thumb = get_post_thumbnail_id(); 
 * $image = vt_resize( $thumb, '', 140, 110, true );
 * ?>
 * <img src="<?php echo $image[url]; ?>" width="<?php echo $image[width]; ?>" height="<?php echo $image[height]; ?>" />
 *
 * @param int $attach_id
 * @param string $img_url
 * @param int $width
 * @param int $height
 * @param bool $crop
 * @return array
 */
if ( !function_exists( 'vt_resize') ) {
	function vt_resize( $attach_id = null, $img_url = null, $width, $height, $crop = false ) {
 
		// this is an attachment, so we have the ID
		if ( $attach_id ) {
 
			$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
			$file_path = get_attached_file( $attach_id );
 
		// this is not an attachment, let's use the image url
		} else if ( $img_url ) {
 
			$file_path = parse_url( $img_url );
			$file_path = $_SERVER['DOCUMENT_ROOT'] . $file_path['path'];
 
			// Look for Multisite Path
			if(file_exists($file_path) === false){
				global $blog_id;
				$file_path = parse_url( $img_url );
				if (preg_match("/files/", $file_path['path'])) {
					$path = explode('/',$file_path['path']);
					foreach($path as $k=>$v){
						if($v == 'files'){
							$path[$k-1] = 'wp-content/blogs.dir/'.$blog_id;
						}
					}
					$path = implode('/',$path);
				}
				$file_path = $_SERVER['DOCUMENT_ROOT'].$path;
			}
			//$file_path = ltrim( $file_path['path'], '/' );
			//$file_path = rtrim( ABSPATH, '/' ).$file_path['path'];
 
			$orig_size = getimagesize( $file_path );
 
			$image_src[0] = $img_url;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
 
		$file_info = pathinfo( $file_path );
 
		// check if file exists
		$base_file = $file_info['dirname'].'/'.$file_info['filename'].'.'.$file_info['extension'];
		if ( !file_exists($base_file) )
		 return;
 
		$extension = '.'. $file_info['extension'];
 
		// the image path without the extension
		$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
 
		$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
 
		// checking if the file size is larger than the target size
		// if it is smaller or the same size, stop right here and return
		if ( $image_src[1] > $width ) {
 
			// the file is larger, check if the resized version already exists (for $crop = true but will also work for $crop = false if the sizes match)
			if ( file_exists( $cropped_img_path ) ) {
 
				$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
 
				$vt_image = array (
					'url' => $cropped_img_url,
					'width' => $width,
					'height' => $height
				);
 
				return $vt_image;
			}
 
			// $crop = false or no height set
			if ( $crop == false OR !$height ) {
 
				// calculate the size proportionaly
				$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
				$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;
 
				// checking if the file already exists
				if ( file_exists( $resized_img_path ) ) {
 
					$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
 
					$vt_image = array (
						'url' => $resized_img_url,
						'width' => $proportional_size[0],
						'height' => $proportional_size[1]
					);
 
					return $vt_image;
				}
			}
 
			// check if image width is smaller than set width
			$img_size = getimagesize( $file_path );
			if ( $img_size[0] <= $width ) $width = $img_size[0];
 
			// Check if GD Library installed
			if (!function_exists ('imagecreatetruecolor')) {
			    echo 'GD Library Error: imagecreatetruecolor does not exist - please contact your webhost and ask them to install the GD library';
			    return;
			}
 
			// no cache files - let's finally resize it
			$editor = wp_get_image_editor( $file_path );
			if ( is_wp_error( $editor ) )
			    return $editor;

			$editor->set_quality( 100 );
			$resized = $editor->resize( $width, $height, $crop );
			$new_img_path = $editor->generate_filename( NULL, NULL );
			$saved = $editor->save( $new_img_path );
			
			if ( is_wp_error( $saved ) )
			    return $saved;


			$new_img_size = getimagesize( $new_img_path );
			$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
 
			// resized output
			$vt_image = array (
				'url' => $new_img,
				'width' => $new_img_size[0],
				'height' => $new_img_size[1]
			);
 
			return $vt_image;
		}
 
		// default output - without resizing
		$vt_image = array (
			'url' => $image_src[0],
			'width' => $width,
			'height' => $height
		);
 
		return $vt_image;
	}

}