/**
 * @author Yeicot
 */
// Totos los formularios de datos deben tener un FORM con ID="frmData"
var idForms = "frmData";
var MngForms = function(  ){
	var _vlNwId = 0;
	var frmBase = null;
	
	var genId = function(){
		return _vlNwId++;
	};
	
	this.setFormBase = function(vl){
		frmBase = $( vl );
	};

	var obtenerUltimoId = function(){
		var ultimoId = "x";
		jQuery( "div[id^='nwO_']").each(function(){
			ultimoId = jQuery( this ).attr("id");
		});

		return ultimoId;
	};
	
	var copiarValores = function( id, dest ){
		var objCur = "#" + id;
		
		if( id == "x" ){
			objCur = frmBase;
		}
		
		jQuery( objCur ).find(":input").each(function(){
			var o = jQuery( this );
			var v = o.val();
			
			var nmObjDest = obtenerSoloNombre( o.attr("id") ) + "_" + dest;
			var nwVals = jQuery( "#nwO_" + dest + " #" + nmObjDest ).val( v );
		});
	};
	
	var obtenerSoloNombre = function( objN ){
		var strPartes = ("" + objN).split("_");
		var realName = new String();
		
		for(var i = 0; i < (strPartes.length - 1); i++){
			realName += strPartes[ i ] + "_";
		}
		realName = realName.substring(0, realName.length - 1);
		
		return realName;
	};
	
	this.agregarCampos = function( o ){
		var nwId = genId();
		var idObj = obtenerUltimoId();
		var orgHtml = new String(frmBase.html());
		var nwHtml = orgHtml.replace(/\_x\"/ig, "_" + nwId + "\"");
		nwHtml = nwHtml.replace(/\_x\'/ig, "_" + nwId + "\'");
		
		var objNW = jQuery( '<div id="nwO_' + nwId + '"><span class="div_cerrar">X</span>' + nwHtml + '</div>' );
		objNW.css("display", "none");
		jQuery( o.data.value ).before( objNW );
		objNW.show("slow");
		
		jQuery( "#nwO_" + nwId + ">span" ).on("click", function(){
			jQuery( this ).parent().hide("slow", function(){
				jQuery(this).remove();
			});
		});
		
		copiarValores( idObj, nwId );
	};
	
};

var mngForms = new MngForms();
var nombreSumaObjs = "sumarObj";

jQuery(document).ready(function($){
	var oFrm = $( "#" + idForms );
	var oFrmTb = $( "#" + oFrm.attr("id") + " div" );
	
	oFrm.append('<span class="div_masfields" id="' + nombreSumaObjs + '"><span>+</span>Agregar Campos</span>');
	
	mngForms.setFormBase( oFrmTb );
	$( "#" + nombreSumaObjs ).on( "click", {'value' : "#" + nombreSumaObjs}, mngForms.agregarCampos );
});