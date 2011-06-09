function load(location){
	document.location.replace(site_url+'/'+location);
}

function createCookie(c_name,value,expiredays) {
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	}
	
function readCookie(c_name)	{
	if (document.cookie.length>0)
	{
	c_start=document.cookie.indexOf(c_name + "=");
	if (c_start!=-1)
		{ 
		c_start=c_start + c_name.length+1; 
		c_end=document.cookie.indexOf(";",c_start);
		if (c_end==-1) c_end=document.cookie.length;
		return unescape(document.cookie.substring(c_start,c_end));
		}
	}
	return null;
}

$(document).ready(function(){
	//$('#jr_reject').hide();
	//$('div#toppanel').fadeIn();
	$('.tab').click(function(){
		if($('#open:visible').length==1)
			load('');
	});

	$('.tablesorter')
		.tablesorter({widthFixed: true, widgets: ['zebra']})
		.tablesorterPager({container: $("#pagination")})
		.tablesorterFilter({filterContainer: $("#filter-box"),
                          filterClearContainer: $("#filter-clear-button"),
                          filterColumns: [0],
                          filterCaseSensitive: false});
						  
	$('.form_large #submit').removeClass('submit_default').button();
/*
	var notification = $('.notification');
	var parent = $('.notification').parent();
	$('.notification').dialog({
		resizable:false,
		modal:true,
		buttons: {
			Ok: function() {
				$(this).dialog('close');
			}
		},
		close:function(){
			notification.css('min-height','0px');
			parent.append(notification).show('blind',500);
			//notification.appendTo(parent).show('slide',500);
			$('.notification-close').show().click(function(){
				notification.hide('blind',500);
			});
		}
	});
*/
	$('.notification-close').show().click(function(){
		$(this).parent().hide('blind',500);
	});
	
	// createCookie('dummycookie', '23', 1);
	// var tmp = readCookie('dummycookie');
	// if( tmp == null) {
		// alert('waaa');
	// }
});