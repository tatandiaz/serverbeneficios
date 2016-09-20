var Utilidades = function () {

	
	this.appPath = function( fld ){
		var scriptEls = document.getElementsByTagName( 'script' );
		var thisScriptEl = scriptEls[scriptEls.length - 1];
		var scriptPath = thisScriptEl.src;
		var scriptFolder = scriptPath.substr(0, scriptPath.lastIndexOf( '/' )+1 );

		// Folder Img
		var imgFolder = scriptFolder.substr(0, scriptFolder.length - 1 );
		imgFolder = imgFolder.substr(0, imgFolder.lastIndexOf( '/' )+1 ) + fld;
		
		return imgFolder;
	};
	
	this.Telon = function(hijos){
		var idTel = "gblTelon";
		jQuery("#"+idTel).remove();
		
		var actualScrollY = jQuery(window).scrollTop();
		
		var obj = jQuery("<div></div>")
		.attr("id", idTel)
		.css("width", jQuery( window ).outerWidth(true) )
		.css("height", jQuery( window ).outerHeight(true) )
		.css("position", "absolute")
		.css("top", actualScrollY + "px")
		.css("left", "0px")
		.css("display", "none") 
		.css("background", "rgba(0,0,0,0.3)");
		jQuery("body").append(obj);
		obj.fadeIn("fast");
		
		jQuery(window).on("scroll",function (event) {
			obj.css("top", ( jQuery(window).scrollTop() ) + "px");
		});
		
		jQuery(window).on("resize", function(){
			obj.css("width", jQuery( window ).outerWidth(true) )
			.css("height", jQuery( window ).outerHeight(true) );
		});
		
		jQuery(obj).on("click", function(){
			jQuery(hijos).fadeOut("fast");
			jQuery(this).fadeOut("fast");
			jQuery( "#" + idTel).remove();
		});
		return obj;
	};
	
	this.MensajeTelon = function(idT, o){
		var btnNameClose = "glbBtnCloseTelon";
		jQuery( "#" + btnNameClose).remove();
		
		var frm = jQuery( o );
		var enX = ((jQuery(window).outerWidth(true)) / 2) - (frm.outerWidth(true)/2);
		var enY = (jQuery(window).scrollTop() + 100);
		frm.css("position", "absolute")
			.css("top", enY + "px")
			.css("left", enX + "px")
			.css("z-index", "9999999");
		frm.fadeIn("fast");
		
		
		$objSalir = jQuery("<b>X</b>")
		.attr("id", btnNameClose)
		.addClass("btnCerrarTelones")
		.on("click", function(){
			jQuery(frm).fadeOut("fast");
			jQuery(idT).fadeOut("fast");
			jQuery(idT).remove();
		});
		
		frm.prepend( $objSalir );

		jQuery(window).on("scroll",function (event) {
			frm.css("top", ( jQuery(window).scrollTop() + enY ) + "px");
		});
	};
	
	this.ComponenteFecha = function(idFecha, idA, idM, idD){
		var va = new String(jQuery(idA).val());
		var vm = new String(jQuery(idM).val());
		var vd = new String(jQuery(idD).val());
		
		vm = (vm.length == 1 ? "0" + vm : vm);
		vd = (vd.length == 1 ? "0" + vd : vd);
		
		var anyoTmp = new Date();
		va = (va.length > 0 ? va : anyoTmp.getFullYear());
		vm = (vm.length > 0 ? vm : "01");
		vd = (vd.length > 0 ? vd : "01");
		
		var f = jQuery( idFecha );
		f.val( va + "-" + vm + "-" + vd );
	};
	
	this.ComponenteHora = function(idHora, idH, idM){
		var vh = new String(jQuery(idH).val());
		var vm = new String(jQuery(idM).val());
		
		vh = (vh.length == 1 ? "0" + vh : vh);
		vm = (vm.length == 1 ? "0" + vm : vm);
		
		vh = (vh.length > 0 ? vh : "00");
		vm = (vm.length > 0 ? vm : "00");
		
		var f = jQuery( idHora );
		f.val( vh + ":" + vm );
	};
	
	this.isLandscape = function(){
		var landscapeOrientation = window.innerWidth / window.innerHeight > 1;
		return landscapeOrientation;
	};
};
