<?php
/*
* Version 2.0.3
* The base class for the storm twitter feed for developers.
* This class provides all the things needed for the wordpress plugin, but in theory means you don't need to use it with wordpress.
* What could go wrong?
*/


if ( !class_exists('StormTwitter') ) {

  if ( !class_exists('TwitterOAuth') ) {
    require_once('oauth/twitteroauth.php');
  }

  class StormTwitter {

    private $defaults = array(
      'directory' => '',
      'key' => '',
      'secret' => '',
      'token' => '',
      'token_secret' => '',
      'screenname' => '',
      'cache_expire' => 3600      
    );
    
    public $st_last_error = false;
    
    function __construct($args = array()) {
      $this->defaults = array_merge($this->defaults, $args);
    }
    
    function __toString() {
      return print_r($this->defaults, true);
    }
    
    //I'd prefer to put username before count, but for backwards compatibility it's not really viable. :(
    function getTweets( $count = 20, $screenname = false, $options = false ) {
      if ($count > 20) $count = 20;
      if ($count < 1) $count = 1;
      
      $default_options = array('trim_user' => false, 'exclude_replies' => true, 'include_rts' => false);
      
      if ($options === false || !is_array($options)) {
        $options = $default_options;
      } else {
        $options = array_merge($default_options, $options);
      }
      
      if ($screenname === false) $screenname = $this->defaults['screenname'];
    
      $result = $this->checkValidCache( $screenname, $options );
      
      if ( $result !== false && $result !== null ) {
        return $this->cropTweets( $result, $count );
      }
      
      //If we're here, we need to load.
      $result = $this->oauthGetTweets( $screenname, $options );

      if (isset($result['errors'])) {
        if (is_array($result) && isset($result['errors'][0]) && isset($result['errors'][0]['message'])) {
          $last_error = $result['errors'][0]['message'];
        } else {
          $last_error = $result['errors'];
        }
        return array( 'error' => 'Twitter said: '. $last_error );
      } else {
        return $this->cropTweets($result,$count);
      }
      
    }
    
    private function cropTweets($result,$count) {
      if ( is_array($result) )
        return array_slice($result, 0, $count);
      else
        return false;
    }
    
    private function getOptionsHash($screenname, $options) {
      $hash = md5($screenname . serialize($options));
      return $hash;
    }
    
    private function checkValidCache($screenname,$options) {
      $cachename = $this->getOptionsHash( $screenname, $options );
      $result = get_transient( $cachename );

      if ( false !== $result && $result !== null )
        return json_decode( $result, true );
      else {
        delete_transient( $cachename );
        return false;
      }
    }
    
    private function oauthGetTweets($screenname, $options) {
      $key = $this->defaults['key'];
      $secret = $this->defaults['secret'];
      $token = $this->defaults['token'];
      $token_secret = $this->defaults['token_secret'];
      $cache_expire = $this->defaults['cache_expire'];
            
      $cachename = $this->getOptionsHash( $screenname, $options );

      $options = array_merge($options, array('screen_name' => $screenname, 'count' => 20));
      
      if (empty($key)) return array( 'error' => 'Missing Consumer Key' );
      if (empty($secret)) return array( 'error' => 'Missing Consumer Secret' );
      if (empty($token)) return array( 'error' => 'Missing Access Token' );
      if (empty($token_secret)) return array( 'error' => 'Missing Access Token Secret' );
      if (empty($screenname)) return array( 'error' => 'Missing Twitter Feed Screen Name' );
      
      $connection = new TwitterOAuth($key, $secret, $token, $token_secret);
      $result = $connection->get('statuses/user_timeline', $options);

      if (!isset($result['errors']) && $result !== false) {
        set_transient( $cachename, json_encode($result), $cache_expire );

      } else {
        if (is_array($result) && isset($result['errors'][0]) && isset($result['errors'][0]['message'])) {
          $last_error = '['.date('r').'] Twitter error: '.$result['errors'][0]['message'];
          $this->st_last_error = $last_error;
        } else {
          $last_error = '['.date('r').'] Twitter returned an invalid response. It is probably down.';
          $this->st_last_error = $last_error;
        }
      }
      
      return $result;
    
    }
  }

}