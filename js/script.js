

function print_r( array, return_val ) {
	var output = "", pad_char = " ", pad_val = 2;

	var formatArray = function (obj, cur_depth, pad_val, pad_char) {
		if(cur_depth > 0)
			cur_depth++;

		var base_pad = repeat_char(pad_val*cur_depth, pad_char);
		var thick_pad = repeat_char(pad_val*(cur_depth+1), pad_char);
		var str = "";

		if(typeof obj=='object' || typeof obj=='array' || (obj.length>0 && typeof obj!='string' && typeof obj!='number')) {
			if(!(typeof obj=='object' || typeof obj=='array'))str = '\n'+obj.toString()+'\n';
      str += '(\n';//"Array\n" + base_pad + "(\n";
			for(var key in obj) {
				if(typeof obj[key]=='object' || typeof obj[key]=='array' || (obj.length>0 && typeof obj!='string' && typeof obj!='number')) {
          str += thick_pad + "["+key+"] => "+((!(typeof obj=='object' || typeof obj=='array'))?'\n['+obj[key]+']\n':'')+formatArray(obj[key], cur_depth+1, pad_val, pad_char)+'\n';
				} else {
					str += thick_pad + "["+key+"] => " + obj[key] + "\n";
				}
			}
			str += base_pad + ")\n";
		} else {
			str = obj.toString();
		};

		return str;
	};

	var repeat_char = function (len, char) {
		var str = "";
		for(var i=0; i < len; i++) { str += char; };
		return str;
		return str;
	};

	output = formatArray(array, 0, pad_val, pad_char);
		//return output;
	if(return_val !== true) {
		$( "body" ).prepend( "<pre>"+output+"</pre>" );
		return true;
	} else {
		return output;
	}
}



$(document).ready(function(){
	getAjax()
	
})

function getAjax()
{
	$.ajax({
		url: '/result.php',
		type: "GET",
		//data: variab,
		dataType: 'json',
	})
	.done(function(e){
		console.log(e)
		if (e.result.length > 0){
			$.each(e.result,function(key, val){
				//console.log(val);
				if (val.length > 0){
					//$( "body" ).prepend( "<pre>"+val+"</pre>" );
					print_r(val);
				}
			})
			
		}
		setTimeout(getAjax, 1000)
	})
	.fail(function(e){
		//console.log(e)
		setTimeout(getAjax, 1000)
	});
}