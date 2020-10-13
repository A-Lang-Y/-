<?php
  header('content-type: application/json');
  //Sharrre by Julien Hany
  $json = array('url'=>'','count'=>0);
  $json['url'] = $_GET['url'];
  $url = urlencode($_GET['url']);
  $type = urlencode($_GET['type']);
  
  if(filter_var($_GET['url'], FILTER_VALIDATE_URL)){
    if($type == 'googlePlus'){  //source http://www.helmutgranda.com/2011/11/01/get-a-url-google-count-via-php/
      $content = parse("https://plusone.google.com/u/0/_/+1/fastbutton?url=".$url."&count=true");
      
      $dom = new DOMDocument;
      $dom->preserveWhiteSpace = false;
      @$dom->loadHTML($content);
      $domxpath = new DOMXPath($dom);
      $newDom = new DOMDocument;
      $newDom->formatOutput = true;
      
      $filtered = $domxpath->query("//div[@id='aggregateCount']");
      if (isset($filtered->item(0)->nodeValue))
      {
        $json['count'] = str_replace('>', '', $filtered->item(0)->nodeValue);
      }
    }
    else if($type == 'stumbleupon'){
      $content = parse("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=$url");
      
      $result = json_decode($content);
      if (isset($result->result->views))
      {
          $json['count'] = $result->result->views;
      }

    }
    else if($type == 'pinterest'){
      $content = parse("http://api.pinterest.com/v1/urls/count.json?callback=&url=$url");
      
      $result = json_decode(str_replace(array('(', ')'), array('', ''), $content));
      if (is_int($result->count))
      {
          $json['count'] = $result->count;
      }
    }
  }
  echo str_replace('\\/','/',json_encode($json));
  
  function parse( $url ){
    $args['method'] = 'GET';
    $args['timeout'] = 10;
    $args['connecttimeout'] = 10;
    $args['sslverify'] = FALSE;
    $args['sslverifyhost'] = 0;
    $args['maxredirs'] = 3;
    $args['followlocation'] = TRUE;
    $args['useragent'] = 'sharrre';
    $args['autoreferer'] = TRUE;

    if ( !is_wp_error( $response = wp_remote_request( $url, $args ) ) ) {
      $content = wp_remote_retrieve_body( $response ); 
    } else {
      $content = '';
    }

    return $content;
  }
?>
