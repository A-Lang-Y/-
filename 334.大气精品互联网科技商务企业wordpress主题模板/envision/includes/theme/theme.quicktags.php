<?php

function cloudfw_quicktags(){

	// CloudFW Quick Tags
	$tags["h1"] = array('<h1>','</h1>');
	$tags["h2"] = array('<h2>','</h2>');
	$tags["h3"] = array('<h3>','</h3>');
	$tags["h4"] = array('<h4>','</h4>');
	$tags["h5"] = array('<h5>','</h5>');
	$tags["h6"] = array('<h6>','</h6>');
	$tags["title1"] = array('[title1]','[/title1]');
	$tags["1/2"] = array('[1of2]','[/1of2]');
	$tags["1/2 last"] = array('[1of2_last]','[/1of2_last]');
	$tags["1/3"] = array('[1of3]','[/1of3]');
	$tags["1/3 last"] = array('[1of3_last]','[/1of3_last]');
	$tags["2/3"] = array('[2of3]','[/2of3]');
	$tags["2/3 last"] = array('[2of3_last]','[/2of3_last]');
	$tags["1/4"] = array('[1of4]','[/1of4]');
	$tags["1/4 last"] = array('[1of4_last]','[/1of4_last]');
	$tags["3/4"] = array('[3of4]','[/3of4]');
	$tags["3/4 last"] = array('[3of4_last]','[/3of4_last]');
	$tags["1/5"] = array('[1of5]','[/1of5]');
	$tags["1/5 last"] = array('[1of5_last]','[/1of5_last]');
	$tags["2/5"] = array('[2of5]','[/2of5]');
	$tags["2/5 last"] = array('[2of5_last]','[/2of5_last]');
	$tags["3/5"] = array('[3of5]','[/3of5]');
	$tags["3/5 last"] = array('[3of5_last]','[/3of5_last]');
	$tags["4/5"] = array('[4of5]','[/4of5]');
	$tags["4/5 last"] = array('[4of5_last]','[/4of5_last]');
	$tags["1/6"] = array('[1of6]','[/1of6]');
	$tags["1/6 last"] = array('[1of6_last]','[/1of6_last]');
	$tags["5/6"] = array('[5of6]','[/5of6]');
	$tags["5/6 last"] = array('[5of6_last]','[/5of6_last]');
	$tags["pre*"] = array('[pre]','[/pre]');
	$tags["container"] = array('[container]','[/container]');
	$tags["left"] = array('[left]','[/left]');
	$tags["right"] = array('[right]','[/right]');
	$tags["no overflow"] = array('[no_overflow]','[/no_overflow]');
	$tags["solid divider"] = array('[divider]','');
	$tags["dotted divider"] = array('[divider_dotted]','');
	$tags["smooth divider"] = array('[divider_smooth]','');
	$tags["highlight1"] = array('[highlight1]','[/highlight1]');
	$tags["highlight2"] = array('[highlight2]','[/highlight2]');
	$tags["space"] = array('[space]','');
	$tags["up"] = array('[up]','');
	$tags["down"] = array('[down]','');

	return apply_filters('cloudfw_quicktags', $tags);
}