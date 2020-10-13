(function($){
	$.fn.extend({
		forms:function(opt){
			if(opt===undefined)
				opt={}
			this.each(function(){
				var th=$(this),
					data=th.data('forms'),
					_={
						errorCl:'error',
						emptyCl:'empty',
						invalidCl:'invalid',
						successCl:'success',
						successShow:'4000',
						mailHandlerURL:'bin/MailHandler.php',
						ownerEmail:'support@guardlex.com',
						stripHTML:true,
						smtpMailServer:'localhost',
						targets:'input,textarea',
						controls:'a[data-type=reset],a[data-type=submit]',
						validate:true,
						rx:{
							".name":{rx:/^[a-zA-Z'][a-zA-Z-' ]+[a-zA-Z']?$/,target:'input'},
							".state":{rx:/^[a-zA-Z'][a-zA-Z-' ]+[a-zA-Z']?$/,target:'input'},
							".email":{rx:/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i,target:'input'},
							".phone":{rx:/^\+?(\d[\d\-\+\(\) ]{5,}\d$)/,target:'input'},
							".fax":{rx:/^\+?(\d[\d\-\+\(\) ]{5,}\d$)/,target:'input'},
							".message":{rx:/.{20}/,target:'textarea'}
						},
						preFu:function(){
							_.labels.each(function(){
								var label=$(this),
									inp=$(_.targets,this),
									defVal=inp.attr('value'),
									trueVal=(function(){
												var tmp=inp.is('input')?(tmp=label.html().match(/value=['"](.+?)['"].+/),!!tmp&&!!tmp[1]&&tmp[1]):inp.html()
												return tmp
											})()

								trueVal!=defVal
									&&inp.val(defVal=trueVal||defVal)
								label.data({defVal:defVal})								
								inp
									.bind('focus',function(){
										inp.val()==defVal
											&&(inp.val(''),_.hideEmptyFu(label),label.removeClass(_.invalidCl))
									})
									.bind('blur',function(){
										!inp.val()
											?inp.val(defVal)										
											:(_.isValid(label)
												?_.showErrorFu(label)
												:_.hideErrorFu(label)),
											(_.isEmpty(label)
												?_.showEmptyFu(label)
												:_.hideEmptyFu(label))
									})
									.bind('keyup',function(){
										label.hasClass(_.invalidCl)
											&&_.isValid(label)
												?_.showErrorFu(label)
												:_.hideErrorFu(label)
									})
								label.find('.'+_.errorCl+',.'+_.emptyCl).css({display:'block'}).hide()
							})
							_.success=$('.'+_.successCl,_.form).hide()
						},
						isValid:function(el){
							var ret=true,
								empt=_.isEmpty(el)
							console.log(empt)
							if(empt)
								ret=false,
								el.addClass(_.invalidCl)
							else
								$.each(_.rx,function(k,d){
									if(el.is(k))
										d.rx.test(el.find(d.target).val())
											?(el.removeClass(_.invalidCl),ret=false,console.log(12))
											:el.addClass(_.invalidCl)
								})
							return ret
						},
						isEmpty:function(el){
							var tmp
							return (tmp=el.find(_.targets).val())==''||tmp==el.data('defVal')
						},
						validateFu:function(){							
							_.labels.each(function(){
								var th=$(this)								
								_.isEmpty(th)
									?_.showEmptyFu(th)
									:_.hideEmptyFu(th)
								_.isValid(th)
									?_.showErrorFu(th)
									:_.hideErrorFu(th)
							})
						},
						submitFu:function(){
							_.validateFu()
							if(!_.form.has('.'+_.invalidCl).length)
								$.ajax({
									type: "POST",
									url:_.mailHandlerURL,
									data:{
										name:$('.name input',_.form).val()||'nope',
										email:$('.email input',_.form).val()||'nope',
										phone:$('.phone input',_.form).val()||'nope',
										fax:$('.fax input',_.form).val()||'nope',
										state:$('.state input',_.form).val()||'nope',
										message:$('.message textarea',_.form).val()||'nope',
										owner_email:_.ownerEmail,
										stripHTML:_.stripHTML
									},
									success: function(){
										_.showFu()
									}
								})			
						},
						showFu:function(){
							_.success.slideDown(function(){
								setTimeout(function(){
									_.success.slideUp()
									_.form.trigger('reset')
								},_.successShow)
							})
						},
						controlsFu:function(){
							$(_.controls,_.form).each(function(){
								var th=$(this)
								th
									.bind('click',function(){
										_.form.trigger(th.data('type'))
										return false
									})
							})
						},
						showErrorFu:function(label){
							label.find('.'+_.errorCl).slideDown()
						},
						hideErrorFu:function(label){
							label.find('.'+_.errorCl).slideUp()
						},
						showEmptyFu:function(label){
							label.find('.'+_.emptyCl).slideDown()
							_.hideErrorFu(label)
						},
						hideEmptyFu:function(label){
							label.find('.'+_.emptyCl).slideUp()
						},
						init:function(){
							_.form=this
							_.labels=$('label',_.form)

							_.preFu()
							
							_.controlsFu()
															
							_.form
								.bind('submit',function(){
									if(_.validate)
										_.submitFu()
									else
										_.form[0].submit()
									return false
								})
								.bind('reset',function(){
									_.labels.removeClass(_.invalidCl)									
									_.labels.each(function(){
										var th=$(this)
										_.hideErrorFu(th)
										_.hideEmptyFu(th)
									})
								})
							_.form.trigger('reset')
						}
					}
				if(!data)
					(typeof opt=='object'?$.extend(_,opt):_).init.call(th),
					th.data({cScroll:_}),
					data=_
				else
					_=typeof opt=='object'?$.extend(data,opt):data
			})
			return this
		}
	})
})(jQuery)