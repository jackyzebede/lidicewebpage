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

$(document).ready(function()
{
	$("#liquidation-record-form").submit(function(event){
		//event.preventDefault();
		var DataToSubmit = [];
		$("tr.row-with-liq-res").each(function(){
			DataToSubmit.push({
				proveedores_id: $(this).find('.proved-id').text(),
				cantbulto: $(this).find('.cantbultoval').text(),
				arancel_id: $(this).find('.arancelid').text(),
				tipocodigo_id: $(this).find('.tipocodigoidval').text(),
				entero: $(this).find('.enteroval').text(),
				valor: $(this).find('.valorval').text()
			});
		});
		$("#data_to_process").val(JSON.stringify(DataToSubmit));
		return true;
	});

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
	$("#arancel").on("keydown",function(event)
	{
		if (event.which == 13)
		{
			event.preventDefault();
			$("#arancel").val($('#box-arancel-vals p.activeselection').text());
			$("#descripciyon").val(SearchNombre(Arancels, $("#arancel").val()));
			$('#box-arancel-vals').remove();
			$('#tipocodigo').focus();
			return false;
		}
		else if (event.which == 40)
		{
			event.preventDefault();
			if ($('#box-arancel-vals p.activeselection').next("p").length)
			{
				$('#box-arancel-vals p.activeselection')
						.removeClass("activeselection")
						.next("p").addClass("activeselection");
			}
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
			return false;
		}
		return true;
	});

	$("#arancel").on("keyup",function(event)
	{
		if (event.which != 13 && event.which != 38 && event.which != 40)
		{
			$('#box-arancel-vals').remove();
			var data = SearchData(Arancels, $(this).val());
			if (data.length)
			{
				var output = "<div id='box-arancel-vals'>";
				var isfirst = true;
				$.each(data, function(key, val){
					output += "<p";
					if (isfirst)
					{
						output += " class='activeselection'";
						isfirst = false;
					}
					output += "><span class='arancel-code'>"+val.code+"</span></p>";
				});
				output += "</div>";
				$(this).after(output);
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
