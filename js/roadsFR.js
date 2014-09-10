$(function(){
	$(".list").hide();
	var arres = new Array();

	$(".new").each(function(){
		var p = $(this).text();
		p = $.trim(p);
		arres.push(p);
		$(".res").append("<div>"+p+"</div>");
	});

	callUpload(arres);
})

function callUpload(p)
{
	$.ajax({
		type: 'post',
		url:  'php/write.php',
		contentType: 'application/x-www-form-urlencoded',
		data:{
			p:p
		},
		success: function(rip) {
			alert(rip);
		},
		error: function(request, status, error){
			alert("err"+error);
		}
	});
}


