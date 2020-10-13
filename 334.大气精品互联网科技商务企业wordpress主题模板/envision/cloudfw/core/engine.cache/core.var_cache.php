<?php
 
$cloudfw_var_cache = array();
 
/**
 * Get an object from the named static cache, or the entire
 * cache if $key is null. Note that this item will return NULL
 * if the $key is not cached OR if $key's cached value is NULL.
 */
function cloudfw_vc_get($cache_name, $key = NULL) {
   
  // The global array of static caches
  global $cloudfw_var_cache;
   
  // Check if the global cache exists
  if ($cloudfw_var_cache) {
     
    // The global cache exists; check if the named cache exists
    $cache = isset($cloudfw_var_cache[$cache_name]) ? $cloudfw_var_cache[$cache_name] : NULL;
   
    if ($cache && $key) {
      // If the named cache exists, and $key is set, return the cached value
      return $cache[$key];
    }
   
    // Else return the entire cache (which could be NULL)
    return $cache;
  }
}
 
 
/**
 * Return true if the cache item has been set (even if
 * the value is NULL). If
 * $key is null, this method returns true if the
 * named cache exists.
 */
function cloudfw_vc_isset($cache_name, $key = NULL) {
   
  // The global array of static caches
  global $cloudfw_var_cache;
   
  if ($key) {
    // Check if the keyed element exists
    if(!isset($cloudfw_var_cache[$cache_name])) {
      return FALSE;
    }
     
    return array_key_exists($key, $cloudfw_var_cache[$cache_name]);
  }
   
  // Else, check if the named cache exists
  return array_key_exists($cache_name, $cloudfw_var_cache);
 
  
}
 
 
/**
 * Put an object into the named static cache.
 */
function cloudfw_vc_set($cache_name, $key, $data) {
   
  // The global array of static caches
  global $cloudfw_var_cache;
   
  if (!isset($cloudfw_var_cache)) {
    // If $cloudfw_var_cache is not set, create it.
    $cloudfw_var_cache = array();
  }
   
  if (!isset($cloudfw_var_cache[$cache_name])) {
    // If the named cache does not exist, create it.
    $cloudfw_var_cache[$cache_name] = array();
  }
   
  // Store $data under $key in the named cache $cache_name
  return $cloudfw_var_cache[$cache_name][$key] = $data;
}
 
 
/**
 * Clear the key/value pair from the named cache. If $key is NULL,
 * the entire named cache will be cleared.
 */
function cloudfw_vc_clear($cache_name, $key = NULL) {
   
  // The global array of static caches
  global $cloudfw_var_cache;
   
  if ($key) {
    // Clear the keyed object
    unset($cloudfw_var_cache[$cache_name][$key]);
  }
  else {
    // Clear the entire named cache
    unset($cloudfw_var_cache[$cache_name]);
  }
}