$(function(){
	$(".list").hide();
	var arres = new Array();

	// var x = $.inArray( 11, [ "8", "9", 10 ] );
	// alert(x)

	//alert(33);
	$(".alfa_info p").each(function(){
		 var arr = new Array();
		 var pp = $(this).text();
		 var splitted = pp.split(" ");

		var p = "";
		for (i = 0; i < splitted.length; i++) {
			if (splitted[i].toUpperCase() == "VIA" || splitted[i].toUpperCase() == "PIAZZA" || splitted[i].toUpperCase() == "VIALE" || splitted[i].toUpperCase() == "VICOLO" || splitted[i].toUpperCase() == "PIAZZALE" || splitted[i].toUpperCase() == "SALITA" || splitted[i].toUpperCase() == "PIAZZETTA" || splitted[i].toUpperCase() == "LUNGOTEVERE"  || splitted[i].toUpperCase() == "LARGO" || splitted[i].toUpperCase() == "PONTE" || splitted[i].toUpperCase() == "ARCO" || splitted[i].toUpperCase() == "ROTONDA" ) {
				var q = "";
				for (var j = i; j < splitted.length; j++) {
					q += splitted[j]+ " ";

				};
				p = q + p;
				break;
			}else
			p += splitted[i] + " ";
		};

		p = $.trim(p);
		//var tkp = $.inArray(p,arres);
		//$(".res").append("<div>"+p+"  "+tkp+"</div>");

		//if ($.inArray(p,arres) == -1) {
			 arres.push(p);
		     $(".res").append("<div>"+p+"</div>");
		//}
		
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


