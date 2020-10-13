/*
 * Simple HTML5 Audio Player V1
 * http://codecanyon.net/item/simple-html5-audio-player-v1/495024
 *
 * Author: Ivan da Silveira
 * Version: 1.1.3
 * Copyright 2011
 *
 * Only for the sale at the envato marketplaces
 */
(function($)
{	
		
var DEBUG						= false;	

// global variables
var win							= window;
var $win						= $(win);
var doc							= document;
var $doc						= $(doc);
var nav							= navigator;
var initCount					= 0;

/**
 * @type {Object.<AudioPlayer>}
 */
var collection					= [];

var animationFrameCollection	= [];

/**
 * @type {Object.<FlashFallbackController>}
 */
var flashCollection				= [];

var AUDIO_PLAYER_ID		= 'AudioPlayerV1';

var TEMPLATE			= '<ul class="AudioPlayerV1 APV1_wrapper"><li><div class="APV1_play_button"></div></li><li><div class="APV1_seperator APV1_for_play"></div></li><li><div class="APV1_seperator APV1_for_time"></div></li><li class="APV1_container"><div class="APV1_progress_bar_container"><div class="APV1_progress_bar_wrapper"><div class="APV1_seek_bar"></div><div class="APV1_play_bar APV1_transition"></div></div></div></li><li><div class="APV1_seperator APV1_for_duration"></div></li><li><div class="APV1_time_text"> 00:00 </div></li><li><div class="APV1_duration_text"> 00:00 </div></li><li><div class="APV1_seperator APV1_for_volume"></div></li><li><div class="APV1_volume_button"></div></li><li><div class="APV1_volume_bar_container"><div class="APV1_volume_bar"></div></div></li></ul>';

var FN = 'fn';

var SHOCKWAVE_FLASH		= "Shockwave Flash";
var SHOCKWAVE_FLASH_AX	= "ShockwaveFlash.ShockwaveFlash";
var FLASH_MIME_TYPE		= "application/x-shockwave-flash";
var PLAYER_VERSION		= '10';

var PREFIX_CALLBACK		= 'APV1_';
var PREFIX_FLASH_PROTO	= '__flash__';



var animationFrame = (
	((win['requestAnimationFrame'] && win['cancelRequestAnimationFrame'])				? win['requestAnimationFrame']			: undefined) ||
	((win['webkitRequestAnimationFrame'] && win['webkitCancelRequestAnimationFrame'])	? win['webkitRequestAnimationFrame']	: undefined) ||
	((win['mozRequestAnimationFrame'] && win['mozCancelRequestAnimationFrame'])			? win['mozRequestAnimationFrame']		: undefined) ||
	((win['oRequestAnimationFrame'] && win['oCancelRequestAnimationFrame'])				? win['oRequestAnimationFrame']			: undefined) ||
	((win['msRequestAnimationFrame'] && win['msCancelRequestAnimationFrame'])			? win['msRequestAnimationFrame']		: undefined) ||
	undefined
);

var cancelAnimationFrame = (
	win['cancelRequestAnimationFrame']			||
	win['webkitCancelRequestAnimationFrame']	||
	win['mozCancelRequestAnimationFrame']		||
	win['oCancelRequestAnimationFrame']			||
	win['msCancelRequestAnimationFrame']		||
	undefined
);

/**
 * Enum for media event values.
 * @enum {string}
 */
var MediaEvent = 
{
	READY			: 'ready',
	PROGRESS		: 'progress',
	TIME_UPDATE		: 'timeupdate', 
	CAN_PLAY		: 'canplay',
	RATE_CHANGE		: 'ratechange',
	PLAYING			: 'playing',
	WAITING			: 'waiting',
	STARTED			: 'started',
	PLAY			: 'play',
	PAUSE			: 'pause',
	ENDED			: 'ended',
	VOLUME_CHANGE	: 'volumechange',
	DURATION_CHANGE	: 'durationchange',
	ERROR			: 'error'
};

/**
 * Enum for mouse event values.
 * @enum {string}
 */
var MouseEvent =
{
	CLICK			: 'click',
	MOUSE_DOWN		: 'mousedown',
	MOUSE_UP		: 'mouseup',
	MOUSE_OUT		: 'mouseout',
	MOUSE_MOVE		: 'mousemove',
	CONTEXT_MENU	: 'contextmenu'
};

/**
 * Enum for class values.
 * @enum {string}
 */
var Classes =
{
	TRANSITION	: 'APV1_transition',
	PLAYING		: 'APV1_playing',
	MUTE		: 'APV1_mute',
	ERROR		: 'APV1_error'
};

/**
 * Enum for css values.
 * @enum {string}
 */
var Values =
{
	DISPLAY_BLOCK	: 'display:block !important;',
	DISPLAY_NONE	: 'display:none !important;',
	ZERO			: '0 !important;',
	STYLE			: 'style'
};

/**
 * Enum for attributes values.
 * @enum {string}
 */
var Attributes =
{
	DATA_CONTROLS_TIME		: 'data-controls-time',
	DATA_CONTROLS_VOLUME	: 'data-controls-volume',
	DATA_CONTROLS_DURATION	: 'data-controls-duration',
	DATA_VOLUME				: 'data-volume',
	DATA_FALLBACK			: 'data-fallback',
	WIDTH					: 'width',
	HEIGHT					: 'height',
	CONTROLS				: 'controls'
};


/**
 * Enum for Flash parameters.
 * @enum {string}
 */
var FlashParams	=
{
	'menu'				: 'false',
	'quality'			: 'low',
	'wmode'				: 'window',
	'allowScriptAccess'	: 'sameDomain'
};







if(isDefined($[FN][AUDIO_PLAYER_ID]))return;

function isIE()
{
	return $['browser']['msie'] && parseInt($['browser']['version'], 10) <= 8;
}

(function fixIE()
{
	if(isIE())
	{
		doc.createElement('audio');
		doc.createElement('source');
	}
})();

function getObjectById(objectIdStr) {
	var r = null;
	var o = doc.getElementById(objectIdStr);
	if (o && o.nodeName == "OBJECT") {
		if (typeof o.SetVariable != 'undefined') {
			r = o;
		}
		else {
			var n = o.getElementsByTagName(OBJECT)[0];
			if (n) {
				r = n;
			}
		}
	}
	return r;
}

function flashAvailable()
{
	if(!isDefined(this.available))
	{
		var playerVersion	= null;
		var description		= null;
		
		if(isDefined(nav.plugins) && isObject(nav.plugins[SHOCKWAVE_FLASH]))
		{
			description = nav.plugins[SHOCKWAVE_FLASH].description;
		
			if(description &&
				!(
					isDefined(nav.mimeTypes) &&
					isDefined(nav.mimeTypes[FLASH_MIME_TYPE]) &&
					!isDefined(nav.mimeTypes[FLASH_MIME_TYPE].enabledPlugin)
				)
			)
			{
				description = description.replace(/^.*\s+(\S+\s+\S+$)/, "$1");
				playerVersion = parseInt(description.replace(/^(.*)\..*$/, "$1"), 10);
			}
		}
		else if(isDefined(win.ActiveXObject))
		{
			try
			{
				var activeXObject = new ActiveXObject(SHOCKWAVE_FLASH_AX);
				if(activeXObject)
				{
					description = activeXObject.GetVariable("$version");
					if(description)
					{
						description = description.split(" ")[1].split(",");
						playerVersion = parseInt(description[0], 10);
					}
				}
			}
			catch(e){}
		}
		
		this.available = (parseInt(PLAYER_VERSION, 10) <= playerVersion);
	}
	
	return this.available;
}


function createSWF(id, object, flashSrc, audioSrc, volume, loop, autoplay, preload)
{
	var element;
	var value;
	var key;
	
	FlashParams['name']			= 	id;
	FlashParams['flashvars']	= 	'src='+audioSrc+
									'&volume='+volume+
									'&loop='+loop+
									'&autoplay='+autoplay+
									'&preload='+preload+
									'&id='+id;
		
	if(isIE())
	{
		FlashParams['movie'] = flashSrc;
		
		var params = '';
		for (key in FlashParams)
		{
			value = FlashParams[key];
			if(value != Object.prototype[key])
			{
				params += '<param name="'+key+'" value="'+value+'" />';
			}
		}
		
		/*
		element = $('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="'+id+'" width="0" height="0">'+params+'</object>');
		object.after(element);
		//*/
		//*
		var div = $('<div>');
		after(object, div);
		div.get(0).outerHTML = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" id="'+id+'" width="0" height="0">'+params+'</object>';
		//*/
	}
	else
	{
		element = $('<object id="'+id+'" width="0" height="0" data="'+flashSrc+'" type="'+FLASH_MIME_TYPE+'">');	
		
		for (key in FlashParams)
		{
			value = FlashParams[key];
			if(value != Object.prototype[key] && key != 'movie')
			{
				append(element, $('<param name="'+key+'" value="'+value+'">'));
			}
		}
		
		after(object, element);
	}
}


function callAnimationFrame(callback, index)
{
	if(isDefined(animationFrame))
	{
		if(isDefined(index))
		{
			callCancelAnimationFrame(index);
			
			var id = animationFrame(function()
			{				
				animationFrameCollection[index] = null;
				callback.call();
			});
			animationFrameCollection[index] = id;
			return id;
		}
		else
		{
			return animationFrame(callback);
		}
	}
	else
	{
		return callback.call();
	}
}


function callCancelAnimationFrame(index)
{
	if(index && isDefined(cancelAnimationFrame))
	{
		var id = animationFrameCollection[index];
		if(id)
		{
			cancelAnimationFrame(id);
		}
	}
}



function getAudioTypeBySource(source)
{
	var ext = getFileExtension(source);
	var type;
	
	if(ext)
	{
		if(ext.match(/m(p3|3a)/i))								type = 'mpeg';
		else if(ext.match(/m4a|mp4/i))							type = 'mp4';
		else if(ext.match(/webm|webma/i))						type = 'webm';
		else if(ext.match(/wav/i))								type = 'wav';
		else if(ext.match(/og[ga]/i))							type = 'ogg';
		//else													type = 'mpeg';
	}
	
	return isDefined(type) ? 'audio/'+type : '';
}

function getFileExtension(filename)
{
	var ext = /^.+\.([^.]+)$/.exec(filename);
	return isNull(ext) ? null : ext[1];
}


/**
 * Get a string formatted as time.
 * @param {number} time.
 * @param {number=} opt_duration (optional).
 * @return {string}
 */
function getCurrentTime(time, opt_duration)
{
	var t = parseInt(time, 10),
		h = Math.floor(t / 3600),
		m = Math.floor(t % 3600 / 60),
		s = Math.floor(t % 3600 % 60);
	
	if(opt_duration)
	{
		var d = parseInt(opt_duration, 10),
			dh = Math.floor(d / 3600);
		
		return ((h > 0 ? (dh < 10 || h > 9 ? h + ":" : "0" + h + ":") : (dh > 0 ? (dh < 10 ? "0:" : "00:") : "")) + (m > 0 ? (m < 10 ? "0" : "") + m + ":" : "00:") + (s < 10 ? "0" : "") + s);
	}
	else
		return ((h > 0 ? h + ":" : "") + (m > 0 ? (m < 10 ? "0" : "") + m + ":" : "00:") + (s < 10 ? "0" : "") + s);
}


/**
 * keepInBound
 * @param {number} value.
 * @param {number=} max (optional).
 * @param {number=} min (optional).
 * @return {number}
 */
function keepInBound(value, max, min)
{
	var number = Number(value);
	
	max = Number(max) || 1;
	min = Number(min) || 0;
	
	return number >= max ? max : (number <= min ? min : number);
}

/**
 * pauseAllAudioExcept
 * @param {AudioPlayer} element.
 */
function pauseAllAudioExcept(element)
{
	each(collection, function()
	{
		if(element != this && !this.paused())
		{
			this.pause();
		}
	});
}


function getOffsetLeft(object)
{
	var x = 0;
	var element = object['get'](0);
	
	while(element && !isNaN(element.offsetLeft))
	{
		x += element.offsetLeft;
		element = element.offsetParent;
	}
	
	return x;
}

function roundNumber(value)
{
	return Math.round(Number(value)*10)/10;
}



function createCookie(name,value,days)
{
	if(days)
	{
		var date = new Date();
			date.setTime( date.getTime() + (days*86400000) );
			
		var expires = '; expires=' + date.toGMTString();
	}
	else var expires = '';
	
	doc.cookie = name + "=" + value+expires + "; path=/";
}

function readCookie(name)
{
	var nameEQ = name + "=";
	var ca = doc.cookie.split(';');
	
	for(var i=0;i < ca.length;i++)
	{
		var c = ca[i];
		
		while (c.charAt(0)==' ')
			c = c.substring(1,c.length);
		
		if (c.indexOf(nameEQ) == 0)
			return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function setVolumeState(volume)
{		
	if(isDefined(win.localStorage))
	{
		try { localStorage.setItem(AUDIO_PLAYER_ID, volume); }
		catch(e){ createCookie(AUDIO_PLAYER_ID, volume, 30); }
	}
	else
		createCookie(AUDIO_PLAYER_ID, volume, 30);
}

function getVolumeState()
{
	var volume;
	if(isDefined(win.localStorage))
	{
		try { volume = localStorage.getItem(AUDIO_PLAYER_ID); }
		catch(e){}
	}
	
	if(!isDefined(volume) || isNull(volume) || isNaN(volume)) volume = readCookie(AUDIO_PLAYER_ID);
			
	return isDefined(volume) && !isNull(volume) && !isNaN(volume) ? volume : null;
}



function html(element, html)
{
	element['html'](html);
}

function append(element, html)
{
	element['append'](html);
}

function after(element, html)
{
	element['after'](html);
}

function remove(element)
{
	return $(element)['remove']();
}

/**
 * Get or set a attribute.
 * @param {object} element.
 * @param {string} style.
 * @param {string=} opt_value (optional).
 * @return {string}
 */
function css(element, style, opt_value)
{
	if(opt_value)
		return element['css'](style, opt_value);
	else
		return element['css'](style);
}

/**
 * Get or set an attribute.
 * @param {object} element.
 * @param {string} attribute.
 * @param {string=} opt_value (optional).
 * @return {string}
 */
function attr(element, attribute, opt_value)
{
	return element['attr'](attribute, opt_value);
}

function removeAttr(element, attribute)
{
	return element['removeAttr'](attribute);
}

function text(element, value)
{
	return element['text'](value);
}

function addClass(element, className)
{
	element['addClass'](className);
}

function removeClass(element, className)
{
	element['removeClass'](className);
}

/**
 * Bind listeners to an element.
 * @param {Object} element.
 * @param {string} eventName.
 * @param {Function|Object} fn.
 */
function bind(element, eventName, fn)
{
	element['bind'](eventName, fn);
}

/**
 * Unbind listeners to an element.
 * @param {Object} element.
 * @param {string=} opt_eventName (optional).
 * @param {Function|Object=} opt_fn (optional).
 */
function unbind(element, opt_eventName, opt_fn)
{
	element['unbind'](opt_eventName, opt_fn);
}

function find(element, selector)
{
	return element['find'](selector);
}

function each(object, callback)
{
	return $(object)['each'](callback);
}

function is(element, selector)
{
	return element['is'](selector);
}

function proxy(fn, object)
{
	return $['proxy'](fn, object);
}

/**
 * Get or set the width of an element.
 * @param {object} element.
 * @param {number|string=} opt_value (optional).
 * @return {number|string}
 */
function width(element, opt_value)
{
	return element['width'](opt_value);
}

/**
 * Get or set the height of an element.
 * @param {object} element.
 * @param {number|string=} opt_value (optional).
 * @return {number|string}
 */
function height(element, opt_value)
{
	return element['height'](opt_value);
}




function isFunction(val)
{
	return typeof val === 'function';
}

function isObject(val)
{
	return typeof val === 'object';
}

function isDefined(val)
{
	return typeof(val) !== 'undefined';
}

function isNull(val)
{
	return val == null;
}

function isNaN(val)
{
	return !(val >= 0 || val < 0);
}

function inherits(childCtor, parentCtor)
{
	/** @constructor */
	function tempCtor() {};
	tempCtor.prototype = parentCtor.prototype;
	childCtor.superClass_ = parentCtor.prototype;
	childCtor.prototype = new tempCtor();
	childCtor.prototype.constructor = childCtor;
}











/**
 * Event target object
 * @constructor
 */
function EventTargetController()
{
	/** @private */
	this.events_ = [];
}

EventTargetController.prototype.addEventListener = function(type, callback)
{
	this.events_[type] = this.events_[type] || [];
	this.events_[type].push(callback);
};

EventTargetController.prototype.removeEventListener = function(type, callback)
{
	var listeners = this.events_[type];
	
	if(listeners)
	{
		each(listeners, function(i)
		{
			if(this === callback)
			{
				listeners.splice(i,1);
			}
		});
	}
};

EventTargetController.prototype.hasEventListener = function(type)
{
	return Boolean(this.events_[type] && this.events_[type].length > 0);
};

/**
 * dispatchEvent
 * @param {string} type.
 */
EventTargetController.prototype.dispatchEvent = function(type)
{
	var listeners = this.events_[type];

	if(listeners)
	{
		var self = this;
		each(listeners, function()
		{
			this.call(self, type);
		});		
	}
};

EventTargetController.prototype.destroy = function()
{
	delete this.events_;
};






/**
 * The media controller class.
 * @param {Object} object
 * @param {Object} element
 * @extends EventTargetController
 * @constructor
 */
function MediaController(object, element)
{
	EventTargetController.call(this);
	
	this.element_	= element;
	this.object_	= object;
	
	this.available 	= this.hasProperty('canPlayType') && this.hasPlayableSource_();
	//this.available 	= this.hasProperty('canPlayType');
	//this.available		= false;
		
	this.hackTimerInterval_		= 1000/10;
	this.hackTimerId_			= null;
	
	this.isBindEvents_		= false;
	this.isUnloading_		= false;
	
	this.ready			= false;
	this.started		= false;
	this.canplay		= false;
	
	this.currentTime_	= 0;
	this.progress_		= 0;
	this.duration_		= 0;
	
	if(!this.available)return;
	
	this.bindEvents_();
	
	if(element['playing'])this.playingHandler__();
	
	this.readyHandler__();
}

inherits(MediaController, EventTargetController);

MediaController.prototype.bindEvents_ = function()
{
	if(this.isBindEvents_)return;
	
	this.isBindEvents_ = true;
	
	bind(this.object_, MediaEvent.CAN_PLAY,			proxy(this.canplayHandler__,		this));
	
	bind(this.object_, MediaEvent.PLAYING,			proxy(this.playingHandler__,		this));
	bind(this.object_, MediaEvent.PLAY,				proxy(this.playingHandler__,		this));
	
	bind(this.object_, MediaEvent.PAUSE,			proxy(this.pauseHandler__,			this));
	bind(this.object_, MediaEvent.ENDED,			proxy(this.endedHandler__,			this));
	//bind(this.object_, MediaEvent.WAITING,			proxy(this.waitingHandler__,		this));

	bind(this.object_, MediaEvent.TIME_UPDATE,		proxy(this.timeupdateHandler__,		this));
	bind(this.object_, MediaEvent.PROGRESS,			proxy(this.progressHandler__,		this));

	bind(this.object_, MediaEvent.DURATION_CHANGE,	proxy(this.durationchangeHandler__, this));
	bind(this.object_, MediaEvent.VOLUME_CHANGE,	proxy(this.volumechangeHandler__,	this));
	//bind(this.object_, MediaEvent.RATE_CHANGE,		proxy(this.ratechangeHandler__,		this));
	
	bind(this.object_, MediaEvent.ERROR,			proxy(this.errorHandler__,			this));
};

MediaController.prototype.unbindEvents_ = function()
{
	if(!this.isBindEvents_)return;
	
	this.isBindEvents_ = false;
	
	unbind(this.object_, MediaEvent.CAN_PLAY,			this.canplayHandler__);
	
	unbind(this.object_, MediaEvent.PLAYING,			this.playingHandler__);
	unbind(this.object_, MediaEvent.PLAY,				this.playingHandler__);
	
	unbind(this.object_, MediaEvent.PAUSE,				this.pauseHandler__);
	unbind(this.object_, MediaEvent.ENDED,				this.endedHandler__);
	//unbind(this.object_, MediaEvent.WAITING,			this.waitingHandler__);

	unbind(this.object_, MediaEvent.TIME_UPDATE,		this.timeupdateHandler__);
	unbind(this.object_, MediaEvent.PROGRESS,			this.progressHandler__);

	unbind(this.object_, MediaEvent.DURATION_CHANGE,	this.durationchangeHandler__);
	unbind(this.object_, MediaEvent.VOLUME_CHANGE,		this.volumechangeHandler__);
	//unbind(this.object_, MediaEvent.RATE_CHANGE,		this.ratechangeHandler__);

	unbind(this.object_, MediaEvent.ERROR,				this.errorHandler__);
};

MediaController.prototype.destroy = function()
{
	this.unbindEvents_();
	MediaController.superClass_.destroy.call(this);
};

MediaController.prototype.reset_ = function()
{
	this.canplay		= false;
	this.started		= false;
	
	this.currentTime_	= 0;
	this.progress_		= 0;
	this.duration_		= 0;
};

MediaController.prototype.hasPlayableSource_ = function()
{
	var sources 	= find(this.object_, 'source');
	var self 		= this;
	var newSource;

	each(sources, function(i)
	{
		var src		= attr($(this), 'src');
		var type	= getAudioTypeBySource(src);
		var canplay	= self.canPlayType(type);
							
		if(canplay == 'maybe' || canplay == 'probably')
		{
			newSource = src;
			return false;
		}
	});
	
	return newSource || false;
};

MediaController.prototype.hasProperty = function(property)
{
	return isDefined(this.element_[property]);
};

MediaController.prototype.canPlayType = function(type)
{
	return this.element_['canPlayType'](type);
};

MediaController.prototype.autoplay = function()
{
	return this.element_['autoplay'];
};

MediaController.prototype.setAutoplay = function(value)
{
	this.element_['autoplay'] = value;
};

MediaController.prototype.loop = function()
{
	return this.element_['loop'] || is(this.object_, '[loop]');
};

MediaController.prototype.setLoop = function(value)
{
	this.element_['loop'] = value;
};

MediaController.prototype.preload = function()
{
	return this.element_['preload'];
};

MediaController.prototype.setPreload = function(value)
{
	this.element_['preload'] = value;
};

MediaController.prototype.duration = function()
{
	return this.duration_ || this.element_['duration'];
}

MediaController.prototype.ended = function()
{
	return this.element_['ended'];
}

MediaController.prototype.paused = function()
{
	return this.element_['paused'];
}

MediaController.prototype.currentSrc = function()
{
	return this.currentSource_ || this.element_['currentSrc'];
};

MediaController.prototype.src = function()
{
	return this.element_['src'];
};

MediaController.prototype.setSrc = function(source)
{
	this.element_['src'] = source;
	this.currentSource_ = source;
};

MediaController.prototype.volume = function()
{
	return this.element_['volume'];
};

MediaController.prototype.setVolume = function(value)
{
	this.element_['volume'] = keepInBound(value);
};

MediaController.prototype.progress = function()
{
	return this.progress_;
};

MediaController.prototype.currentTime = function()
{
	return this.currentTime_ || this.element_['currentTime'];
};

MediaController.prototype.setCurrentTime = function(value)
{
	if(this.element_['currentTime'] != value)
	{
		this.element_['currentTime'] = keepInBound(value, this.duration());
	}
};

/**
 * start playing the media.
 * @param {Object=} opt_element (optional).
 */
MediaController.prototype.play = function(opt_element)
{
	if(isDefined(opt_element))
	{
		var element;
		if(typeof opt_element === 'object')
			element = opt_element;
		else if(typeof opt_element === 'string')
			element = win['getElementById'](opt_element);
		
		if(element && element.tagName.toLowerCase() == 'audio')
			this.load(element['currentSrc'] || element['src']);
	}
	
	this.element_['play']();
};

MediaController.prototype.pause = function()
{
	this.element_['pause']();
};

MediaController.prototype.load = function(opt_source)
{
	var src = opt_source || this.currentSource_;
	
	if(src)
	{
		this.setSrc(src);
	}
	
	this.reset_();
	this.bindEvents_();
	
	this.element_['load']();
};

MediaController.prototype.unload = function()
{	
	this.isUnloading_ = true;
	
	this.pause();
	this.setCurrentTime(0);
	
	this.unbindEvents_();
	this.reset_();
	
	this.element_['src'] = '';
	this.element_['load']();
};





MediaController.prototype.startTimer_ = function()
{
	if(!this.hackTimerId_)
	{
		//this.hackTimerId_ = requestInterval(proxy(this.timerHandler_, this), this.hackTimerInterval_);
		this.hackTimerId_ = setInterval(proxy(this.timerHandler_, this), this.hackTimerInterval_);
		
		this.timerHandler_();
	}
};

MediaController.prototype.stopTimer_ = function()
{
	if(this.hackTimerId_)
	{
		//clearRequestInterval(this.hackTimerId_);
		clearInterval(this.hackTimerId_);
		this.hackTimerId_ = null;
	}	
};

MediaController.prototype.timerHandler_ = function()
{
	this.timeupdateHandler__();
	this.progressHandler__();
	this.canplayHandler__();
	this.startedHandler__();
};






MediaController.prototype.readyHandler__ = function()
{
	this.ready = true;
	this.dispatchEvent(MediaEvent.READY);
};

/**
 * progress handler
 * @param {Object=} e (optional).
 */
MediaController.prototype.progressHandler__ = function(e)
{	
	if(this.hasEventListener(MediaEvent.PROGRESS))
	{
		var buffered = this.element_['buffered'];
		var duration = this.element_['duration'];

		if(buffered && duration)
		{
			var length = buffered.length;
			if(length)
			{
				var diff = duration;
				var index = length - 1;
				var number = this.element_['currentTime'];

				for(var i=0; i<length; i++)
				{
					var buffer = buffered['end'](i);
					if(buffer >= number && buffer < diff)
					{
						diff = buffer;
						index = i;
					}
				}
				
				var progress = parseInt(buffered['end'](index) / duration * 100, 10);
				
				if(this.progress_ != progress)
				{
					this.progress_ = progress;
					this.dispatchEvent(MediaEvent.PROGRESS);
				}
			}
		}
		else if(e)
		{
			var originalEvent	= e['originalEvent'];
			var bytesLoaded		= originalEvent['loaded'];
			var bytesTotal		= originalEvent['total'];

			if(bytesLoaded && bytesTotal)
			{
				var progress = parseInt(bytesLoaded / bytesTotal * 100, 10);
				
				if(this.progress_ != progress)
				{
					this.progress_ = progress;
					this.dispatchEvent(MediaEvent.PROGRESS);
				}	
			}
		}
	}
};


MediaController.prototype.timeupdateHandler__ = function()
{
	var time = this.element_['currentTime'];
	if(this.currentTime_ != time)
	{
		this.currentTime_ = time;
		this.dispatchEvent(MediaEvent.TIME_UPDATE);
	}
};

MediaController.prototype.durationchangeHandler__ = function()
{
	var duration = this.element_['duration'];
	if(this.duration_ != duration)
	{
		this.duration_ = duration;
		this.dispatchEvent(MediaEvent.DURATION_CHANGE);
	}
};

/*
MediaController.prototype.ratechangeHandler__ = function()
{
	this.dispatchEvent(MediaEvent.RATE_CHANGE);
};
*/

MediaController.prototype.volumechangeHandler__ = function()
{
	this.dispatchEvent(MediaEvent.VOLUME_CHANGE);
};

/*
MediaController.prototype.waitingHandler__ = function()
{
	this.dispatchEvent(MediaEvent.WAITING);
};
*/

/**
 * canplay handler
 * @param {Object=} e (optional).
 */
MediaController.prototype.canplayHandler__ = function(e)
{
	if(this.hasEventListener(MediaEvent.CAN_PLAY))
	{
		if(!this.canplay)
		{			
			if(isDefined(e) || !isNaN(this.element_['duration']))
			{
				this.canplay = true;
				this.dispatchEvent(MediaEvent.CAN_PLAY);
			}
		}
	}
};

/**
 * started handler
 * @param {Object=} e (optional).
 */
MediaController.prototype.startedHandler__ = function(e)
{
	if(!this.started)
	{	
		if(isDefined(e) || this.currentTime()>0)
		{
			this.started = true;
			this.dispatchEvent(MediaEvent.STARTED);
		}
	}
};

MediaController.prototype.playingHandler__ = function()
{
	this.startTimer_();
	this.canplayHandler__();
	this.startedHandler__();
	this.dispatchEvent(MediaEvent.PLAYING);
};

MediaController.prototype.pauseHandler__ = function()
{
	this.stopTimer_();
	this.dispatchEvent(MediaEvent.PAUSE);
};

MediaController.prototype.endedHandler__ = function()
{
	this.stopTimer_();
	this.started = false;
	this.dispatchEvent(MediaEvent.ENDED);
};

MediaController.prototype.errorHandler__ = function()
{
	this.stopTimer_();
	
	if(this.isUnloading_)
	{
		this.isUnloading_ = false;
	}
	else
	{
		this.dispatchEvent(MediaEvent.ERROR);
	}
};









/**
 * The Flash audio controller class.
 * @param {Object} object
 * @param {Object} element
 * @extends MediaController
 * @constructor
 */
function FlashFallbackController(object, element)
{
	MediaController.call(this, object, element);
	
	if(this.available)return;
	
	this.flashMode_	= true;
	this.flashId_	= 'APV1ID_' + initCount;
	
	var player		= (
						attr(object, Attributes.DATA_FALLBACK) ||
						$[FN][AUDIO_PLAYER_ID]['defaultOptions'][Attributes.DATA_FALLBACK]
					);
	
	var audio		= this.getPlayableFlashSource_();
	var volume		= 1;
	var loop		= attr(object, 'loop')		? true : false;
	var autoplay	= attr(object, 'autoplay')	? true : false;
	var preload		= attr(object, 'preload') == 'auto';
	
	if(DEBUG)
	{
		console.log('loop: ',		loop);
		console.log('autoplay: ',	autoplay);
		console.log('preload: ',	preload);
		console.log('audio: ',		audio);
	}
	
	this.swf_		= null;
	
	flashCollection[this.flashId_] = this;
		
	if(flashAvailable() && audio)
	{
		this.available = true;		
		
		createSWF(this.flashId_, object, player, audio, volume, loop, autoplay, preload)
		
		//html(object, createSWF(this.flashId_, player, audio, volume, loop, autoplay, preload));
		/*
		//setTimeout(function(){
			after(
				object,
				createSWF(this.flashId_, player, audio, volume, loop, autoplay, preload)
			);
		//},10);
		//*/
	}
}

inherits(FlashFallbackController, MediaController);

FlashFallbackController.prototype.destroy = function()
{
	FlashFallbackController.superClass_.destroy.call(this);
	
	if(this.swf_) remove(this.swf_);
	flashCollection.splice(this.flashId_, 1);
};

FlashFallbackController.prototype.flashCall_ = function(functionName)
{
	if(DEBUG)console.log(functionName);
	
	if(this.available && this.swf_ && isDefined(this.swf_[PREFIX_CALLBACK+functionName]))
	{
		return this.swf_[PREFIX_CALLBACK+functionName]();
	}
};

FlashFallbackController.prototype.flashCallWidth_ = function(functionName, opt_parameter)
{
	if(DEBUG)console.log(functionName);	
	
	if(this.available && this.swf_ && isDefined(this.swf_[PREFIX_CALLBACK+functionName]))
	{
		return this.swf_[PREFIX_CALLBACK+functionName](opt_parameter);
	}
};

/**
 * start playing the media.
 * @param {Object=} opt_element (optional).
 */
FlashFallbackController.prototype.play = function(opt_element)
{
	if(this.flashMode_)
	{
		if(isDefined(opt_element))
		{
			//this.flashCallWidth_('load', opt_element);
			//this.flashCall_('play');
		}
		else
		{
			this.flashCall_('play');
		}
	}
	else
		FlashFallbackController.superClass_.play.call(this, opt_element);
};

FlashFallbackController.prototype.pause = function()
{
	if(this.flashMode_)
		this.flashCall_('pause');
	else
		FlashFallbackController.superClass_.pause.call(this);
};

FlashFallbackController.prototype.getPlayableFlashSource_ = function()
{
	if(this.flashSource_)
		return this.flashSource_;
	else
	{
		var sources 	= find(this.object_, 'source');
		var self 		= this;
		var newSource;

		each(sources, function(i)
		{
			var src		= attr($(this), 'src');
			var type	= getAudioTypeBySource(src);
						
			if(type == 'audio/mpeg' || type == 'audio/mp4' || type == 'audio/wav')
			{
				newSource = src;
				return false;
			}
		});
	
		this.flashSource_ = newSource || false;
		return this.flashSource_;
	}
};

FlashFallbackController.prototype.hasPlayableSource_ = function()
{
	if(this.flashMode_)
		return this.getPlayableFlashSource_() ? true : false;
	else
		return FlashFallbackController.superClass_.hasPlayableSource_.call(this); 
};

FlashFallbackController.prototype.autoplay = function()
{
	if(this.flashMode_)
		return this.flashCall_('autoplay');
	else
		return FlashFallbackController.superClass_.autoplay.call(this);
};

FlashFallbackController.prototype.setAutoplay = function(value)
{
	if(this.flashMode_)
		this.flashCallWidth_('setAutoplay', value);
	else
		FlashFallbackController.superClass_.setAutoplay.call(this, value);
};

FlashFallbackController.prototype.loop = function()
{
	if(this.flashMode_)
		return this.flashCall_('loop');
	else
		return FlashFallbackController.superClass_.loop.call(this);
};

FlashFallbackController.prototype.setLoop = function(value)
{
	if(this.flashMode_)
		this.flashCallWidth_('setLoop', value);
	else
		FlashFallbackController.superClass_.setLoop.call(this, value);
};

FlashFallbackController.prototype.preload = function()
{
	if(this.flashMode_)
		return this.flashCall_('preload');
	else
		return FlashFallbackController.superClass_.preload.call(this);
};

FlashFallbackController.prototype.setPreload = function(value)
{
	if(this.flashMode_)
	{
		value = value == false || value == 'false' || value == 'none' ? false : true;
		this.flashCallWidth_('setPreload', value);
	}
	else
		FlashFallbackController.superClass_.setPreload.call(this, value);
};

FlashFallbackController.prototype.duration = function()
{
	if(this.flashMode_)
		return this.duration_ || this.flashCall_('duration');
	else
		return FlashFallbackController.superClass_.duration.call(this);
};

FlashFallbackController.prototype.ended = function()
{
	if(this.flashMode_)
		return this.flashCall_('ended');
	else
		return FlashFallbackController.superClass_.ended.call(this);
};

FlashFallbackController.prototype.paused = function()
{
	if(this.flashMode_)
		return this.flashCall_('paused');
	else
		return FlashFallbackController.superClass_.paused.call(this);
};

FlashFallbackController.prototype.currentSrc = function()
{
	if(this.flashMode_)
		return this.flashCall_('currentSrc');
	else
		return FlashFallbackController.superClass_.currentSrc.call(this);
};

FlashFallbackController.prototype.src = function()
{
	if(this.flashMode_)
		return this.flashCall_('src');
	else
		return FlashFallbackController.superClass_.src.call(this);
};

FlashFallbackController.prototype.setSrc = function(value)
{
	if(this.flashMode_)
		this.flashCallWidth_('setSrc', value);
	else
		FlashFallbackController.superClass_.setSrc.call(this, value);
};

FlashFallbackController.prototype.volume = function()
{
	if(this.flashMode_)
		return this.flashCall_('volume');
	else
		return FlashFallbackController.superClass_.volume.call(this);
};

FlashFallbackController.prototype.setVolume = function(value)
{
	//console.log(value);
	
	if(this.flashMode_)
		this.flashCallWidth_('setVolume', value);
	else
		FlashFallbackController.superClass_.setVolume.call(this, value);
};

FlashFallbackController.prototype.progress = function()
{
	if(this.flashMode_)
		return this.progress_ || this.flashCall_('progress');
	else
		return FlashFallbackController.superClass_.progress.call(this);
};

FlashFallbackController.prototype.currentTime = function()
{
	if(this.flashMode_)
		return this.currentTime_ || this.flashCall_('currentTime');
	else
		return FlashFallbackController.superClass_.currentTime.call(this);
};

FlashFallbackController.prototype.setCurrentTime = function(value)
{
	if(this.flashMode_)
		this.flashCallWidth_('setCurrentTime', value);
	else
		FlashFallbackController.superClass_.setCurrentTime.call(this, value);
};

FlashFallbackController.prototype.load = function(opt_source)
{
	//console.log('load');
	
	if(this.flashMode_)
		this.flashCallWidth_('load', opt_source);
	else
		FlashFallbackController.superClass_.load.call(this, opt_source);
};

FlashFallbackController.prototype.unload = function()
{
	if(this.flashMode_)
		this.flashCall_('unload');
	else
		FlashFallbackController.superClass_.unload.call(this);
};



FlashFallbackController.prototype.readyHandler__ = function()
{	
	if(this.flashMode_)
	{
		this.ready = true;
		this.dispatchEvent(MediaEvent.READY);
	}
	else
		FlashFallbackController.superClass_.readyHandler__.call(this);
};

FlashFallbackController.prototype.timeupdateHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.TIME_UPDATE);
	else
		FlashFallbackController.superClass_.timeupdateHandler__.call(this);
};

FlashFallbackController.prototype.progressHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.PROGRESS);
	else
		FlashFallbackController.superClass_.progressHandler__.call(this);
};

FlashFallbackController.prototype.canplayHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.CAN_PLAY);
	else
		FlashFallbackController.superClass_.canplayHandler__.call(this);
};

FlashFallbackController.prototype.playingHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.PLAYING);
	else
		FlashFallbackController.superClass_.playingHandler__.call(this);
};

FlashFallbackController.prototype.startingHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.STARTED);
	else
		FlashFallbackController.superClass_.startingHandler__.call(this);
};

FlashFallbackController.prototype.playHandler__ = function()
{
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.PLAY);
	else
		FlashFallbackController.superClass_.playHandler__.call(this);
};

FlashFallbackController.prototype.pauseHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.PAUSE);
	else
		FlashFallbackController.superClass_.pauseHandler__.call(this);
};

FlashFallbackController.prototype.endedHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.ENDED);
	else
		FlashFallbackController.superClass_.endedHandler__.call(this);
};

FlashFallbackController.prototype.volumechangeHandler__ = function()
{	
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.VOLUME_CHANGE);
	else
		FlashFallbackController.superClass_.volumechangeHandler__.call(this);
};

FlashFallbackController.prototype.durationchangeHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.DURATION_CHANGE);
	else
		FlashFallbackController.superClass_.durationchangeHandler__.call(this);
};

FlashFallbackController.prototype.errorHandler__ = function()
{		
	if(this.flashMode_)
		this.dispatchEvent(MediaEvent.ERROR);
	else
		FlashFallbackController.superClass_.errorHandler__.call(this);
};













/**
 * The audio controller class.
 * @param {Object} object
 * @param {Object} element
 * @extends FlashFallbackController
 * @constructor
 */
function AudioPlayer(object, element)
{
	FlashFallbackController.call(this, object, element);
	
	//if(!is(object, 'audio'))return;
			
	this.identifier_		= initCount++;
	this.offset_			= 0;
	this.time_				= 0;
	this.isSeekingTimeline_	= false;
	this.isSeekingVolume_	= false;
	this.isMuted_			= false;
	
	var attrWidth = attr(object, Attributes.WIDTH);
	var attrHeight = attr(object, Attributes.HEIGHT);
	
	this.playerWidth_		= attrWidth || $['fn'][AUDIO_PLAYER_ID]['defaultOptions'][Attributes.WIDTH];
	this.playerHeight_		= attrHeight || $['fn'][AUDIO_PLAYER_ID]['defaultOptions'][Attributes.HEIGHT];
	
	var controlsDisplay = this.controlsDisplay_ = $(TEMPLATE);
						
	this.playButton_				= find(controlsDisplay, '.APV1_play_button');
	this.timeTextDisplay_			= find(controlsDisplay, '.APV1_time_text');
	this.containerDisplay_			= find(controlsDisplay, '.APV1_container');
	this.progressContainerDisplay_	= find(controlsDisplay, '.APV1_progress_bar_container');
	this.progressWrapperDisplay_	= find(controlsDisplay, '.APV1_progress_bar_wrapper');
	this.seekBarDisplay_			= find(controlsDisplay, '.APV1_seek_bar');
	this.playBarDisplay_			= find(controlsDisplay, '.APV1_play_bar');
	this.durationTextDisplay_		= find(controlsDisplay, '.APV1_duration_text');
	this.volumeButton_				= find(controlsDisplay, '.APV1_volume_button');
	this.volumeContainerDisplay_	= find(controlsDisplay, '.APV1_volume_bar_container');
	this.volumeBarDisplay_			= find(controlsDisplay, '.APV1_volume_bar');
	
	width(controlsDisplay, this.playerWidth_);
	height(controlsDisplay, this.playerHeight_);
	
	this.bindControllerEvents_();
	
	
	this.checkAttributes_();
	
	
	after(object, 		controlsDisplay);
	
	var cssObject					= {};
	cssObject[Attributes.HEIGHT]	= Values.ZERO;
	cssObject[Attributes.WIDTH]		= Values.ZERO;	
	
	css(object, 		cssObject);
	removeAttr(object,	Attributes.CONTROLS);

	if(!this.checkForAvailability_())return;

	this.setContainerWidth_();	
	
	this.bindAudioEvents_();
	
	if(this.ready)this.readyHandler_();
		
	collection[this.identifier_] = this;
}

inherits(AudioPlayer, FlashFallbackController);


AudioPlayer.prototype.destroy = function()
{
	this.unbindAudioEvents_();
	this.unbindControllerEvents_();
	this.unbindVolumeEvents_();
	this.unbindStartingEvents_();
	this.unbindPlayEvents_();
	
	remove(this.controlsDisplay_);
	
	collection.splice(this.identifier_, 1);
	
	AudioPlayer.superClass_.destroy.call(this);
};

AudioPlayer.prototype.bindControllerEvents_ = function()
{
	bind(this.controlsDisplay_, MouseEvent.MOUSE_DOWN,		false);
	bind(this.controlsDisplay_, MouseEvent.CONTEXT_MENU,	false);
};

AudioPlayer.prototype.unbindControllerEvents_ = function()
{
	unbind(this.controlsDisplay_, MouseEvent.MOUSE_DOWN);
	unbind(this.controlsDisplay_, MouseEvent.CONTEXT_MENU);
};

AudioPlayer.prototype.bindPlayEvents_ = function()
{
	bind(this.progressWrapperDisplay_,	MouseEvent.MOUSE_DOWN,	proxy(this.onSeekDownHandler_, this));	
	bind(this.playButton_,				MouseEvent.CLICK,		proxy(this.toggleAudio_, this));
};

AudioPlayer.prototype.unbindPlayEvents_ = function()
{
	unbind(this.progressWrapperDisplay_,	MouseEvent.MOUSE_DOWN,	this.onSeekDownHandler_);	
	unbind(this.playButton_,				MouseEvent.CLICK,		this.toggleAudio_);
};

AudioPlayer.prototype.bindStartingEvents_ = function()
{
	if(DEBUG)console.log('bindStartingEvents_');
	bind(this.playButton_, MouseEvent.CLICK, proxy(this.startAudio_, this));
};

AudioPlayer.prototype.unbindStartingEvents_ = function()
{
	if(DEBUG)console.log('unbindStartingEvents_');
	unbind(this.playButton_, MouseEvent.CLICK, this.startAudio_);
};

AudioPlayer.prototype.bindVolumeEvents_ = function()
{
	bind(this.volumeContainerDisplay_,	MouseEvent.MOUSE_DOWN,	proxy(this.onVolumeDownHandler_,this));
	bind(this.volumeButton_,			MouseEvent.CLICK,		proxy(this.toggleVolume_,this));
};

AudioPlayer.prototype.unbindVolumeEvents_ = function()
{
	unbind(this.volumeContainerDisplay_,	MouseEvent.MOUSE_DOWN,	this.onVolumeDownHandler_);
	unbind(this.volumeButton_,				MouseEvent.CLICK,		this.toggleVolume_);
};

AudioPlayer.prototype.bindAudioEvents_ = function()
{	
	this.addEventListener(MediaEvent.READY,				this.readyHandler_);
	this.addEventListener(MediaEvent.PROGRESS,			this.progressHandler_);
	this.addEventListener(MediaEvent.TIME_UPDATE,		this.timeupdateHandler_);
	this.addEventListener(MediaEvent.CAN_PLAY,			this.canplayHandler_);
	this.addEventListener(MediaEvent.DURATION_CHANGE,	this.durationchangeHandler_);
	this.addEventListener(MediaEvent.PLAYING,			this.playHandler_);
	this.addEventListener(MediaEvent.PLAY,				this.playHandler_);
	this.addEventListener(MediaEvent.PAUSE,				this.pauseHandler_);
	this.addEventListener(MediaEvent.ENDED,				this.endedHandler_);
	this.addEventListener(MediaEvent.ERROR,				this.errorHandler_);
	this.addEventListener(MediaEvent.VOLUME_CHANGE,		this.volumechangeHandler_);
};

AudioPlayer.prototype.unbindAudioEvents_ = function()
{
	this.removeEventListener(MediaEvent.READY,				this.readyHandler_);
	this.removeEventListener(MediaEvent.TIME_UPDATE,		this.timeupdateHandler_);
	this.removeEventListener(MediaEvent.CAN_PLAY,			this.canplayHandler_);
	this.removeEventListener(MediaEvent.DURATION_CHANGE,	this.durationchangeHandler_);
	this.removeEventListener(MediaEvent.PLAYING,			this.playHandler_);
	this.removeEventListener(MediaEvent.PLAY,				this.playHandler_);
	this.removeEventListener(MediaEvent.PAUSE,				this.pauseHandler_);
	this.removeEventListener(MediaEvent.ENDED,				this.endedHandler_);
	this.removeEventListener(MediaEvent.ERROR,				this.errorHandler_);
	this.removeEventListener(MediaEvent.VOLUME_CHANGE,		this.volumechangeHandler_);
};

AudioPlayer.prototype.readyHandler_ = function()
{
	//console.log('ready');
	
	var attrVol = attr(this.object_, Attributes.DATA_VOLUME);
	var vol = (
		(attrVol ? (keepInBound(attrVol, 100) / 100) : null) ||
		getVolumeState() ||
		($['fn'][AUDIO_PLAYER_ID]['defaultOptions'][Attributes.DATA_VOLUME] / 100)
	);
		
	if(isDefined(vol)) this.setVolume(vol);
	else vol = this.volume();
	
		
	this.setVolumeView_(vol);
	

	this.bindStartingEvents_();
	this.bindVolumeEvents_();
};

AudioPlayer.prototype.checkAttributes_ = function()
{				
	if(!this.hasBooleanAttribute_(Attributes.DATA_CONTROLS_TIME))
	{					
		attr(this.timeTextDisplay_, Values.STYLE, Values.DISPLAY_NONE);
		
		var obj = find(this.controlsDisplay_, '.APV1_for_time');
		attr(obj, Values.STYLE, Values.DISPLAY_NONE);
	}

	if(!this.hasBooleanAttribute_(Attributes.DATA_CONTROLS_DURATION))
	{
		attr(this.durationTextDisplay_, Values.STYLE, Values.DISPLAY_NONE);
		
		var obj = find(this.controlsDisplay_, '.APV1_for_duration');
		attr(obj, Values.STYLE, Values.DISPLAY_NONE);
	}

	if(!this.hasBooleanAttribute_(Attributes.DATA_CONTROLS_VOLUME))
	{
		attr(this.volumeButton_,			Values.STYLE, Values.DISPLAY_NONE);
		attr(this.volumeContainerDisplay_,	Values.STYLE, Values.DISPLAY_NONE);
		
		var obj = find(this.controlsDisplay_, '.APV1_for_volume');
		attr(obj, Values.STYLE, Values.DISPLAY_NONE);
	}
};

AudioPlayer.prototype.hasBooleanAttribute_ = function(attributeName)
{
	var val = attr(this.object_, attributeName);
	
	if(val)
	{
		if(val == 'false' || val == 'off' || val == 'no')
			return false;
			
		else if(val == 'true' || val == 'on' || val == 'yes')
			return true;
	}
	
	return $[FN][AUDIO_PLAYER_ID]['defaultOptions'][attributeName];
};

AudioPlayer.prototype.setContainerWidth_ = function()
{	
	var widthMin = 0;
	var obj = find(this.controlsDisplay_, 'li:not(.APV1_container)');
	
	each(obj, function()
	{
		widthMin += width($(this));
	});
					
	if(widthMin > this.playerWidth_)
	{
		$win.load(proxy(this.setContainerWidth_, this));
		return;
	}
	
	width(this.containerDisplay_, this.playerWidth_ - widthMin);
}; 

AudioPlayer.prototype.checkForAvailability_ = function()
{
	if(!this.available)
	{
		this.reportError_('Audio file not found.');
		return;
	}
	
	return true;
};

AudioPlayer.prototype.canplayHandler_ = function()
{	
	if(DEBUG)console.log('canplayHandler_');
	
	this.unbindStartingEvents_();
	this.bindPlayEvents_();
};

AudioPlayer.prototype.startAudio_ = function()
{
	if(DEBUG)console.log('startAudio_');
	
	if(!this.flashMode_)
		this.setPreload('auto');
	
	this.play();
	
	this.unbindStartingEvents_();
};

AudioPlayer.prototype.toggleAudio_ = function()
{	
	if(this.paused() || this.ended()) 
	{
		this.play();
		addClass(this.controlsDisplay_, Classes.PLAYING);
	}
	else 
	{
		this.pause();
		removeClass(this.controlsDisplay_, Classes.PLAYING);
	}
};

AudioPlayer.prototype.toggleVolume_ = function()
{
	//console.log(this.volume());
	
	if(this.volume()) this.setVolume(0);
	else this.setVolume(1);
};

AudioPlayer.prototype.onVolumeDownHandler_ = function(e)
{
	if(e.which != 1)return;
	
	e.preventDefault();
	e.stopPropagation();
	
	if(!isIE())
	this.isSeekingVolume_ = true;
	
	this.offset_ = getOffsetLeft(this.volumeContainerDisplay_);
	
	var pos = (e.pageX - this.offset_) / width(this.volumeContainerDisplay_);						
	this.setVolume(pos);
	this.setVolumeView_(pos);

	bind($win, MouseEvent.MOUSE_MOVE,				proxy(this.onVolumeMoveHandler_, this));
	bind($win, MouseEvent.MOUSE_UP,				proxy(this.onVolumeUpHandler_, this));
		
	return false;
}

AudioPlayer.prototype.onVolumeUpHandler_ = function()
{
	this.isSeekingVolume_ = false;

	setVolumeState(this.volume());
		
	unbind($win, MouseEvent.MOUSE_MOVE,			this.onVolumeMoveHandler_);
	unbind($win, MouseEvent.MOUSE_UP,				this.onVolumeUpHandler_);
	
};

AudioPlayer.prototype.onVolumeMoveHandler_ = function(e)
{
	var pos = keepInBound((e.pageX - this.offset_) / width(this.volumeContainerDisplay_));
						
	this.setVolume(pos);
	this.setVolumeView_(pos);
};

AudioPlayer.prototype.setVolumeView_ = function(volume)
{		
	width(this.volumeBarDisplay_, volume * 100 + '%');

	if(volume)
	{
		if(this.isMuted_)
		{
			this.isMuted_ = false;
			removeClass(this.controlsDisplay_, Classes.MUTE);
		}
	}
	else if(!this.isMuted_)
	{
		this.isMuted_ = true;
		addClass(this.controlsDisplay_, Classes.MUTE);
	}
};

AudioPlayer.prototype.onSeekDownHandler_ = function(e)
{
	if(e.which != 1)return;
		
	this.offset_ = getOffsetLeft(this.seekBarDisplay_);
		
	var pos = keepInBound((e.pageX - this.offset_) / width(this.progressContainerDisplay_));
	var duration = this.duration();
	var time = duration * pos;
	this.time_ = time;
		
	removeClass(this.playBarDisplay_, Classes.TRANSITION);
	width(this.playBarDisplay_, pos * 100 + '%');
	
	text(this.timeTextDisplay_, getCurrentTime(time, duration));
	
	bind($win, MouseEvent.MOUSE_MOVE,	proxy(this.onSeekMoveHandler_, this));
	bind($win, MouseEvent.MOUSE_UP,		proxy(this.onSeekUpHandler_, this));

	if(!isIE())
	{
		this.isSeekingTimeline_ = true;
		this.pause();	
	}
	else
	{
		this.setCurrentTime(time);
		this.play();
	}
	
	return false;
};

AudioPlayer.prototype.onSeekUpHandler_ = function()
{
	addClass(this.playBarDisplay_,	Classes.TRANSITION);
	
	unbind($win, MouseEvent.MOUSE_MOVE,	this.onSeekMoveHandler_);
	unbind($win, MouseEvent.MOUSE_UP,	this.onSeekUpHandler_);
	
	this.setCurrentTime(this.time_);	
	this.isSeekingTimeline_ = false;
	this.play();
};

AudioPlayer.prototype.onSeekMoveHandler_ = function(e)
{
	var pos = keepInBound((e.pageX - this.offset_) / width(this.progressContainerDisplay_));
	
	var duration = this.duration();
	var time = duration * pos;
	this.time_ = time;
	
	width(this.playBarDisplay_, pos * 100 + '%');
	text(this.timeTextDisplay_, getCurrentTime(time, duration));
};

AudioPlayer.prototype.timeupdateHandler_ = function()
{
	var self = this;
	
	if(self.isSeekingTimeline_)return;

	var duration	= self.duration();
	var time		= self.currentTime();
	var pos			= keepInBound(time / duration);
	
	callAnimationFrame(function()
	{
		width(self.playBarDisplay_, pos * 100 + '%');
		text(self.timeTextDisplay_,	getCurrentTime(time, duration));
	}, '1');
};

AudioPlayer.prototype.progressHandler_ = function()
{
	var self = this;
	callAnimationFrame(function()
	{
		width(self.seekBarDisplay_, self.progress() + '%');
	}, '2');
};

AudioPlayer.prototype.volumechangeHandler_ = function()
{
	if(!this.isSeekingVolume_)
	{
		var vol = roundNumber(this.volume());

		setVolumeState(vol);
		this.setVolumeView_(vol);
	}
};

AudioPlayer.prototype.durationchangeHandler_ = function()
{
	text(this.durationTextDisplay_,	getCurrentTime(this.duration()));
	
	if(this.duration() / 3600 >= 1)
	{
		text(this.timeTextDisplay_, getCurrentTime(this.currentTime(), this.duration()));
		this.setContainerWidth_();
	}
};

AudioPlayer.prototype.playHandler_ = function()
{
	if(!this.isSeekingTimeline_)
	{						
		pauseAllAudioExcept(this);
		addClass(this.controlsDisplay_, Classes.PLAYING);
	}
};

AudioPlayer.prototype.pauseHandler_ = function()
{
	if(!this.isSeekingTimeline_)
	{
		removeClass(this.controlsDisplay_, Classes.PLAYING);
	}
};

AudioPlayer.prototype.endedHandler_ = function()
{	
	if(!this.isSeekingTimeline_)
	{
		removeClass(this.controlsDisplay_, Classes.PLAYING);
		
		if(this.loop())
		{
			this.setCurrentTime(0);
			this.play();
		}
	}
};

AudioPlayer.prototype.errorHandler_ = function()
{
	this.reportError_('An error occurred.');
};

AudioPlayer.prototype.reportError_ = function(msg)
{
	if(DEBUG)console.log('error: '+msg);
	
	this.unbindAudioEvents_();
	this.unbindControllerEvents_();
	this.unbindVolumeEvents_();
	this.unbindStartingEvents_();
	this.unbindPlayEvents_();
	
	attr(this.timeTextDisplay_, Values.STYLE, Values.DISPLAY_BLOCK);
	text(this.timeTextDisplay_, msg);
	
	addClass(this.controlsDisplay_, Classes.ERROR);
};





$(function()
{
	$('.'+AUDIO_PLAYER_ID)[AUDIO_PLAYER_ID]();
});


$['widget']('ui.' + AUDIO_PLAYER_ID,
{
	'widgetEventPrefix': 'audioplayer.',
	
	'_create': function()
	{
		var self = this;
		var data = self['element'];
		var element = data[0];
		var object = $(element);
				
		if(is(object, 'audio'))
		{
			data.player_ = new AudioPlayer(object, element);
			
			data.dispatcher_ = function(e)
			{ self['_trigger'](e); }
			
			data.player_.addEventListener(MediaEvent.STARTED,	data.dispatcher_);
			data.player_.addEventListener(MediaEvent.ENDED,		data.dispatcher_);
			data.player_.addEventListener(MediaEvent.READY,		data.dispatcher_);
		}	
	},

	'destroy': function()
	{
		var data = this['element'];
			
			data.player_.removeEventListener(MediaEvent.STARTED,	data.dispatcher_);
			data.player_.removeEventListener(MediaEvent.ENDED,		data.dispatcher_);
			data.player_.removeEventListener(MediaEvent.READY,		data.dispatcher_);
			
			delete data.dispatcher_;
			data.dispatcher_ = null;
			
			data.player_.destroy();
			
			delete data.player_;
			data.player_ = null;
	},
	
	'play': function(opt_audioElement)
	{
		var data = this['element'];
			data.player_.play(opt_audioElement);			
	},
	
	'pause': function()
	{
		var data = this['element'];
			data.player_.pause();		
	},
	
	'volume': function(value)
	{
		var data = this['element'];
		
		if(value)
		{
			var volume = parseInt(value, 10) / 100;
			data.player_.setVolume(volume);
		}
		else
			return data.player_.volume();
	}
});

var defaultOptions = {}
	defaultOptions[Attributes.WIDTH]					= 300;
	defaultOptions[Attributes.HEIGHT]					= 29;
	defaultOptions[Attributes.DATA_CONTROLS_TIME]		= true;
	defaultOptions[Attributes.DATA_CONTROLS_VOLUME]		= true;
	defaultOptions[Attributes.DATA_CONTROLS_DURATION]	= true;
	defaultOptions[Attributes.DATA_VOLUME]				= 100;
	defaultOptions[Attributes.DATA_FALLBACK]			= 'AudioPlayerV1.swf';

$[FN][AUDIO_PLAYER_ID]['defaultOptions'] = defaultOptions;






var flash_proto = {};

flash_proto[MediaEvent.READY] = function(id)
{
	setTimeout(function(){
		if(DEBUG)console.log( id, ' ready');
		
		var obj = flashCollection[id];

		//obj.swf_ = $('#'+id).get(0);
		obj.swf_ = getObjectById(id);
		obj.readyHandler__.call(obj);
		
	},1);
};

flash_proto[MediaEvent.TIME_UPDATE] = function(id, time)
{
	var obj = flashCollection[id];		
	obj.currentTime_ = time;
	obj.timeupdateHandler__();
};

flash_proto[MediaEvent.PROGRESS] = function(id, progress)
{
	var obj = flashCollection[id];
	obj.progress_ = progress;		
	obj.progressHandler__();
};

flash_proto[MediaEvent.CAN_PLAY]		= function(id){ flashCollection[id].canplayHandler__(); };
flash_proto[MediaEvent.PLAYING]			= function(id){ flashCollection[id].playingHandler__(); };
flash_proto[MediaEvent.STARTED]			= function(id){	flashCollection[id].startingHandler__(); };
flash_proto[MediaEvent.PLAY]			= function(id){	flashCollection[id].playHandler__(); };
flash_proto[MediaEvent.PAUSE]			= function(id){	flashCollection[id].pauseHandler__(); };
flash_proto[MediaEvent.ENDED]			= function(id){ flashCollection[id].endedHandler__(); };
flash_proto[MediaEvent.VOLUME_CHANGE]	= function(id){ flashCollection[id].volumechangeHandler__(); };

flash_proto[MediaEvent.DURATION_CHANGE] = function(id, duration)
{
	var obj = flashCollection[id];
	obj.duration_ = duration;		
	obj.durationchangeHandler__();
};

flash_proto[MediaEvent.ERROR] = function(id, msg)
{
	if(DEBUG)console.log('ERROR:', id, msg);
	flashCollection[id].errorHandler__();
};

if(DEBUG)
{
	flash_proto['log'] = function(id, msg){ console.log('FLASH:', id, msg); };
}

$[FN][AUDIO_PLAYER_ID][PREFIX_FLASH_PROTO] = flash_proto;


})(jQuery);