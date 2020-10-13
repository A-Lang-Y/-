/*
 * waitForImages 1.4
 * -----------------
 * Provides a callback when all images have loaded in your given selector.
 * http://www.alexanderdickson.com/
 *
 *
 * Copyright (c) 2011 Alex Dickson
 * Licensed under the MIT licenses.
 * See website for more info.
 *
 */

(function(a){var b="waitForImages";a.waitForImages={hasImageProperties:["backgroundImage","listStyleImage","borderImage","borderCornerImage"]};a.expr[":"].uncached=function(b){if(!a(b).is('img[src!=""]')){return false}var c=document.createElement("img");c.src=b.src;return!c.complete};a.fn.waitForImages=function(c,d,e){if(a.isPlainObject(arguments[0])){d=c.each;e=c.waitForAll;c=c.finished}c=c||a.noop;d=d||a.noop;e=!!e;if(!a.isFunction(c)||!a.isFunction(d)){throw new TypeError("An invalid callback was supplied.")}return this.each(function(){var f=a(this),g=[];if(e){var h=a.waitForImages.hasImageProperties||[],i=/url\((['"]?)(.*?)\1\)/g;f.find("*").each(function(){var b=a(this);if(b.is("img:uncached")){g.push({src:b.attr("src"),element:b[0]})}a.each(h,function(a,c){var d=b.css(c);if(!d){return true}var e;while(e=i.exec(d)){g.push({src:e[2],element:b[0]})}})})}else{f.find("img:uncached").each(function(){g.push({src:this.src,element:this})})}var j=g.length,k=0;if(j==0){c.call(f[0])}a.each(g,function(e,g){var h=new Image;a(h).bind("load."+b+" error."+b,function(a){k++;d.call(g.element,k,j,a.type=="load");if(k==j){c.call(f[0]);return false}});h.src=g.src})})}})(jQuery)