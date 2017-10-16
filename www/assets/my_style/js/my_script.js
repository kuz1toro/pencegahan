// animsition
$(document).ready(function() {
        $('.animsition').animsition({
            inClass             : 'fade-in',
            outClass            : 'fade-out',
            inDuration          : 400,
            outDuration         : 200,
            linkElement         : 'a[href]:not([target="_blank"]):not([href^="mailto\\:"]):not([href^="\\#"])',
            loading             : true,
            loadingParentElement: 'body',
            loadingClass        : 'animsition-loading',
            unSupportCss        : ['animation-duration', '-webkit-animation-duration', '-o-animation-duration'],
            overlay             : false,
            overlayClass        : 'animsition-overlay-slide',
            overlayParentElement: 'body'
        });

				// jquery form validation
				$("#myForm").validate();

        // jquery datatable
        $('#fixheader1').DataTable( {
          "scrollY": 300,
          "scrollX": true
        } );
				$('#fixheader2').DataTable( {
          "scrollY": 300,
          "scrollX": true
        } );

});

// bootstrap-datepicker
$(function(){
	window.prettyPrint && prettyPrint();
	$('#Datepicker').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker1').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker2').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker3').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker4').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker5').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
	$('#Datepicker6').datepicker({
		format: "dd-MM-yyyy",
		todayBtn: "linked",
		autoclose: true,
		todayHighlight: true
	});
});

// kecamatan kelurahan dropdown
function selectKec(wil_id){
	if(wil_id!="-1"){
		loadData('kecamatan',wil_id);
		$("#kelurahan_dropdown").html("<option value='-1'>Pilih Kelurahan</option>");
	}else{
		$("#kecamatan_dropdown").html("<option value='-1'>Pilih Kecamatan</option>");
		$("#kelurahan_dropdown").html("<option value='-1'>Pilih Kelurahan</option>");
	}
}
function selectKel(kec_id){
	if(kec_id!="-1"){
		loadData('kelurahan',kec_id);
	}else{
		$("#kelurahan_dropdown").html("<option value='-1'>Pilih Kelurahan</option>");
	}
}
function loadData(loadType,loadId){
	var dataString = 'loadType='+ loadType +'&loadId='+ loadId;
	$.ajax({
		type: "POST",
		url: base_url + "pelengkap/loaddata",
		data: dataString,
		cache: false,
		success: function(result){
			if (loadType=="kodepos"){
				$("#"+loadType+"_dropdown").val($.trim(result));
			}else{
				$("#"+loadType+"_dropdown").html("<option value='-1'>Pilih "+loadType+"</option>");
				$("#"+loadType+"_dropdown").append(result);
			}
		}
	});
}
function showKodepos(kel_id){
	if(kel_id!="-1"){
		loadData('kodepos',kel_id);
	}else{
		$("#kodepos_dropdown").val("tidak diketahui");
	}
}

//iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass: 'iradio_minimal-blue'
    });

//bootstrap-confirmation
		$('[data-toggle=confirmation]').confirmation({
		  rootSelector: '[data-toggle=confirmation]',
		  // other options
		});

// pilih kainspeksi
function selectKaInsp(val){
  if(val=="pokja 1"){
    $("#KaInsp").val("Udiyono");
  }else if (val=="pokja 2"){
    $("#KaInsp").val("Bambang Andanawari, SST");
  }else if (val=="pokja 3"){
    $("#KaInsp").val("Sidik, S.T.");
  }else if (val=="pokja 4"){
    $("#KaInsp").val("Miyanto, S.E.");
  }else if (val=="pokja 5"){
    $("#KaInsp").val("Suparman");
  }else{
    $("#KaInsp").val("?");
  }
}
