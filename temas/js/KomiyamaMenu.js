a/**
 * @author yalfonso
 */

var KomiyamaMenu = function(){
	var este = this;
	
	// Contenedores generales
	var tbClase 	= "yabtbmenu";
	var izq 		= "menuizq";
	var conte 		= "menucen";
	var car 		= "menucar";
	
	this.Contenedor = "";
	this.Base = "";
	this.Uri = "";
	
	var xhr = null;
	
	var crearTitulos = function(){
		xhr = jQuery.post(este.Base + este.Uri, function(data){
		
			var ulEl = document.createElement("ul");
			ulEl.setAttribute("class", "menuListaUl");
			
			var infOb = data["lista"];
			var itemsIni = data["items"];
			
			var primFlag = true;
			var nombreMEnuSel = "";
			for( var oArr in infOb ){
				var oA1 = infOb[oArr];
				var idLs = oA1["id"];
				
				var liEl = document.createElement("li");
				liEl.setAttribute("id", "ls_" + idLs);
				
				var tituTexto = QuoteToHex( oA1["nombre"] );
				var txt = document.createTextNode( tituTexto );
				var vinc = document.createElement("b");
				vinc.setAttribute("class", "txtMenuLista");
				vinc.appendChild(txt);
				
				var adorno = document.createElement("div");
				adorno.setAttribute("class", "menuizqardono");
				
				var cpImg = document.createElement("div");
				cpImg.setAttribute("style", "background-image: url(" + este.Base + "repo/delmenu/" + oA1["imagen"] + ");");
				cpImg.setAttribute("class","menuizqIconos");
				
				liEl.appendChild(adorno);
				liEl.appendChild(cpImg);
				liEl.appendChild(vinc);
				
				liEl.addEventListener("click", function( ){ mostrarItems( this ); }, false);
				
				ulEl.appendChild(liEl);
				
				if(primFlag){
					nombreMEnuSel = tituTexto;
				}
				
				primFlag = false;
			}
			
			var tdMenuCentro = "." + tbClase + " ." + izq;
			
			var elC = document.querySelector( tdMenuCentro );			
			elC.appendChild( ulEl );
			
			var capaGrande = document.createElement("div");
			capaGrande.setAttribute("class", "btnMenuIzqVerMas");
			capaGrande.appendChild(document.createTextNode("+ Ver m\xE1s"));
			elC.appendChild( capaGrande );
			
			var capaGrandeMenos = document.createElement("div");
			capaGrandeMenos.setAttribute("class", "btnMenuIzqVerMenos");
			capaGrandeMenos.appendChild(document.createTextNode("- Ver menos"));
			elC.appendChild( capaGrandeMenos );
			
			capaGrande.addEventListener("click", function( ){ bajarScrollLista( ulEl, capaGrandeMenos, "+=49" ); }, false);
			capaGrandeMenos.addEventListener("click", function( ){ bajarScrollLista( ulEl, capaGrandeMenos, "-=49" ); }, false);
			
			crearItems(nombreMEnuSel, itemsIni);
			
		});
		
		xhr.always(function(){
			//alert("Terminado");
		});
	};
	
	var bajarScrollLista = function(vPad, verONo, mov){
		var o = jQuery(vPad);
		var oVn = jQuery(verONo);		
		o.animate({
			scrollTop : mov 
		}, 500, function(){
			
			var curScroll = o.scrollTop();
			
			if( curScroll > 0 ){
				oVn.css("display", "table-cell");
			}
			if( curScroll < 20 ){
				oVn.hide("slow");
				oVn.css("display", "table-cell");
			}
			
		});
		
	};
	
	var mostrarItems = function(oEste){
		var idO = new String( oEste.id );
		var partId = idO.split("_");
		if(partId.length > 1){
			try{
				window.stop();
			}catch(e){
				console.log(e);
			}
			xhr.abort();
			xhr = jQuery.post(este.Base + este.Uri, {iditems: partId[1]}, function(data){
				var jQt = jQuery( oEste );
				crearItems(jQt.text(), data);
			});
		}
		else{
			alert("Id incorrecto: " + idO);
		}

	};
	
	var crearItems = function(titulo, idItem){
		var tdMenuCont = "." + tbClase + " ." + conte;
		
		var ulEl = document.createElement("ul");
		ulEl.setAttribute("class","itemsDelMenu");
		if(idItem != null){
			
			var oI = idItem;
			for(var o1 in oI){
				var elJ = oI[o1];
				var nombre = QuoteToHex( elJ["nombre"] );
				var liEl = document.createElement("li");
				
				var capCont = document.createElement("div");
				capCont.setAttribute("class", "cpInfoItem");
				capCont.setAttribute("style", "background-image: url(" + este.Base + "repo/delmenu/" + elJ["imagen"] + ");");
				
				var tbDetItm 	 = "<table width=\"100%\" height=\"100%\"> \n";
				tbDetItm 		+= "	<tbody> \n";
				tbDetItm 		+= "		<tr><td height=\"10%\">&nbsp;</td></tr> \n";
				tbDetItm 		+= "		<tr><td height=\"80%\" class=\"tbTxtMenuItem\" >" + nombre + "</td></tr> \n";
				tbDetItm 		+= "		<tr><td height=\"10%\">&nbsp;</td></tr> \n";
				tbDetItm 		+= "	</tbody> \n";
				tbDetItm		+= "</table> \n";
				
				capCont.innerHTML = tbDetItm;
				liEl.appendChild(capCont);
				
				var preDeta = document.createElement("div");
				
				var infoPrec = elJ["precio"];
				var tbPrec 	 = "<table class=\"tbTxtMenuPrecDet\"> \n";
				tbPrec 		+= "	<tbody> \n";
				for(var prI in infoPrec){
					var oPr = infoPrec[prI];
					
					var rtT = (oPr["rotulo"] + "");
					if( rtT.length >= 9 ){
						rtT = rtT.substring(0, 6) + ".";
					}
					var vlFrm = (parseInt( oPr["valor"] ) ).toFixed(1).replace(/./g, function(c, i, a) {
					    return i && c !== "." && ((a.length - i) % 3 === 0) ? ',' + c : c;
					});
					
					
					tbPrec 		+= "		<tr> \n";
					tbPrec 		+= "			<td align=\"left\" class=\"mnIzqPre\">" + rtT + "</td> \n";
					tbPrec 		+= "			<td align=\"right\" class=\"mnDerPre\">$ " + vlFrm + "</td> \n";
					tbPrec 		+= "		</tr> \n";
				}
				tbPrec 		+= "	</tbody> \n";
				tbPrec		+= "</table> \n";
				
				preDeta.innerHTML = tbPrec;
				
				liEl.appendChild( preDeta );
				
				ulEl.appendChild(liEl);
			}
			
		}
		
		var capaElMenu = document.createElement("div");
		capaElMenu.setAttribute("class", "elMenuItem");
		capaElMenu.appendChild(ulEl);

		var capaElMenuSc = document.createElement("div");
		capaElMenuSc.setAttribute("class", "elMenuItemScroll");
		
		var tbScroll  = "<table width=\"100%\" height=\"100%\"> \n";
			tbScroll += "	<tbody> \n";
			tbScroll += "		<tr> <td height=\"20%\" valign=\"top\"><div id=\"btnMenosItems\" class=\"btnMasItems\">-</div></td>  </tr> \n";
			tbScroll += "		<tr> <td height=\"*\"></td> </tr> \n";
			tbScroll += "		<tr> <td height=\"20%\" valign=\"bottom\"><div id=\"btnMasItems\" class=\"btnMasItems\">+</div></td> </tr> \n";
			tbScroll += "	</tbody> \n";
			tbScroll += "</table>";
		
		capaElMenuSc.innerHTML = tbScroll;
		
		var tbParaMenu = document.createElement("table");
		var tbodyPMenu = document.createElement("tbody");
		var trPmenu = document.createElement("tr");
		var tdVwMenu = document.createElement("td");
		var tdVwScroll = document.createElement("td");
		
		tdVwMenu.setAttribute("valign", "top");
		tdVwScroll.setAttribute("valign", "top");
		tbParaMenu.setAttribute("style", "width: 100%; display: none;");
		tbParaMenu.setAttribute("id", "tbParaMenu");
		
		
		tdVwMenu.appendChild(capaElMenu);
		tdVwScroll.appendChild(capaElMenuSc);
		
		trPmenu.appendChild(tdVwMenu);
		trPmenu.appendChild(tdVwScroll);
		tbodyPMenu.appendChild(trPmenu);
		tbParaMenu.appendChild(tbodyPMenu);
		
		
		
		var elC = document.querySelector( tdMenuCont );
		elC.innerHTML = "<h2>" + titulo + "</h2>";
		elC.appendChild(tbParaMenu);
		
		var objMas = document.querySelector( "#btnMasItems" );
		var objMenos = document.querySelector( "#btnMenosItems" );
		objMas.addEventListener("click", function( ){ bajarScrollLista( capaElMenu, null, "+=174" ); }, false);
		objMenos.addEventListener("click", function( ){ bajarScrollLista( capaElMenu, null, "-=174" ); }, false);
		
		var tbJqEff = jQuery( tbParaMenu );
		tbJqEff.fadeIn("slow");
		
	};
	
	var plantilla = function(){
		
		var htmlTb = "<div> \n";
		htmlTb  = "	<table class=\"yabtbmenu\"> \n";
		htmlTb += "		<tbody> \n";
		htmlTb += "			<tr> \n";
		htmlTb += "				<td class=\"" + izq + "\" valign=\"top\"></td> \n";
		htmlTb += "				<td class=\"" + conte + "\" valign=\"top\"></td> \n";
		htmlTb += "				<td class=\"" + car + "\" valign=\"top\"><div style=\"width: 270px;\">parte der</div></td> \n";
		htmlTb += "			</tr> \n";
		htmlTb += "		</tbody> \n";
		htmlTb += "	</table> \n";
		htmlTb += "	</div> \n";
		
		return htmlTb;
	};
	
	this.Iniciar = function(){
		if( este.Contenedor != "" ){
			var objMain = jQuery( este.Contenedor );
			objMain.html( plantilla() );
			
			crearTitulos();
		}
	};
	
	var QuoteToHex = function(txt){
		if(txt != null){
			var vocales = ["&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;"];
			var nwVocales = ["\xE1","\xE9","\xED","\xF3","\xFA","\xC0","\xC9","\xCD","\xD3","\xDA"];
			
			var find = vocales;
			var replace = nwVocales;
			var replaceString = txt;
			var regex; 
			for (var i = 0; i < find.length; i++) {
				regex = new RegExp(find[i], "g");
			    replaceString = replaceString.replace(regex, replace[i]);
			}
			return replaceString;
		}else{
			return txt;
		}
	};
	
};