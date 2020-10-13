<?php
/**
 * Utility functions
 */

function dw_timeline_is_element_empty($element) {
  $element = trim($element);
  return empty($element) ? false : true;
}
