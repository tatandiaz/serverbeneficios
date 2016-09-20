/**
 * 
 * @author Yeicot
 */
var PageMenu = function(){
	var items = new Array();
	
	this.agregarMenu = function( icono, label, link ){		
		var itemMenu = new ItemMenu();
		itemMenu.icono = icono;
		itemMenu.label = label;
		itemMenu.link = link;
		
		items.push( itemMenu );
	};
	
	this.obtenerMenu = function(){
		return items;
	};
	
	this.render = function(){
		var htmlT = new String("");
		for(var i in items){
			var o = items[ i ];
			
			var tmpHtml  = '<div id="' + constBtnName + '_' + i + '" onclick="btnDib(' + i + ');">';
			tmpHtml 	+= '	<div class="ad-itemsMenu" style="background: transparent url(' + o.icono + ') center center no-repeat; background-size: 13px 13px;" >&nbsp;</div>';
			tmpHtml 	+= '	<label>' + o.label + '</label>';
			tmpHtml 	+= '</div>';
			htmlT += tmpHtml;
		}
		return htmlT;
	};
	
};

var ItemMenu = function(){	
	this.icono = "";
	this.label = "";
	this.link = "";
};

var utilidades = new Utilidades();
var pageMenu = new PageMenu();
pageMenu.agregarMenu( utilidades.appPath("img/") + "admin_inicio.png","&Aacute;REA DE TRABAJO","Workspace.phtml");
pageMenu.agregarMenu( utilidades.appPath("img/") + "admin_casos.png","MESAS","modelos/Mesas.phtml");
pageMenu.agregarMenu( utilidades.appPath("img/") + "admin_casos.png","PROCESOS","modelos/Procesos.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "CLASIFICACI&Oacute;N", "modelos/Categorias.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "RESPONSABLES", "modelos/Responsables.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "CATEGORIAS CLIENTE", "modelos/CategoriasCliente.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "CATEGORIAS ESTRATEGICAS", "modelos/CategoriasEstrategia.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "PRIORIDAD", "modelos/Prioridad.phtml");
pageMenu.agregarMenu(utilidades.appPath("img/") + "admin_casos.png", "IMPACTO", "modelos/Impacto.phtml");



//pageMenu.agregarMenu( utilidades.appPath("img/") + "admin_casos.png","Principal","modelos/Principal.phtml");
//pageMenu.agregarMenu( utilidades.appPath("img/") + "admin_casos.png","P&aacute;ginas","modelos/Publica.phtml");

var objIcono = "top-icono";
var objTexto = "top-texto";

var dibMenu = function( id ){
	var o = pageMenu.obtenerMenu();
	var deO = o[ id ];
	var txt = '<div style="background: transparent url(' + deO.icono + ') center center no-repeat; background-size: 48px 48px;width: 79px;height: 76px;">&nbsp;</div>';
	$("#" + objIcono).html("" + txt );
	$("#" + objTexto).html("" + deO.label);	

	jQuery( "div[id^='" + constBtnName + "_'" ).removeClass("ad-menusSeleccionados");
	jQuery( "#" + constBtnName + '_' + id ).addClass("ad-menusSeleccionados");
	
};

var btnDib = function (id) {
	var o = pageMenu.obtenerMenu();
	oId = o[ id ];
	params = {'jsmenuid' : id, 'pageid' : '' + oId.link};
    method = "post";
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", "./");

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
};

jQuery(document).ready(function($){
	dibMenu( 0 );
});

var constBtnName = "mnb";
