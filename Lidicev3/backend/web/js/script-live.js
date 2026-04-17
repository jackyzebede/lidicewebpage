function SearchData(arr, searching)
{
	var FoundData = [];
	$.each(arr, function(key, val){
		if ((""+val.code).indexOf(searching) !== -1)
		{
			FoundData.push(val);
		}
	});
	return FoundData;
}
function SearchNombre(arr, searching)
{
	var FoundRes = "";

	$.each(arr, function(key, val){
		if (val.code == searching)
		{
			FoundRes = val.nombre;
			return false;
		}
	});
	return FoundRes;
}
function SearchId(arr, searching)
{
	var FoundRes = "";

	$.each(arr, function(key, val){
		if (val.code == searching)
		{
			FoundRes = val.id;
			return false;
		}
	});
	return FoundRes;
}

//----------------added by amir---------------
function GetArancelRow(arr, searching)
{
	var FoundRes = "";

	$.each(arr, function(key, val){
		if (val.code == searching)
		{
			FoundRes = val;
			return false;
		}
	});
	return FoundRes;
}
//----------------added end by amir-----------

$(document).ready(function()
{
	$("#liquidation-record-form").submit(function(event){
		//event.preventDefault();
		$('.savingdata').attr("disabled",true);
		var DataToSubmit = [];
		$(".dynamic_row_table tr.calc_tr").each(function(){

			if ($(this).find('.arancelid').val() > 0) {

				if ($(this).find('.descripciyon').val() != $(this).find('.descripciyon_old').val()) {
					var descripciyon_new = $(this).find('.descripciyon').val();
				}

				DataToSubmit.push({
					arancel_id: $(this).find('.arancelid').val(),
					arancel: $(this).find('.arancel').val(),
					//tipocodigo_id: $(this).find('#tipodnew').val(),
					tipocodigo_id: $(this).find('.tipodnew').val(),
					canreal: $(this).find('.canreal').val(),
					crf: $(this).find('.crf').val(),
					fob: $(this).find('.fob').val(),
					cif: $(this).find('.cif').val(),
					descripciyon: descripciyon_new
					//,
					//bultos: $(this).find('.bultos').val()
				});

			}
		});
		$("#data_to_process").val(JSON.stringify(DataToSubmit));
		//alert($("#data_to_process").val());
		//return false;
		return true;
	});

	// $("#liquidation-record-form").submit(function(event){
	// 	//event.preventDefault();
	// 	var DataToSubmit = [];
	// 	$("tr.row-with-liq-res").each(function(){
	// 		DataToSubmit.push({
	// 			proveedores_id: $(this).find('.proved-id').text(),
	// 			cantbulto: $(this).find('.cantbultoval').text(),
	// 			arancel_id: $(this).find('.arancelid').text(),
	// 			tipocodigo_id: $(this).find('.tipocodigoidval').text(),
	// 			entero: $(this).find('.enteroval').text(),
	// 			valor: $(this).find('.valorval').text()
	// 		});
	// 	});
	// 	$("#data_to_process").val(JSON.stringify(DataToSubmit));
	// 	return true;
	// });

	$("#cantbulto").on("keydown", function(event){
		if (event.which == 13)
		{
			event.preventDefault();
			$("#arancel").focus();
		}
	});
	$("#entero").on("keydown", function(event){
		if (event.which == 13)
		{
			event.preventDefault();
			$("#valor").focus();
		}
	});

	$("#liquidation-record-form").on("click", "a.removeliqline", function(event){
		event.preventDefault();
		$(this).parent().parent().remove();
		return false;
	});

	$("#valor").on("keydown", function(event){
		if (event.which == 13)
		{
			event.preventDefault();

			$(".markedred").removeClass("markedred");

			var isok = true;
			if ($("#valor").val() == ""){$("#valor").addClass("markedred").focus();isok=false;};
			if ($("#entero").val() == ""){$("#entero").addClass("markedred").focus();isok=false;};
			if ($("#tipocodigo").val() == ""){$("#tipocodigo").addClass("markedred").focus();isok=false;};
			if ($("#arancel").val() == ""){$("#arancel").addClass("markedred").focus();isok=false;};
			if ($("#cantbulto").val() == ""){$("#cantbulto").addClass("markedred").focus();isok=false;};

			if (isok)
			{
				var html = "<tr class='row-with-liq-res'><td>";
				html += "<span class='proved-id'>"+$("#proveedores").val()+"</span>";
				html += $("#proveedores option:selected").text() + "</td>";
				html += "<td class='cantbultoval'>"+$("#cantbulto").val()+"</td>";
				html += "<td class='arancelval'>";
				html += "<span class='arancelid'>"+SearchId(Arancels, $("#arancel").val())+"</span>";
				html += $("#arancel").val() + "</td>";
				html += "<td>" + $("#descripciyon").val() + "</td>";
				html += "<td class='tipocodigoval'>";
				html += "<span class='tipocodigoidval'>"+SearchId(Tipos, $("#tipocodigo").val())+"</span>";
				html += $("#tipocodigo").val() + "</td>";
				html += "<td>" + $("#tipod").val() + "</td>";
				html += "<td class='enteroval'>" + $("#entero").val() + "</td>";
				html += "<td class='valorval'>" + $("#valor").val() + "</td>";
				html += "<td><a href='#' class='removeliqline'>REMOVE</a></td>";
				html += "</tr>";

				$("#row-with-input-data").before(html);

				$("#cantbulto").val("");
				$("#arancel").val("");
				$("#descripciyon").val("");
				$("#tipocodigo").val("");
				$("#tipod").val("");
				$("#entero").val("");
				$("#valor").val("");
				$("#cantbulto").focus();
			}
		}
	});
	//$("#arancel").on("keydown",function(event)
	//$(".arancel").on("keydown",function(event)
	$(document).on('keydown', '.arancel',function(event)
	{
		//alert('down');
		//var parentTr = (this).closest('tr');
		var parentTr = $(this).closest('tr');

		if (event.which == 13)
		{
			event.preventDefault();
			//$("#arancel").val($('#box-arancel-vals p.activeselection').text());
			//parentTr.find(".arancel").val(parentTr.find('.box-arancel-vals p.activeselection').text());
			parentTr.find(".arancel").val(parentTr.find('.box-arancel-vals p.activeselection .arancel-code').text());
			var ArancelRow = GetArancelRow(Arancels, parentTr.find(".arancel").val());
			//parentTr.find(".descripciyon").val(SearchNombre(Arancels, parentTr.find(".arancel").val()));
			parentTr.find(".descripciyon").val(ArancelRow.nombre);
			/*if (ArancelRow.nombre_simple == "") {
				parentTr.find(".descripciyon").val(ArancelRow.nombre);
			} else {
				parentTr.find(".descripciyon").val(ArancelRow.nombre_simple);
			}*/
			parentTr.find(".dia").val(ArancelRow.dia);
			parentTr.find(".itbmper").val(ArancelRow.itbm);
			parentTr.find(".iscper").val(ArancelRow.isc);
			parentTr.find('.box-arancel-vals').remove();
			parentTr.addClass("arn_"+ArancelRow.id);
			parentTr.attr("data-arn","arn_"+ArancelRow.id);
			//parentTr.find('.tipocodigo').focus();
			return false;
		}
		else if (event.which == 40)
		{
			event.preventDefault();
			//var pre_sel = $('p.activeselection').position().top;
			if ($('#box-arancel-vals p.activeselection').next("p").length)
			{
				$('#box-arancel-vals p.activeselection')
						.removeClass("activeselection")
						.next("p").addClass("activeselection");
			}
			//var after_sel = $('p.activeselection').position().top;
			//parentTr.find('.box-arancel-vals').focus({preventScroll:true});
			//parentTr.find(".arancel").focus();
			 //$('#Add_Button').click(function() {
			 	//alert(pre_sel);
			 	//alert(after_sel);

        //var scrollTop = (after_sel - pre_sel);
        //alert(scrollTop);
        var p_ind = $('#box-arancel-vals p.activeselection').index();
	        //alert(p_ind);
	        //alert(p_ind * 20);
	        $('#box-arancel-vals').scrollTop(p_ind * 40);
        //gscroll = gscroll + 20;
        //alert(gscroll);
        //$('#box-arancel-vals').scrollTop(gscroll);
    //});

			// $('#box-arancel-vals').animate({
			//     scrollTop: ($('.activeselection').offset().top)
			// },500);
			return false;
		}
		else if (event.which == 38)
		{
			event.preventDefault();
			if ($('#box-arancel-vals p.activeselection').prev("p").length)
			{
				$('#box-arancel-vals p.activeselection')
						.removeClass("activeselection")
						.prev("p").addClass("activeselection");
			}
			//var scrollTop = $('p.activeselection').offset().top;
			//alert(scrollTop);
        //$('#box-arancel-vals').scrollTop(scrollTop);
        	//gscroll = gscroll - 20;
	        //alert(gscroll);
	        var p_ind = $('#box-arancel-vals p.activeselection').index();
	        //alert(p_ind);
	        //alert(p_ind * 20);
	        //$('#box-arancel-vals').scrollTop((p_ind * 20)-20);
	        $('#box-arancel-vals').scrollTop((p_ind * 40)-40);

	        //$('#box-arancel-vals').scrollTop(gscroll);

			// $('#box-arancel-vals').animate({
			//     scrollTop: ($('.activeselection').offset().top)
			// },500);
			//parentTr.find('.box-arancel-vals').focus({preventScroll:false});
			//parentTr.find(".arancel").focus();
			return false;
		}
		return true;
	});

	//----------by amir---------------
	$(document).on('click', '.box-arancel-vals p',function(event)
	//$(document).on('click', '.box-arancel-vals .arancel-code',function(event)
		//$(document).("#box-arancel-vals").on("click",function(event)
	{
			var parentTr = $(this).closest('tr');
			event.preventDefault();
			//parentTr.find(".arancel").val($(this).text());
			parentTr.find(".arancel").val($(this).find('span.arancel-code').text());
			var ArancelRow = GetArancelRow(Arancels, parentTr.find(".arancel").val());
			//$("#descripciyon").val(SearchNombre(Arancels, $("#arancel").val()));
			parentTr.find(".arancelid").val(ArancelRow.id);
			parentTr.find(".descripciyon").val(ArancelRow.nombre);
			/*if (ArancelRow.nombre_simple == "") {
				parentTr.find(".descripciyon").val(ArancelRow.nombre);
			} else {
				parentTr.find(".descripciyon").val(ArancelRow.nombre_simple);
			}*/
			//parentTr.find(".descripciyon").val(ArancelRow.nombre);
			parentTr.find(".dia").val(ArancelRow.dia);
			parentTr.find(".itbmper").val(ArancelRow.itbm);
			parentTr.find(".iscper").val(ArancelRow.isc);
			parentTr.find('.box-arancel-vals').remove();
			parentTr.addClass("arn_"+ArancelRow.id);
			parentTr.attr("data-arn","arn_"+ArancelRow.id);
			//$('#tipocodigo').focus();
			//return false;
			return true;
	});
	//----------end by amir-----------

	//$("#arancel").on("keyup",function(event)
	//$(".arancel").on("keyup",function(event)
	$(document).on('keyup', '.arancel',function(event)
	{
		var parentTr = $(this).closest('tr');
		if (event.which != 13 && event.which != 38 && event.which != 40)
		{
			parentTr.find('.box-arancel-vals').remove();
			var data = SearchData(Arancels, $(this).val());
			if (data.length)
			{
				var output = "<div id='box-arancel-vals' class='box-arancel-vals' tabindex='-11'>";
				var isfirst = true;
				$.each(data, function(key, val){
					output += "<p";
					if (isfirst)
					{
						output += " class='activeselection'";
						isfirst = false;
					}
					output += "><span class='arancel-code'>"+val.code+"</span>";
					output += "<br><span class='arancel-description'>"+val.nombre+"</span>";
					output += "</p>";
				});
				output += "</div>";
				$(this).after(output);
				//parentTr.find('.box-arancel-vals').focus();
			}
			return true;
		}
	});


	$("#tipocodigo").on("keydown",function(event)
	{
		if (event.which == 13)
		{
			event.preventDefault();
			$("#tipocodigo").val($('#box-tipocodigo-vals p.activeselection').text());
			$("#tipod").val(SearchNombre(Tipos, $("#tipocodigo").val()));
			$('#box-tipocodigo-vals').remove();
			$('#entero').focus();
			return false;
		}
		else if (event.which == 40)
		{
			event.preventDefault();
			if ($('#box-tipocodigo-vals p.activeselection').next("p").length)
			{
				$('#box-tipocodigo-vals p.activeselection')
						.removeClass("activeselection")
						.next("p").addClass("activeselection");
			}
			return false;
		}
		else if (event.which == 38)
		{
			event.preventDefault();
			if ($('#box-tipocodigo-vals p.activeselection').prev("p").length)
			{
				$('#box-tipocodigo-vals p.activeselection')
						.removeClass("activeselection")
						.prev("p").addClass("activeselection");
			}
			return false;
		}
		return true;
	});

	$("#tipocodigo").on("keyup",function(event)
	{
		if (event.which != 13 && event.which != 38 && event.which != 40)
		{
			$('#box-tipocodigo-vals').remove();
			var data = SearchData(Tipos, $(this).val());
			if (data.length)
			{
				var output = "<div id='box-tipocodigo-vals'>";
				var isfirst = true;
				$.each(data, function(key, val){
					output += "<p";
					if (isfirst)
					{
						output += " class='activeselection'";
						isfirst = false;
					}
					output += "><span class='tipocodigo-code'>"+val.code+"</span></p>";
				});
				output += "</div>";
				$(this).after(output);
			}
			return true;
		}
	});


	function AddProveedoresLine(obj)
	{
		var select_box = obj.parent().parent().find(".new-proveedores-select");
		var doc_box = obj.parent().parent().find(".new-proveedores-doc");
		var ctns_box = obj.parent().parent().find(".new-proveedores-ctns");
		var cbm_box = obj.parent().parent().find(".new-proveedores-cbm");
		var tipo_box = obj.parent().parent().find(".new-proveedores-tipo");
		if (select_box.val() && ctns_box.val() && doc_box.val() && cbm_box.val() && tipo_box.val())
		{
			var pline = "<tr class='new-proved-data-line'><td class='proved-name'>"+select_box.val()+"</td>";
			pline += "<td class='proved-doc'>"+doc_box.val()+"</td>";
			pline += "<td class='proved-ctns'>"+ctns_box.val()+"</td>";
			pline += "<td class='proved-cbm'>"+cbm_box.val()+"</td>";
			pline += "<td class='proved-tipo'>"+tipo_box.val()+"</td>";
			pline += "<td><span class='proved-remove btn btn-primary'>Remove</span></td></tr>";
			select_box.parent().parent().parent().prepend(pline);
			select_box.val("");
			doc_box.val("");
			ctns_box.val("");
			cbm_box.val("");
			tipo_box.val("");

			var tbl = obj.parent().parent().parent();
			var total_ctns = 0;
			tbl.find('tr.new-proved-data-line').each(function(){
				total_ctns += parseInt($(this).find('td.proved-ctns').text());
			});
			tbl.find('span.totalline-ttl').text(total_ctns);
			var grand_total = total_ctns + parseInt(tbl.parent().parent().find('.totalbultosamount').text());
			tbl.find('span.totalline-gttl').text(grand_total);
		}
	}

	if ($('.forselect2').length)
	{
		$('.forselect2').select2();
	}
	if ($('#liquidation-fecha').length)
	{
		$('#liquidation-fecha').datetimepicker({
			timepicker: false,
			format: 'd-m-Y'
		});
	}

	$('#salio_date').datetimepicker();

	$(".proveedores-add-items-form").submit(function(){
		var proved_data = "";
		$("tr.new-proved-data-line").each(function(){
			proved_data += $(this).find("td.proved-name").text() +
							":::" + $(this).find("td.proved-ctns").text() +
							":::" + $(this).find("td.proved-doc").text() +
							":::" + $(this).find("td.proved-cbm").text() +
							":::" + $(this).find("td.proved-tipo").text() + "|||";
		});
		$(this).find("input.mainlist_proveedors_data").val(proved_data);
		return true;
	});

	$(".post-ctns-update-form").submit(function(){
		var ctns_data = "";
		$(this).parent().find("table.client-items-table tr.cit-dline").each(function(){
			ctns_data += $(this).find("input.post-update-itemid").val() +
					":::" + $(this).find("input.post-update-recibidos").val() +
					":::" + $(this).find("input.post-update-faltantes").val() +
					":::" + $(this).find("textarea.post-update-comments").val() + "|||";
		});
		$(this).find("input.item-ctns-data").val(ctns_data);
		return true;
	});

	$('.new-proveedores-body').on('click', '.proved-remove', function(){
		var tbl = $(this).parent().parent().parent();
		$(this).parent().parent().remove();
		var total_ctns = 0;
		tbl.find('tr.new-proved-data-line').each(function(){
			total_ctns += parseInt($(this).find('td.proved-ctns').text());
		});
		tbl.find('span.totalline-ttl').text(total_ctns);
		var grand_total = total_ctns + parseInt(tbl.parent().parent().find('.totalbultosamount').text());
		tbl.find('span.totalline-gttl').text(grand_total);
	});

	$(".new-proveedores-select").change(function(){AddProveedoresLine($(this));});
	$(".new-proveedores-doc").change(function(){AddProveedoresLine($(this));});
	$(".new-proveedores-ctns").change(function(){AddProveedoresLine($(this));});
	$(".new-proveedores-cbm").change(function(){AddProveedoresLine($(this));});
	$(".new-proveedores-tipo").change(function(){AddProveedoresLine($(this));});
	$(".new-proveedores-btn").click(function(){AddProveedoresLine($(this));});

	$('.make-ctns-split').click(function(){
		$(this).parent().find('.ctns-split-boxes').css({'visibility':'visible'});
		$(this).parent().find('.ctns-split-run').show();
		$(this).parent().find('.ctns-split-more').show();
	});
	$('.ctns-split-more').click(function(){
		$(this).parent().find('.ctns-split-boxes').append('<input type="text" class="ctns-split-box" />');
	});
	$('.ctns-split-run').click(function(){
		var split_data = "";
		$(this).parent().find('.ctns-split-boxes input').each(function(){
			split_data += $(this).val() + "|||";
		});
		$("#csafb-id").val($(this).parent().find('.ctns-split-item-element').val());
		$("#csafb-splitted").val(split_data);
		$("#ctns-split-actual-form-box form").submit();
	});

	$('#notification-btn').click(function(event){
		event.preventDefault();
		$('#notification-container').fadeOut(400);
		$('#notification-box').fadeOut(400);
		$('#notification-text').html("");
		return false;
	});
});


///-----------------new code added by amir-----------------------
//------------add all canreals----------
//var globalThisParentTr = "";
var globalThisParentTr = "";
var thiscanreal;
var thisFOB;
var thisCIF;

$(document).ready(function() {

	// $(document).on("blur",".canreal", function(){
	// 	thiscanreal = $(this);
	// 	globalThisParentTr = $(this).closest('tr');
	// 	sumcanreals();
	// 	calculateCIF();
	// 	sumCIF();
	// 	calculateIMP();
	// 	sumIMP();
	// });

	// $(document).on("keypress",".canreal", function(e){
	//     if(e.which == 13) {
	//     	thiscanreal = $(this);
	//     	globalThisParentTr = $(this).closest('tr');
	//         sumcanreals();
	//         calculateCIF();
	//         sumCIF();
	//         calculateIMP();
	//         sumIMP();
	//     }
	// });

	// $(document).on("blur",".fob", function(){
	// 	thisFOB = $(this);
	// 	globalThisParentTr = $(this).closest('tr');
	// 	sumfob();
	// 	calculateCIF();
	//         sumCIF();
	//         calculateIMP();
	//         sumIMP();
	//         calculateISC();
	//         sumISC();
	//         calculateITBM();
	//         sumITBM();
	// });

	// $(document).on("keypress",".fob", function(e){
	//     if(e.which == 13) {
	//     	thisFOB = $(this);
	//     	globalThisParentTr = $(this).closest('tr');
	//         sumfob();
	//         calculateCIF();
	//         sumCIF();
	//         calculateIMP();
	//         sumIMP();
	//         calculateISC();
	//         sumISC();
	//         calculateITBM();
	//         sumITBM();
	//     }
	//     //e.preventDefault();
	// });

	$(document).on("blur",".peso, #poso-total", function(){
		//thisFOB = $(this);
		//globalThisParentTr = $(this).closest('tr');
		calculatePESO();
	});

	$(document).on("keypress",".peso , #poso-total", function(e){
	    if(e.which == 13) {
	    	//thisFOB = $(this);
	    	//globalThisParentTr = $(this).closest('tr');
	        calculatePESO();
	    }
	    //e.preventDefault();
	});
	//-----------stop from submit on enter--------------------
	//$(window).keydown(function(event){
	$(document).on("keypress","#flete , #seg , #poso-total , .arancel , .dynamic_row_table input[type=text]", function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      return false;
	    }
	});

});

// function callfunctions(){

// }

	function sumcanreals() {
		event.preventDefault();
		var sum=0;
	    $(".canreal").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#canreal-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function sumfob() {
		event.preventDefault();
		var sum=0;
	    $(".fob").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#fob-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function calculateCIF(){
		var curFOB =  checksetval(globalThisParentTr.find('.fob').val()); // f11
		var totalFOB = checksetval($("#fob-total").val()); // f9
		var flete = checksetval($("#flete").val()); // c9
		var seg = checksetval($("#seg").val()); // d9
		 // F11+(F11/$F$9)*($C$9+$D$9)
		//var parentTr = thisFOB.closest('tr');
		var totalcif = curFOB+((curFOB/totalFOB)*(flete+seg));

		globalThisParentTr.find('.cif').val(totalcif.toFixed(2));
		//thisCIF = totalcif;

		//console.log(thiscanreal.val()); //d9
	}

	function calculateIMP(){

		var cif = checksetval(globalThisParentTr.find('.cif').val()); // g11
		var dia = (checksetval(globalThisParentTr.find('.dia').val()))/100; // c11

		globalThisParentTr.find('.imp').val(( cif*dia ).toFixed(2));


		//console.log(thiscanreal.val()); //d9
	}

	function checksetval(val) {
		if ( (isFinite(val) && parseFloat(val) == val ) === false ) {
			return 0;
		} else {
			return parseFloat(val);
		}
	}

	function sumCIF() {
		event.preventDefault();
		var sum=0;
	    $(".cif").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#cif-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function sumIMP() {
		event.preventDefault();
		var sum=0;
	    $(".imp").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#imp-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function calculateISC(){

		var cif = checksetval(globalThisParentTr.find('.cif').val()); // g11
		var imp = checksetval(globalThisParentTr.find('.imp').val()); // 
		var iscper = (checksetval(globalThisParentTr.find('.iscper').val()))/100; // 

		globalThisParentTr.find('.isc').val(( (cif+imp)*iscper ).toFixed(2));

		//console.log(thiscanreal.val()); //d9
	}

	function sumISC() {
		event.preventDefault();
		var sum=0;
	    $(".isc").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#isc-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function calculateITBM(){

		var cif = checksetval(globalThisParentTr.find('.cif').val()); // g11
		var imp = checksetval(globalThisParentTr.find('.imp').val()); //
		var isc = checksetval(globalThisParentTr.find('.isc').val()); //

		var itbmper = (checksetval(globalThisParentTr.find('.itbmper').val()))/100; // 

		globalThisParentTr.find('.itbm').val(( (cif+imp+isc)*itbmper ).toFixed(2));


		//console.log(thiscanreal.val()); //d9
	}

	function sumITBM() {
		event.preventDefault();
		var sum=0;
	    $(".itbm").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    $('#itbm-total').val(sum.toFixed(2));
	    //calculateCIF();
	    //return false;

	}

	function calculatePESO(){
//alert("fff");
		var poso_total = checksetval( $("#poso-total").val() ); //k9
		var fob_sum = checksetval( $("#fob-total").val() );
		var current_fob = checksetval( globalThisParentTr.find('.fob').val() ); //f12

		var current_peso = checksetval( current_fob / fob_sum * poso_total );
//alert(poso_total+peso_sum);
//$('.peso_first').val("123");
		globalThisParentTr.find('.peso').val(current_peso.toFixed(2));

	}

	function sumPESO() {
		event.preventDefault();
		var sum=0;
	    $(".peso").each(function(){
	        if($(this).val() != "")
	          sum += parseFloat($(this).val());
	    });

	    //$('#itbm-total').val(sum.toFixed(2));
	    //calculateCIF();
	    return sum;

	}


//--------------combine duplicates------------------------

function findDuplicate(){
      //var result = 0;
      $(".dynamic_row_table .calc_tr").each(function () {
      		var current_cls = "."+$(this).data("arn");
      		var current_same = $(current_cls).length;
      		if (current_same > 1) {
      			var sum_canreal = sumsame(current_cls+" .canreal");
      			var dataSec = $("[data-secSameInput]");
      			var nextTextboxCls = dataSec.attr("data-secSameInput");
      			//find class of next input
      			//var myIndex = $(current_cls+" .canreal").index('input:text');
        		//var nextTextboxCls = $("table :text:eq(" + (myIndex + 1) + ")").attr("class");
        		//alert(nextTextboxCls);
      			//var sum_canreal = sumsame(current_cls+" .fob");
      			var sum_canreal = sumsame(current_cls+" ."+nextTextboxCls);
      			$(".dynamic_row_table tr"+current_cls+":not(:first)").remove();
      		}
      });
      //return result;
}

function sumsame(selector){
	var sum = 0;
	$(selector).each(function()
	{
	    sum += parseFloat($(this).val());
	});
	if (sum > 0) {
		$(".dynamic_row_table "+selector+":first").val(sum);
	}
}

		// $("#calculatesheet").click(function(){
		// 	//alert('asdf');
		// 	sumcanreals();
		// 	sumfob();

		// 	$("tr.calc_tr").each(function(){
		// 		globalThisParentTr = $(this);
		// 		calculateCIF();
	 //     	});

	 //     	sumCIF();

	 //     	$("tr.calc_tr").each(function(){
		// 		globalThisParentTr = $(this);
		// 		calculateIMP();
	 //     	});

	 //     	sumIMP();

	 //     	$("tr.calc_tr").each(function(){
		// 		globalThisParentTr = $(this);
		// 		calculateISC();
	 //     	});

	 //     	sumISC();

	 //     	$("tr.calc_tr").each(function(){
		// 		globalThisParentTr = $(this);
		// 		calculateITBM();
	 //     	});

	 //     	sumITBM();

	 //     	$("tr.calc_tr").each(function(){
		// 		globalThisParentTr = $(this);
		// 		calculatePESO();
	 //     	});
		// });