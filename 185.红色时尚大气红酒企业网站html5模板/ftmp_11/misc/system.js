(function($) {
  $(document).ready(function() {
    if (window.location.hash) processHash(window.location.hash.substring(1));
    if (lms && lms.error) msg(lms.error, 'Error');
    if (lms && lms.msg) msg(lms.msg, 'Message');
    versions();
  });
  
  /* check browser versions and add a body class */
  function versions() {
    if ($.browser.msie) {
      if (parseInt($.browser.version, 10) < 8) $('body').addClass('browser-msie-7');
      else if (parseInt($.browser.version, 10) < 9) $('body').addClass('browser-msie-8');
      else $('body').addClass('browser-msie-9');
    }

    
  }
  
  /* processes hash part of url */
  function processHash(hash) {
    var _ = hash.split(';');
    hash = {};
    for (var i in _) {
      var __ = _[i].split('=');
      hash[__[0]] = __[1];
    }
    checkHash(hash);
  }
  
  /* checks hash for patterns */
  function checkHash(hash) {
    if (hash.msg) msg(hash.msg, 'Message');
    if (hash.error) msg(hash.error, 'Error');
  }
  
  /* fires message */
  function msg(m, type, cls) {
    var _ = '<div id="dialog-message" title="'+type+'">'+m+'</div>';
    if (!cls) cls = '';
    $(_).dialog({ modal: true, dialogClass: cls,
      buttons: {
        Ok: function() {
          $(this).dialog("destroy");
        }
      }
    });
  }
  
})(jQuery);

String.prototype.namespace = function(separator){
  var ns = this.split(separator || '.')
  var o = window;
  for(var i=0, len=ns.length; i<len; i++){
    o = o[ns[i]] = o[ns[i]] || {};
  }
  return o;
};

/* Events mechanism -> each action that might call event has functions that have to be executed upon event call */
/*
  edit_finished: editor is finished editing - time to javascript the content!


*/
'lms.events'.namespace();
lms.events.call = function(event) {
  if (!event || !lms.events[event]) return;
  for (var i in lms.events[event]) {
    eval(lms.events[event][i]+'()');
  }
}

jQuery.fn.serializeJSON=function() {
  var json = {};
  jQuery.map(jQuery(this).serializeArray(), function(n, i){
    var _ = n.name.indexOf('[');
    if (_ > -1) {
      var _cat = n.name.substr(0, _);
      var _name = n.name.substr(_+1).replace(']', '');
      if (!json[_cat]) json[_cat] = {};
      json[_cat][_name] = n['value'];
    }
    else json[n['name']] = n['value'];
  });
  return json;
};
