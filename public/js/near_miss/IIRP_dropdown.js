$(() => {


	/*// Multi-Select Initialize*/
	$('#rootcauses').multiselect();
	$('#dd3').multiselect();
	$('#ddd3').multiselect();

	$('#preventiveactions').multiselect();
	$('#dd4').multiselect();


	/*// jQuery methods go here...*/
	 


	/*{{-- For fetching Sub dropdown
	============================================ --}}*/
	$(".drop").change(function () {
		var e = $(".drop:focus").val();
		var atr = $(".drop:focus").attr("myid");


		if (Array.isArray(e)) {
			for (i = 0; i < e.length; i++) {

				subajaxmulti(e[i], atr, i);
			}
		} else {
			subajax(e, atr)
		}


	})

	$("#preventiveactions").change(function () {
		var e = $("#preventiveactions").val();
		var atr = $("#preventiveactions").attr("myid");


		if (Array.isArray(e)) {
			for (i = 0; i < e.length; i++) {

				subajaxmulti(e[i], atr, i);
			}
		} else {
			subajax(e, atr)
		}
		setInterval(function () {
			$('#dd4').multiselect('rebuild');
		}, 2000);

	})

	$("#rootcauses").change(function () {
		var e = $("#rootcauses").val();
		var atr = $("#rootcauses").attr("myid");


		if (Array.isArray(e)) {
			for (i = 0; i < e.length; i++) {

				subajaxmulti(e[i], atr, i);
			}
		} else {
			subajax(e, atr)
		}
		setInterval(function () {
			$('#dd3').multiselect('rebuild');
		}, 2000);

	})


	/* {{-- For fetching Ter dropdown
	 ============================================== --}}*/
	$(".droptwo").change(function () {
		var e = $(".droptwo:focus").val();
		var atr = $(".droptwo:focus").attr("myidtwo");

		if (Array.isArray(e)) {
			for (i = 0; i < e.length; i++) {

				terajaxmulti(e[i], atr, i);
			}
		} else {
			terajax(e, atr)
		}

	})


	$("#dd3").change(function () {
		var e = $("#dd3").val();
		var atr = $("#dd3").attr("myidtwo");

		if (Array.isArray(e)) {
			for (i = 0; i < e.length; i++) {

				terajaxmulti(e[i], atr, i);
			}
		} else {
			terajax(e, atr)
		}
		setInterval(function () {
			$('#ddd3').multiselect('rebuild');
		}, 2000);
	})


});


/*
{{--  helper  --}}

{{--  ------------------------- -------- -------------------------------------  --}}
{{--  ------------------------- Sub ajax -------------------------------------  --}}
{{--  ------------------------- -------- -------------------------------------  --}}
*/
function subajax(d, atr) {
	$.ajax({
		type: 'POST',
		url: "/api/subtype",
		data: {
			'id': d
		},
		success: function (result) {

			let output = ""
			if (result.length < 1) {
				$("#display_" + atr).css("cssText", "display: none !important;");
				$("#display_d" + atr).css("cssText", "display: none !important;");
				$("#" + atr).html("");
				$("#d" + atr).html("");
			} else {
				for (let i = 0; i < result.length; i++) {
					output += "<option value=" + result[i].id + ">" + result[i].type_sub_name + "</option>";
				}
				$("#display_" + atr).css("cssText", "display: block !important;");
			}

			document.getElementById(atr).innerHTML += output


		}
	});
}

function subajaxmulti(d, atr, c) {
	$.ajax({
		type: 'POST',
		url: "/api/subtype",
		data: {
			'id': d
		},
		success: function (result) {

			let output = ""
			if (result.length < 1) {
				$("#display_" + atr).css("cssText", "display: none !important;");
				$("#display_d" + atr).css("cssText", "display: none !important;");
				$("#" + atr).html("");
				$("#d" + atr).html("");
			} else {
				for (let i = 0; i < result.length; i++) {
					output += "<option value=" + result[i].id + ">" + result[i].type_sub_name + "</option>";
				}
				$("#display_" + atr).css("cssText", "display: block !important;");
			}

			if (c == 0) {
				document.getElementById(atr).innerHTML = output;
			} else {
				document.getElementById(atr).innerHTML += output;
			}

		}
	});
}
/*
{{--  --------------------- -------- ---------------------  --}}
{{--  --------------------- Ter ajax ---------------------  --}}
{{--  --------------------- -------- ---------------------  --}}
*/
function terajax(f, atr) {
	$.ajax({
		type: 'POST',
		url: "/api/tertype",
		data: {
			'id': f
		},
		success: function (result) {
			let output = ""
			if (result.length < 1) {
				$("#display_" + atr).css("cssText", "display: none !important;");
				$("#" + atr).html("");
			} else {
				for (let i = 0; i < result.length; i++) {
					output += "<option value=" + result[i].id + ">" + result[i].type_ter_name + "</option>";
				}
				$("#display_" + atr).css("cssText", "display: block !important;");;
			}
			document.getElementById(atr).innerHTML += output;

		}
	});
}

function terajaxmulti(f, atr, c) {
	$.ajax({
		type: 'POST',
		url: "/api/tertype",
		data: {
			'id': f
		},
		success: function (result) {

			let output = ""
			if (result.length < 1) {
				$("#display_" + atr).css("cssText", "display: none !important;");
				$("#" + atr).html("");
			} else {
				for (let i = 0; i < result.length; i++) {
					output += "<option value=" + result[i].id + ">" + result[i].type_ter_name + "</option>";
				}
				$("#display_" + atr).css("cssText", "display: block !important;");;
			}

			if (c == 0) {
				document.getElementById(atr).innerHTML = output;
			} else {
				document.getElementById(atr).innerHTML += output;
			}

		}
	});
}

/* {{--  --------------------- Ter ajax ---------------------  --}} */