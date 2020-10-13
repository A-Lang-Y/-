<?php 


class CloudFw_Map {
	private static $maps;
	private $map_id;
	private static $current_map;
	private $current_id;
	private $current;

	function __construct( $map_id = NULL ) {
		$this->create( $map_id );
	}


	public function create( $map_id = NULL ) {
		$this->flush();
		self::$current_map = array();

		if( $map_id ) {
			self::$maps[$map_id] = array();
			$this->map_id = $map_id;
		}
	}

	/**
	 *	Set ID
	 *
	 *	@since 1.0
	 */
	public function id( $id, $data = NULL, $auto_ID = false ) {
		$this->current_id = $id; 
		
		if ( $data || empty( self::$current_map[ $this->current_id ] ) )
			self::$current_map[ $this->current_id ] = $data;
		
		if ( $auto_ID )
			self::$current_map[ $this->current_id ]['ID'] = $id;
			
		return $this;
	}

	/**
	 *	Set Selector
	 *
	 *	@since 1.0
	 */
	public function selector( $selector ) {
		$selector = cloudfw_make_css_selector( $selector );
		
		if ( empty( self::$current_map[ $this->current_id ][ 'ID' ] ) )
			self::$current_map[ $this->current_id ][ 'ID' ] = $selector;
		else
			self::$current_map[ $this->current_id ][ 'ID' ] .= ', ' . $selector;

		return $this;
	}

	/**
	 *	Set Attribute
	 *
	 *	@since 1.0
	 */
	public function attr( $attr, $data = '', $important = false ) {
		if ( $attr == 'text-shadow-kit' ) {
			
			$this->attr( 'color', isset($data['color']) ? $data['color'] : NULL, $important );
			$this->attr( 'text-shadow-color', isset($data['text-shadow-color']) ? $data['text-shadow-color'] : NULL, $important );
			$this->attr( 'text-shadow-pos-v', isset($data['text-shadow-pos-v']) ? $data['text-shadow-pos-v'] : NULL, $important );
			$this->attr( 'text-shadow-pos-h', isset($data['text-shadow-pos-h']) ? $data['text-shadow-pos-h'] : NULL, $important );
			$this->attr( 'text-shadow-enable', isset($data['text-shadow-enable']) ? $data['text-shadow-enable'] : NULL, $important );
		
		}elseif ( $attr == 'border-kit' ) {
			
			$this->attr( 'border-width', isset($data['border-width']) ? $data['border-width'] : NULL, $important );
			$this->attr( 'border-style', isset($data['border-style']) ? $data['border-style'] : NULL, $important );
			$this->attr( 'border-color', isset($data['border-color']) ? $data['border-color'] : NULL, $important );
		
		} else {
			self::$current_map[ $this->current_id ][ $attr ] = $data;
	
			if ( $important ) {
				self::$current_map[ $this->current_id ][ 'important' ][] = $attr;
			}
		}

		return $this;
	}

	/**
	 *	Push Selctor
	 *
	 *	@since 1.0
	 */
	public function push( $parent_selector, $selector ) {
		if (!empty( $selector ) && isset(self::$current_map[ $parent_selector ][ 'ID' ]) )
			self::$current_map[ $parent_selector ][ 'ID' ] .= _if(!empty( self::$current_map[ $parent_selector ][ 'ID' ] ) , ', ' ) . $selector;

		return $this;
	}

	/**
	 *	Set Option
	 *
	 *	@since 1.0
	 */
	public function option( $id, $data = NULL ) {
		return $this->id ( PFIX . '_' . $id, $data, false ) ;
	}

	/**
	 *	Set Sub Option
	 *
	 *	@since 1.0
	 */
	public function sub( $sub_name, $data = '' ) {
		return $this->attr( $sub_name, $data );
	}

	/**
	 *	Sync
	 *
	 *	@since 1.0
	 */
	public function sync( $attr, $sync_id, $sync_attr, $important = false ) {
		self::$current_map[ $this->current_id ][ 'sync_skin' ][] = array( 
			'attribute'      => $attr, 
			'sync_id'        => $sync_id, 
			'sync_attribute' => $sync_attr, 
		);

		if ( $important )
			self::$current_map[ $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}

	/**
	 *	Typo Sync
	 *
	 *	@since 1.0
	 */
	public function sync_typo ( $attr, $sync_id, $sync_attr, $important = false ) {
		self::$current_map[ $this->current_id ][ 'sync_typo' ][] = array( 
			'attribute'      => $attr, 
			'sync_id'        => $sync_id, 
			'sync_attribute' => $sync_attr, 
		);

		if ( $important )
			self::$current_map[ $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}

	/**
	 *	Generates color.
	 *
	 *	@since 1.0
	 */
	public function generate_color( $to = 'darker', $percent, $attr, $target_id, $target_attr, $important = false ) {
		self::$current_map[ $this->current_id ][ 'generate_color' ][] = array( 
			'to'       		   => $to, 
			'percent'          => $percent, 
			'attribute'        => $attr, 
			'target_id'        => $target_id, 
			'target_attribute' => $target_attr, 
		);

		if ( $important )
			self::$current_map[ $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}
	
	/**
	 *	Generates darker color.
	 */
	public function darker( $percent, $attr, $target_id, $target_attr, $important = false ) {
		$this->generate_color( 'darker', $percent, $attr, $target_id, $target_attr, $important );
		return $this;
	}

	/**
	 *	Generates lighter color.
	 */
	public function lighter( $percent, $attr, $target_id, $target_attr, $important = false ) {
		$this->generate_color( 'lighter', $percent, $attr, $target_id, $target_attr, $important );
		return $this;
	}


	/**
	 *	Compare color.
	 *
	 *	@since 1.0
	 */
	public function compare_color( $compare, $to = 'darker', $percent, $attr, $target_id, $target_attr, $important = false ) {
		if ( !isset(self::$current_map[ 'auto-' . $this->current_id ]) ) {
			$temp = self::$current_map[ $this->current_id ]; unset(self::$current_map[ $this->current_id ]);
			self::$current_map[ 'auto-' . $this->current_id ][ 'ID' ] = $temp[ 'ID' ];
			self::$current_map[ $this->current_id ] = $temp; unset($temp);
		}

		self::$current_map[ 'auto-' . $this->current_id ][ 'compare_color' ][] = array( 
			'compare'      	   => $compare, 
			'to'       		   => $to, 
			'percent'          => $percent, 
			'attribute'        => $attr, 
			'target_id'        => $target_id, 
			'target_attribute' => $target_attr, 
		);

		if ( $important )
			self::$current_map[ 'auto-' . $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}

	/**
	 *	Check color is dark.
	 */
	public function is_dark( $to, $percent, $attr, $target_id, $target_attr, $important = false ) {
		$this->compare_color( 'is_dark', $to, $percent, $attr, $target_id, $target_attr, $important );
		return $this;
	}

	/**
	 *	Check color is dark.
	 */
	public function is_light( $to, $percent, $attr, $target_id, $target_attr, $important = false ) {
		$this->compare_color( 'is_light', $to, $percent, $attr, $target_id, $target_attr, $important );
		return $this;
	}

	/**
	 *	Media
	 *
	 *	@since 3.1
	 */
	public function media( $query ) {
		switch ($query) {
			case 'wide': 			$query = 'media (min-width: 1200px)'; break;
			case 'only_standard': 	$query = 'media (min-width: 979px) and (max-width: 1200px)'; break;
			case 'only_normal': 	$query = 'media (min-width: 979px)'; break;
			case 'only_mobile': 	$query = 'media (max-width: 979px)'; break;
			case 'tablet': 			$query = 'media (min-width: 768px) and (max-width: 979px)'; break;
			case 'phone': 			$query = 'media (max-width: 767px)'; break;
			case 'retina': 			$query = 'media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and ( min--moz-device-pixel-ratio: 2), only screen and ( -o-min-device-pixel-ratio: 2/1), only screen and ( min-device-pixel-ratio: 2),only screen and ( min-resolution: 192dpi), only screen and ( min-resolution: 1.5dppx)'; break;
		}

		self::$current_map[ $this->current_id ][ 'media' ] = $query;

        return $this;
	}

	/**
	 *	Summary
	 *
	 *	@since 1.0
	 */
	public function sum( $attr, $elements, $important = false ) {
		self::$current_map[ $this->current_id ][ 'sum' ][ $attr ] = $elements;

		if ( $important )
			self::$current_map[ $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}

	/**
	 *	Subtraction
	 *
	 *	@since 1.0
	 */
	public function subtraction( $attr, $elements, $important = false ) {
		self::$current_map[ $this->current_id ][ 'subtraction' ][ $attr ] = $elements;

		if ( $important )
			self::$current_map[ $this->current_id ][ 'important' ][] = $attr;

        return $this;
	}

	/**
	 *	Pattern
	 *
	 *	@since 1.0
	 */
	public function pattern( $attr, $pattern, $values ) {
		if ( !is_array($values) )
			$values = array( 0 => '' ); 

		$out = array_merge(array( 'pattern_' => $pattern ), $values);
		self::$current_map[ $this->current_id ][ $attr ] = $out;
        return $this;
	}

	/**
	 *	Condition
	 *
	 *	@since 1.0
	 */
	public function cond( $attr, $cond_id, $cond_attr ) {
		self::$current_map[ $this->current_id ][ 'condition' ][] = array( 'attribute' => $attr, $cond_attr => $cond_id );
        return $this;
	}

	/**
	 *	Defaults
	 *
	 *	@since 1.0
	 */
	public function check_default( $attr, $value ) {
		self::$current_map[ $this->current_id ][ 'defaults' ][ $attr ] = $value;
        return $this;
	}

	/**
	 *	Get the Map
	 *
	 *	@since 1.0
	 */
	public function get_map( $map_id = NULL ) {
		if ( !$map_id )
			$map_id = $this->map_id; 

		if ( $map_id )
			return self::$maps[$map_id];

		$this->flush();
		return self::$current_map;
	}

	/**
	 *	Flush
	 *
	 *	@since 1.0
	 */
	public function flush( $map_id = NULL  ) {
		if ( !$map_id )
			$map_id = $this->map_id; 

		if ( $map_id )
			$map = self::$maps[$map_id] = self::$current_map;

		self::$current_map = array();
		return isset($map) ? $map : array();
	}

	/**
	 *	Get All Maps
	 *
	 *	@since 1.0
	 */
	public function all_maps() {
		$this->flush();
		return self::$maps;
	}

}
