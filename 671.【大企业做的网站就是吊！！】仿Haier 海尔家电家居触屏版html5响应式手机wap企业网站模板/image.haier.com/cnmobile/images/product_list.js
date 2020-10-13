//页面产品数目
var pageSize=4;
//产品发布路径
var mobiledocpuburl="";
//用于去掉几大类的产品比较，包括电脑和厨房中的燃气灶和套系,整体厨房
var globalChannelId="";
//初始化
function getInitJS(){
	//获取筛选器xml以及栏目id(pc版的栏目id)
	var filterPath="../../../public/phone/phonefilter.xml";
	var url = "";  //wcm生成的xml
	
	 jQuery.ajax({
        type:'get',
        dataType:'xml',
        url:filterPath,
		async:false,
        success:function(xml) {
            jQuery(xml).find("item").each(function(index){
				var $thisObj=$(this);
				var cName=$thisObj.text();
				//由于根据栏目名和获取的pc中的栏目名比较来获取栏目id和筛选器url，但是有的栏目名不一致需要单独设置
				if(cName=="冰吧"){
					cName="冰吧酒柜";
				}
				if(cName=="壁挂式空调"){
					cName="壁挂式空调_16009";
				}
				if(cName=="柜式空调"){
					cName="柜式空调_16015";
				}
				if(cName=="音箱"){
					cName="音箱_19595";
				}			
				if(cName=="空气源热水器"){
					cName="空气能热水器";
				}
				if(cName=="饮水机"){
					cName="饮水机后台信息采集";
				}					
				
				
				if(channelName==cName){
					//获取栏目id，构建搜索
					var channelId=$thisObj.attr("channldid");
					globalChannelId=channelId;
					searchword="channelId="+channelId;
					//获取筛选器xml
					var pcurl=$thisObj.attr("url");
					var resoucreURL= pcurl.substring(23);
						resoucreURL = "../../../../resoucre" + resoucreURL;
						url=resoucreURL;
					//console.log(resoucreURL)
				}
			});	
		},
        error:function() {
        }
    });
	//查询产品并初始化筛选器
    jQuery.ajax({
        type:'get',
        dataType:'xml',
        url:url,
		async:false,
        success:function(xml) {
            tableName = jQuery(xml).find("Filter").attr("viewName");	
			//检索
			search(searchword, tableName, 1, pageSize,orderStr);
			//生成筛选按钮
			onloadFilter(url);
		},
        error:function() {//没有筛选器，应用默认的
			jQuery(".btn-dropdown02").hide();
			search(searchword, tableName, 1, pageSize,orderStr);
        }
    });
	
	//点击选项排序
	jQuery(".orderBy").each(function(index1){
		jQuery(this).click(orderByProduct);
	});
	//筛选器左右滚动
	selectedSlideDom($("#selectListBox").children("li"));
	//将多余的筛选器隐藏
	jQuery("#selectListBox").find(".morefilter").hide();
	
}

//执行搜索
function search(_searchword,_tableName,_curPage,_pageSize,_strOrder){
	var searchResult = "";
	jQuery.ajax({
		type: "post",
		dataType: "json",
		url: "../../../../HaierFramework/product/productQuery.do",
		data: {
			'tableName':_tableName,
			'searchword':_searchword,
			'strOrder':_strOrder,
			'secondSearch':'false',
			'currentPage':_curPage,
			'pageSize':_pageSize
		},
		success: function(returnData){
		
			var resultList=returnData.productList;
			// 检索参数
			var searchword="";
			var tableName="";
			// 分页参数
			var currentPage = 1;
			var pageSize =4;
			var strOrder="";
			var totalCount = 0;
			if (resultList!=null && resultList.length>=1) {
				searchword = resultList[resultList.length-1].searchword;
				tableName = resultList[resultList.length-1].tableName;
				currentPage = resultList[resultList.length-1].currentPage;
				pageSize = resultList[resultList.length-1].pageSize;
				strOrder = resultList[resultList.length-1].strOrder;
				totalCount = resultList[resultList.length-1].totalCount;
				
				// 读取返回值
				for(var i=0;i<resultList.length-1;i++){
					var docpuburl= resultList[i].docpuburl; //文章发布路径
					var pName = resultList[i].pname;		//产品名称
					var ModelNo = resultList[i].modelno;	//产品型号
					var metaDataId = resultList[i].MetaDataId;//MetaDataId
					var price=resultList[i].price;//MetaDataId
					/*
					//产品比较xml路径
					var comparexml="";
					getMobileUrl(metaDataId);
					//获取xml
					if(mobiledocpuburl&&mobiledocpuburl!=""){
						comparexml=mobiledocpuburl.substring(mobiledocpuburl.indexOf("com/")+3);
						comparexml=comparexml.substring(0,comparexml.lastIndexOf("."));
						comparexml+="_ext.xml";
					}*/

					var picurl= resultList[i].appfile;	//产品图片
					if(picurl==''||picurl==null){
						picurl="${root_path}images/zw_mr.png";
					}else{
						var picStr = picurl.split(".");
						if (picStr.length==2){
							picurl = picStr[0]+"_208."+picStr[1];
						}
						picurl=docpuburl.substring(0,docpuburl.lastIndexOf("/"))+"/"+picurl;
					}
					if(i%2==1){
						searchResult+='<li class="nomargin">';	
					}else{
						searchResult+='<li>';
					}
					
					searchResult+='<a href="javascript:;" onclick="redirectUrl('+metaDataId+')" class="list-img"><img src="'+picurl+'" height="160" /></a><a href="javascript:;" onclick="redirectUrl('+metaDataId+')" class="large-img"><img src="'+picurl+'" width="267" height="267" alt /></a>';
					searchResult+='<div class="product-intro js_productIntro">';
					searchResult+='<h3><a href="javascript:;" onclick="redirectUrl('+metaDataId+')">'+pName+'</a></h3>';
					searchResult+='<ul class="grading-bar"><li class="star-light"></li><li class="star-light"></li><li class="star-light"></li><li class="star-light"></li><li class="star-light"></li></ul>';
					searchResult+='<p class="gray">型号:'+ModelNo+'</p>';
					if(price&&price!="0"){
						//searchResult+='<p>价格:<span class="color">￥'+price+'</span></p>';
					}
					if(globalChannelId!=358&&globalChannelId!=359&&globalChannelId!=360&&globalChannelId!=361&&globalChannelId!=15007&&globalChannelId!=3699&&globalChannelId!=363&&globalChannelId!=364&&globalChannelId!=366&&globalChannelId!=367&&globalChannelId!=321&&globalChannelId!=324&&globalChannelId!=326&&globalChannelId!=327&&globalChannelId!=328&&globalChannelId!=329){
						searchResult+='<input name="productId" value="'+metaDataId+'" type="hidden" comparevalue=""/><a href="javascript:void(0);" class="btn-compare joinCompare">加入比较</a>';
					}
					searchResult+='</div>';
				}
				
				
				if(searchResult==""){
					searchResult="没有所需产品";
				}
				
				jQuery(".js_productList").html("");
				jQuery(".js_productList").html(searchResult);
				
				//如果是另一种列表展示形式将样式设置为当前样式
				var js_productList = jQuery('.js_productList');
				if (js_productList.hasClass('product-list-large')) {
					jQuery('.js_productList').addClass('clearfix');
					jQuery('.js_productIntro').removeClass('product-intro').addClass('product-intro-large');
					jQuery('.joinCompare').removeClass('btn-compare').addClass('btn-large-com').addClass('btn-compare-large');
				}
				assignCompareCookie(true);//恢复之前的比较样式
				//生成分页
				var pageCount=Math.ceil(totalCount/pageSize);
				if (pageCount<1) {
					pageCount=1;
				}
				
				var pager=new Pager("productPage");
				pager.currPage=currentPage;
				pager.pageSize=pageSize;
				pager.totalCount=totalCount;
				pager.pageCount=pageCount;
				pager.onclick = function(currPageT) {
					search(searchword,tableName,currPageT,pageSize,strOrder);
				};		
				resizeProductImg();				
				pager.render();
			}
		},
		error:function(){
		}
	});
}

//加载筛选器
function onloadFilter(urlstr){
	var url=urlstr;
	var columnCount = "";
    var content = "";
    jQuery.ajax({
		type:'get',
        dataType:'xml',
        url:url,
		async:false,
        success:function(xml) {
			jQuery(xml).find("optiongroup").each(function(index) {
				columnCount = jQuery(this).attr("columnCount");
				if(columnCount!=null&&columnCount!=""&&columnCount!=0){
					//控制显示更多筛选器
					if(index>2){
						content +='<li class="select-cont01 morefilter">';
					}else{
						content +='<li class="select-cont01">';
					}
					content +='<span class="cont01-words optionSearch" data-optionSearch="' + jQuery(this).attr("inputName") + '">'+jQuery(this).attr("name") +'</span><div class="select-list02"><ul class="clearfix"><li><a data-optionSearchChoosed="" href="javascript:void(0);" class="selectedOption">不限</a></li>';
					
					jQuery(this).find("option").each(function(index1) {
						content +='<li><a data-optionSearchChoosed="' + jQuery(this).attr("query")+'" href="javascript:void(0);" ';
						if (channelName.indexOf(jQuery(this).attr("name")) > -1) {//如果当前栏目是当前筛选项，则选中
							content +=' class="selectedOption curr">'+jQuery(this).attr("name")+'</a></li>';
						}else{
							content +=' class="selectedOption">'+jQuery(this).attr("name")+'</a></li>';
						}
						
					});
					content +='</ul></div><a href="javascript:void(0);" class="arrow03 btn-next selectRight"></a><a href="javascript:void(0);" class="arrow03 btn-pre selectLeft"></a></li>';
					
				}
			});
			jQuery("#selectListBox").html("");
			jQuery("#selectListBox").html(content);

			//如果一类中没有没有选择项，选中不限
			jQuery("#selectListBox .select-list02").find("ul").each(function(index2){
				if(jQuery(this).find(".curr").size()==0){//没有选中的项
					jQuery(this).find("a:eq(0)").addClass("curr");
				}
			});
		},
		error:function() {
		alert("errorfilter");
        }
	});
}

//执行筛选搜索
function filterSearch(){
	//获取筛选项构建search
	searchword="";//清空search
	jQuery("#selectListBox").find(".curr").each(function(index){
		var searchStr=jQuery(this).attr("data-optionSearchChoosed");
		if(searchStr&&searchStr!=""){
			searchword+=searchStr+" AND "
		}
	});
	searchword = jQuery.trim(searchword);
    searchword = searchword.substring(0, searchword.lastIndexOf("AND"));
	search(searchword, tableName, 1, pageSize,orderStr);
}
//点击排序
function orderByProduct(){
	var type=jQuery(this).attr("type");//获取类型
	var flag=false;
	flag=jQuery(this).hasClass("default");//是否选中
	//去掉所有选中项
	jQuery(".orderBy").each(function(index1){
		jQuery(this).removeClass("default");
	});
	//如果没有选中，给点击项添加选中样式
	if(!flag){
		jQuery(this).addClass("default");
	}
	
	if(type=="Hot"){
		//如果没有选中采用降序，如果已选中再次点击采用升序
		if(!flag){
			orderStr="-remaipin";
		}else{
			orderStr="+remaipin";
		}
	}else if(type=="Time"){
		if(!flag){
			orderStr="-shangshishijian";
		}else{
			orderStr="+shangshishijian";
		}
	}else if(type=="Price"){
		if(!flag){
			orderStr="-price";
		}else{
			orderStr="+price";
		}
	}
	search(searchword, tableName, 1, pageSize,orderStr);
}
//获取产品细缆
function redirectUrl(metadataId){
		if(metadataId!=""){
			jQuery.ajax({
				type:'post',
				dataType:'json',
				data:{'metadataId':metadataId},
				url:"../../../../HaierFramework/haier/faqsolve/queryMobileURL.do",
				success:function(returnObj) {
					if(returnObj.isSuccess){
						var redurl = returnObj.mobilepuburl;
						if(redurl!=""){
							window.location.href=redurl;
						}
					}
				},
				error:function() {
				}
			});
		}
}		 
//获取产品详细页面
function getMobileUrl(metadataId){
		if(metadataId!=""){
			jQuery.ajax({
				type:'post',
				dataType:'json',
				data:{'metadataId':metadataId},
				url:"../../../../HaierFramework/haier/faqsolve/queryMobileURL.do",
				async:false,
				success:function(returnObj) {
					if(returnObj.isSuccess){
						var redurl = returnObj.mobilepuburl;
						mobiledocpuburl=redurl;
					}
				},
				error:function() {
				}
			});
		}
	 }	 
