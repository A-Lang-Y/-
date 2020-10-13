<?php


/**
 *	CloudFw Class to Transfer Dummy Datas
 *
 *	@version 1.0
 *	@since 	 3.0
 */
class CloudFw_Transfer_Dummy
{
	public $data;
	public $dir;
	public $filename;

	/**
	 *	Get data.
	 */
	public function data(){
		return $this->data;
	}

	/**
	 *	Get file data.
	 */
	public function get_file_data( $filename = NULL ){
		if ( $filename )
			$this->filename = $filename;
			
		if ( file_exists($this->filepath()) )
			$content = cloudfw_get_file_contents($this->filepath());
		else
			return sprintf( __('%s file cannot found.','cloudfw'), $this->filepath() );

		if ( $content ) {
			$this->data = unserialize(base64_decode( $content ));
			
			if ( $this->data )
				return $this->data;
		}

		return false;

	}

	/**
	 *	Export the datas as file
	 */
	public function export_as_file( $filename, $to = NULL ){
		cloudfw_file_create( $this->dir, $filename, $this->export() );
		return $this->dir . $filename;
	}

	/**
	 *	Get file path.
	 */
	public function filepath() {
		return $this->dir . $this->filename;
	}

}