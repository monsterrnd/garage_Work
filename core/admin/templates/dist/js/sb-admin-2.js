
var ExFormated;
ExFormated = {
	variab:{
		changebasketTime: "",
	},	
	getModule : function (el,module,act,type,block,clear_form){
		ExForm.serializeForm(el,function(objforsend,objforsendandname){
			
			if (!clear_form)
				clear_form = "";
			
			bag.i("ExFormated.getModule.el ",el);
			bag.i("ExFormated.getModule.objforsendandname ",objforsendandname);
			

			if (typeof(el) == "object")
			{
				el = "";
			}
			
			var res;
			if (type == "c-data-name")
			{
				var query = {};
				query[module] = {
					"ACTION" : act,
					"BLOCK_RETURN" : block,
					"ELEMENT": el,
					"CLEAR_FORM": clear_form,
					"FILDS" : objforsendandname
				}
				MainAjax.returnOneToBlocks(query,true)		
				
			}
			else
			{
				var query = {};
				query[module] = {
					"ACTION" : act,
					"BLOCK_RETURN" : block,
					"ELEMENT": el,
					"CLEAR_FORM": clear_form,
					"FILDS" : objforsend
				}
				MainAjax.returnOneToBlocks(query,true)

			}
			bag.i("ExFormated.getModule.res ", res);
		})
	}
}












$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
     return this.href == url;
    }).addClass('active').parent();

    while(true){
        if (element.is('li')){
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});


//
//
//SSS = "<div class=\"modal fade\" id=\"queryModal\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"queryModalLabel\" aria-hidden=\"true\" style=\"display: none;\"> \n\
//			<div class=\"modal-dialog\"> \n\
//				<div class=\"modal-content\"> \n\
//					<div class=\"modal-header\"> \n\
//						<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">×</button> \n\
//						<h4 class=\"modal-title\" id=\"queryModalLabel\">"+title+"</h4> \n\
//					</div> \n\
//					<div class=\"modal-body\"> \n\
//						"+text+" \n\
//					</div> \n\
//					<div class=\"modal-footer\"> \n\
//						<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Отмена</button> \n\
//						<button type=\"button\" class=\"btn btn-danger\">Удалить</button> \n\
//					</div> \n\
//				</div> \n\
//			</div> \n\
//        </div>";