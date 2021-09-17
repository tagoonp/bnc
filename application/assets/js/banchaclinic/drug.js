/*=========================================================================================
    File Name: datatables-basic.js
    Description: Basic Datatable
    ----------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function() {

    /****************************************
    *       js of zero configuration        *
    ****************************************/

    $('.zero-configuration').DataTable();

    /********************************************
     *        js of Order by the grouping        *
     ********************************************/

    var groupingTable = $('.row-grouping').DataTable({
        "columnDefs": [{
            "visible": false,
            "targets": 2
        }],
        "order": [
            [2, 'asc']
        ],
        "displayLength": 10,
        "drawCallback": function(settings) {
            var api = this.api();
            var rows = api.rows({
                page: 'current'
            }).nodes();
            var last = null;

            api.column(2, {
                page: 'current'
            }).data().each(function(group, i) {
                if (last !== group) {
                    $(rows).eq(i).before(
                        '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                    );

                    last = group;
                }
            });
        }
    });

    $('.row-grouping tbody').on('click', 'tr.group', function() {
        var currentOrder = groupingTable.order()[0];
        if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
            groupingTable.order([2, 'desc']).draw();
        }
        else {
            groupingTable.order([2, 'asc']).draw();
        }
    });

    /*************************************
    *       js of complex headers        *
    *************************************/

    $('.complex-headers').DataTable();


    /*****************************
    *       js of Add Row        *
    ******************************/

    var t = $('.add-rows').DataTable();
    var counter = 2;

    $('#addRow').on( 'click', function () {
        t.row.add( [
            counter +'.1',
            counter +'.2',
            counter +'.3',
            counter +'.4',
            counter +'.5'
        ] ).draw( false );

        counter++;
    });


    /**************************************************************
    * js of Tab for COLUMN SELECTORS WITH EXPORT AND PRINT OPTIONS *
    ***************************************************************/

    $('.dataex-html5-selectors').DataTable( {
        "order": [[ 1, "asc" ]],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible'
                }
            }
        ]
    });

    $('.dataex-html5-selectors2').DataTable( {
        "order": [[ 1, "asc" ]],
        "pageLength": 5
    });

    /**************************************************
    *       js of scroll horizontal & vertical        *
    **************************************************/

    $('.scroll-horizontal-vertical').DataTable( {
        "scrollY": 200,
        "scrollX": true
    });
});

$(function(){

    $('#txtNewQ').keyup(function(){
        if($('#txtNewQ').val() == ''){
           $('#txtNewTotal').val($('#txtDrugQ').val()) 
        }else{
            $x = parseFloat($('#txtDrugQ').val()) + parseFloat($('#txtNewQ').val())
            $('#txtNewTotal').val($x) 
        }
    })

    $('#txtNewQ').on('keypress',function(e) {
        $('#txtNewQ').removeClass('is-invalid')
        if(e.which == 13) {
            // $('#txtfTotal').focus()
            $('#btnSaveStock').trigger('click')
        }
    });

    $('#txtNewTotalu').on('keypress',function(e) {
        $('#txtNewTotalu').removeClass('is-invalid')
        if(e.which == 13) {
            $('#btnSaveStocku').trigger('click')
        }
    });

    $('#txtOtheritem').on('keypress',function(e) {
        $('#txtOtheritem').removeClass('is-invalid')
        if(e.which == 13) {
            $('#txtOthercost').focus()
        }
    });

    $('#txtOthercost').on('keypress',function(e) {
        $('#txtOthercost').removeClass('is-invalid')
        if(e.which == 13) {
            saveOterDrug()
        }
    });

    

    $('#txtfDf').keyup(function(){
        if($('#txtfDf').val() == ''){
            $('#txtfTotal').val($('#txtfPrice').val())
        }else{
            $x = parseFloat($('#txtfPrice').val()) + parseFloat($('#txtfDf').val())
            $('#txtfTotal').val($x)
        }
    })

    $('#txtfDf').on('keypress',function(e) {
        if(e.which == 13) {
            $('#txtfTotal').focus()
        }
    });

    $('#drugForm').submit(function(){
        checkDrugFrom()
    })

    $('#newdrugForm').submit(function(){
        checknewDrugFrom()
    })

    $('#txtDrugUnit').keyup(function(){
        $unit = $('#txtDrugUnit').val()
        $price = $('#txtDrugPrice').val()
        $('#txtSumprice').val($unit * $price)
    })

    $('#txtqDrugUnit').keyup(function(){
        $unit = $('#txtqDrugUnit').val()
        $price = $('#txtqDrugPrice').val()
        $('#txtqSumprice').val($unit * $price)
    })

    $('#newdruflistForm').submit(function(){
        addDruglist()
    })

    $('#newdruflistForm2').submit(function(){
        addDruglist2()
    })

    $('#newdruflistFormU').submit(function(){
        addDruglistUpdate()
    })

    $('#newdruflistFormU2').submit(function(){
        addDruglistUpdate2()
    })

    $('#newdruflistFormQ').submit(function(){
        addDruglistQuick()
    })

    $('#newdruflistFormQ2').submit(function(){
        addDruglistQuick2()
    })

    $('#txtuDrugUnit').keyup(function(){
        $unit = $('#txtuDrugUnit').val()
        $price = $('#txtuDrugPrice').val()
        $('#txtuSumprice').val($unit * $price)
    })

    $('#txtqDrugId').keyup(function(){
        $str = $('#txtqDrugId').val()
        console.log($str.length);
        if($str.length == 3){

            var jst = $.post(authen_api + 'drug.php?stage=info', { id: $('#txtqDrugId').val(), by: 'did' }, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                        $('#txtqDid').val(snap.data.ID)
                        $('#txtqDrugTrade').val(snap.data.dname)
                        $('#txtqDrugGeneric').val(snap.data.dcname)
                        $('#txtqDrugDose').val(snap.data.ddose)
                        $('#txtqDrugCost').val(snap.data.dcost)
                        $('#txtqDrugPrice').val(snap.data.dprice)
                   }else{
                    preload.hide()
                    Swal.fire(
                        {
                          icon: "error",
                          title: 'ไม่พบข้อมูล!',
                          text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                          confirmButtonClass: 'btn btn-danger',
                        }
                      )
                   }
               })

            
        }
    })

    
})

function finishServiceWait(){
    $check = 0
    $('.form-control').removeClass('is-invalid')

    if($('#txtSertype').val() == ''){
        $check++;
        $('#txtSertype').addClass('is-invalid')
        $('#txtSertype').focus();
    }

    if($('#txtfTotal_real').val() == ''){
        $check++;
        $('#txtfTotal_real').addClass('is-invalid')
        $('#txtfTotal_real').focus();
    }

    if($('#txtfTotal').val() == ''){
        $check++;
        $('#txtfTotal').addClass('is-invalid')
        $('#txtfTotal').focus();
    }

    if($('#txtfDf').val() == ''){
        $check++;
        $('#txtfDf').addClass('is-invalid')
        $('#txtfDf').focus();
    }

    if($('#txtfPrice').val() == ''){
        $check++;
        $('#txtfPrice').addClass('is-invalid')
        $('#txtfPrice').focus();
    }

    

    if($check != 0){ return ; }

    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: "ท่านต้องการจบกระบวนการรักษาและคิดเงินหรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'กลับไปตรวจสอบ',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            var param = {
                seq: $('#txtfSeq').val(),
                patient_id: $('#txtfPid').val(),
                fcost: $('#txtfCose').val(),
                fprice: $('#txtfPrice').val(),
                ftotal: $('#txtfTotal').val(),
                df: $('#txtfDf').val(),
                ptype: $('#txtPtype').val(),
                stype: $('#txtSertype').val(),
                rprice: $('#txtfTotal_real').val(),
                dnote: quill.root.innerHTML
            }
            preload.show();
            var jst = $.post(authen_api + 'drug.php?stage=finishservicewait', param, function(){}, 'json')
                       .always(function(snap){
                           console.log(snap);
                            if(snap.status == 'Success'){
                                setTimeout(() => {
                                    preload.hide()
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: "กดปุ่ม 'กลับหน้าหลัก' เพื่อแสดงรายการรอดำเนินการชำระเงิน",
                                        icon: 'success',
                                        showCancelButton: false,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'จบรายการ',
                                        cancelButtonText: 'กลับหน้าหลัก',
                                        confirmButtonClass: 'btn btn-success mr-1',
                                        cancelButtonClass: 'btn btn-secondary',
                                        buttonsStyling: false,
                                    }).then(function (result) {
                                        if (result.value) {
                                            window.location = './app-cashing.php'
                                        }
                                        // else{
                                        //     window.location = './app-appointment.php?patient_id=' + $('#txtfPid').val()
                                        // }
                                    })
                                }, 1000)
                            }else{
                                preload.hide()
                            }
                       })
        }
    })
}

function finishService(){
    $check = 0
    $('.form-control').removeClass('is-invalid')

    if($('#txtSertype').val() == ''){
        $check++;
        $('#txtSertype').addClass('is-invalid')
        $('#txtSertype').focus();
    }

    if($('#txtfTotal_real').val() == ''){
        $check++;
        $('#txtfTotal_real').addClass('is-invalid')
        $('#txtfTotal_real').focus();
    }

    if($('#txtfTotal').val() == ''){
        $check++;
        $('#txtfTotal').addClass('is-invalid')
        $('#txtfTotal').focus();
    }

    if($('#txtfDf').val() == ''){
        $check++;
        $('#txtfDf').addClass('is-invalid')
        $('#txtfDf').focus();
    }

    if($('#txtfPrice').val() == ''){
        $check++;
        $('#txtfPrice').addClass('is-invalid')
        $('#txtfPrice').focus();
    }

    

    if($check != 0){ return ; }

    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: "ท่านต้องการจบกระบวนการรักษาและคิดเงินหรือไม่",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'กลับไปตรวจสอบ',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            var param = {
                seq: $('#txtfSeq').val(),
                patient_id: $('#txtfPid').val(),
                fcost: $('#txtfCose').val(),
                fprice: $('#txtfPrice').val(),
                ftotal: $('#txtfTotal').val(),
                df: $('#txtfDf').val(),
                ptype: $('#txtPtype').val(),
                stype: $('#txtSertype').val(),
                rprice: $('#txtfTotal_real').val(),
                dnote: quill.root.innerHTML
            }
            // console.log(param);
            // return ;
            preload.show();
            var jst = $.post(authen_api + 'drug.php?stage=finishservice', param, function(){}, 'json')
                       .always(function(snap){
                           console.log(snap);
                            if(snap.status == 'Success'){
                                setTimeout(() => {
                                    preload.hide()
                                    Swal.fire({
                                        title: 'สำเร็จ',
                                        text: "กดปุ่ม 'เพิ่มนัด' เพื่อทำการนัดหมายครั้งถัดไป หรือ 'จบรายการ' เพื่อกลับสู่หน้าหลัก",
                                        icon: 'success',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'จบรายการ',
                                        cancelButtonText: 'เพิ่มนัด',
                                        confirmButtonClass: 'btn btn-success mr-1',
                                        cancelButtonClass: 'btn btn-secondary',
                                        buttonsStyling: false,
                                    }).then(function (result) {
                                        if (result.value) {
                                            window.location = './app-cashing.php'
                                        }else{
                                            window.location = './app-viewrecord.php?patient_id=' + $('#txtfPid').val()
                                        }
                                    })
                                }, 1000)
                            }else{
                                preload.hide()
                            }
                       })
        }
    })

}

function saveOterDrug(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtOthercost').val() == ''){
        $('#txtOthercost').addClass('is-invalid')
        $('#txtOthercost').focus()
        $check++;
    }

    if($('#txtOtheritem').val() == ''){
        $('#txtOtheritem').addClass('is-invalid')
        $('#txtOtheritem').focus()
        $check++;
    }

    if($check != 0){
        return ;
    }

    var param = {
        otherItem: $('#txtOtheritem').val(), 
        otherCost: $('#txtOthercost').val(),
        patient_id: $('#txtfPid').val()
    }

    preload.show();
    var jst = $.post(authen_api + 'drug.php?stage=saveOther', param, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                    preload.hide()
                    if(snap.status == 'Success'){
                        $("#modalAddOther").modal('hide')
                        getDruglist()
                        $('#txtOtheritem').val('')
                        $('#txtOthercost').val('')
                    }else{

                    }
              })
}

function resetOtherForm(){
    $('.form-control').removeClass('is-invalid')
    $('#txtOthercost').val('')
    $('#txtOtheritem').val('')
}

function addDruglistUpdate(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtuDrugUnit').val() == ''){
        $('#txtuDrugUnit').addClass('is-invalid')
        $('#txtuDrugUnit').focus()
        return ;
    }
    var param = {
        patient_id: $('#txtuPid').val(),
        drug_id: $('#txtuDid').val(),
        ref_drug_id: $('#txtuDrugId').val(),
        drug_name: $('#txtuDrugTrade').val(),
        drug_price: $('#txtuDrugPrice').val(),
        drug_qty: $('#txtuDrugUnit').val(),
        drug_cost: $('#txtuDrugCost').val(),
        drug_sum: $('#txtuSumprice').val()
    }

    console.log(param);
    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist', param, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                       getDruglist()
                       $('#txtuDid').val('')
                       $('#txtuDrugId').val('')
                       $('#txtuDrugTrade').val('')
                       $('#txtuDrugPrice').val('')
                       $('#txtuDrugCost').val('')
                       $('#txtuSumprice').val('')
                       $('#txtuDrugUnit').val('')
                       $('#modalMedPHRUpdate').modal('hide')
                   }else{
                        Swal.fire(
                            {
                            icon: "error",
                            title: 'ไม่พบข้อมูล!',
                            text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                            confirmButtonClass: 'btn btn-danger',
                            }
                        )
                   }
               })
}

function addDruglistUpdate2(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtuDrugUnit').val() == ''){
        $('#txtuDrugUnit').addClass('is-invalid')
        $('#txtuDrugUnit').focus()
        return ;
    }
    var param = {
        patient_id: $('#txtuPid').val(),
        drug_id: $('#txtuDid').val(),
        ref_drug_id: $('#txtuDrugId').val(),
        drug_name: $('#txtuDrugTrade').val(),
        drug_price: $('#txtuDrugPrice').val(),
        drug_qty: $('#txtuDrugUnit').val(),
        drug_cost: $('#txtuDrugCost').val(),
        drug_sum: $('#txtuSumprice').val(),
        service_seq: $('#txtSeq').val()
    }

    console.log(param);
    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist2', param, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                       getDruglist()
                       $('#txtuDid').val('')
                       $('#txtuDrugId').val('')
                       $('#txtuDrugTrade').val('')
                       $('#txtuDrugPrice').val('')
                       $('#txtuDrugCost').val('')
                       $('#txtuSumprice').val('')
                       $('#txtuDrugUnit').val('')
                       $('#modalMedPHRUpdate').modal('hide')
                   }else{
                        Swal.fire(
                            {
                            icon: "error",
                            title: 'ไม่พบข้อมูล!',
                            text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                            confirmButtonClass: 'btn btn-danger',
                            }
                        )
                   }
               })
}

function addDruglistQuick(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtqDrugUnit').val() == ''){
        $('#txtqDrugUnit').addClass('is-invalid')
        $('#txtqDrugUnit').focus()
        return ;
    }
    var param = {
        patient_id: $('#txtqPid').val(),
        drug_id: $('#txtqDid').val(),
        ref_drug_id: $('#txtqDrugId').val(),
        drug_name: $('#txtqDrugTrade').val(),
        drug_price: $('#txtqDrugPrice').val(),
        drug_qty: $('#txtqDrugUnit').val(),
        drug_cost: $('#txtqDrugCost').val(),
        drug_sum: $('#txtqSumprice').val()
    }
    // console.log(param);
    // return ;
    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist', param, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                   preload.hide()
                   if(snap.status == 'Success'){
                       getDruglist()
                       $('#txtqDid').val('')
                       $('#txtqDrugId').val('')
                       $('#txtqDrugTrade').val('')
                       $('#txtqDrugPrice').val('')
                       $('#txtqDrugCost').val('')
                       $('#txtqSumprice').val('')
                       $('#txtqDrugUnit').val('')
                       setTimeout(() => { $('#txtqDrugId').focus() }, 400)
                   }else{

                   }
               })

}

function addDruglistQuick2(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtqDrugUnit').val() == ''){
        $('#txtqDrugUnit').addClass('is-invalid')
        $('#txtqDrugUnit').focus()
        return ;
    }
    var param = {
        patient_id: $('#txtqPid').val(),
        drug_id: $('#txtqDid').val(),
        ref_drug_id: $('#txtqDrugId').val(),
        drug_name: $('#txtqDrugTrade').val(),
        drug_price: $('#txtqDrugPrice').val(),
        drug_qty: $('#txtqDrugUnit').val(),
        drug_cost: $('#txtqDrugCost').val(),
        drug_sum: $('#txtqSumprice').val(),
        service_seq: $('#txtSeq').val()
    }
    // console.log(param);
    // return ;
    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist2', param, function(){}, 'json')
               .always(function(snap){
                //    console.log(snap);
                //    return ;
                   preload.hide()
                   if(snap.status == 'Success'){
                       getDruglist()
                       $('#txtqDid').val('')
                       $('#txtqDrugId').val('')
                       $('#txtqDrugTrade').val('')
                       $('#txtqDrugPrice').val('')
                       $('#txtqDrugCost').val('')
                       $('#txtqSumprice').val('')
                       $('#txtqDrugUnit').val('')
                       setTimeout(() => { $('#txtqDrugId').focus() }, 400)
                   }else{

                   }
               })

}

function addDruglist(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtDrugUnit').val() == ''){
        $('#txtDrugUnit').addClass('is-invalid')
        return ;
    }
    var param = {
        patient_id: $('#txtPid').val(),
        drug_id: $('#txtDid').val(),
        ref_drug_id: $('#txtDrugId').val(),
        drug_name: $('#txtDrugTrade').val(),
        drug_price: $('#txtDrugPrice').val(),
        drug_qty: $('#txtDrugUnit').val(),
        drug_cost: $('#txtDrugCost').val(),
        drug_sum: $('#txtSumprice').val()
    }

    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist', param, function(){}, 'json')
               .always(function(snap){
                //    console.log(snap);
                //    return ;
                   preload.hide()
                   if(snap.status == 'Success'){
                       $('#modalMedPHR').modal('hide')
                       getDruglist()
                   }else{

                   }
               })
}

function addDruglist2(){
    $('.form-control').removeClass('is-invalid')
    if($('#txtDrugUnit').val() == ''){
        $('#txtDrugUnit').addClass('is-invalid')
        return ;
    }
    var param = {
        patient_id: $('#txtPid').val(),
        drug_id: $('#txtDid').val(),
        ref_drug_id: $('#txtDrugId').val(),
        drug_name: $('#txtDrugTrade').val(),
        drug_price: $('#txtDrugPrice').val(),
        drug_qty: $('#txtDrugUnit').val(),
        drug_cost: $('#txtDrugCost').val(),
        drug_sum: $('#txtSumprice').val(),
        service_seq: $('#txtSeq').val()
    }

    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=addlist2', param, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                       $('#modalMedPHR').modal('hide')
                       getDruglist()
                   }else{

                   }
               })
}

function getDruglist(){
    var jst = $.post(authen_api + 'drug.php?stage=getlist', {patient_id: $('#txtPid').val(), seq: $('#txtSeq').val() }, function(){}, 'json')
               .always(function(snap){
                   console.log(snap);
                   if(snap.status == 'Success'){
                        $("#drugList").empty();
                        $summ = 0;
                        $summcost = 0;
                        snap.data.forEach(i => {
                            
                            $("#drugList").append('<tr><td>' + i.dlist_did + '</td>' + 
                                    '<td>' + i.dlist_drugname + '</td>' + 
                                    '<td>' + i.dlist_price + '</td>' + 
                                    '<td>' + i.dlist_qty + '</td>' + 
                                    '<td>' + i.dlist_sumcost + '</td>' + 
                                    '<td>' + i.dlist_sumprice + '</td>' + 
                                    '<td class="pl-0 pr-0">' + 
                                        '<button class="btn pl-1 pr-1" onclick="updateMEDLIST(\'' + i.dlist_did + '\', \'' + i.dlist_qty + '\')"><i class="bx bx-pencil text-muted" ></i></button>' +
                                        '<button class="btn pl-1 pr-1" onclick="deleteMEDLIST(\'' + i.dlist_id + '\')"><i class="bx bx-trash text-danger"></i></button>' +
                                    '</td>' + 
                            '</tr>')
                            $summcost += parseFloat(i.dlist_sumcost);
                            $summ += parseFloat(i.dlist_sumprice)
                        });
                        $('#txtFinalPrice').val($summ)
                        $('#txtFinalCost').val($summcost)
                   }
               })
}

function resetDrugform(){
    $('#txtDrugPrice').val()
    $('#txtDrugUnit').val()
    $('#txtSumprice').val()
}

function deleteMEDLIST(id){
    Swal.fire({
        title: 'คำเตือน',
        text: "หากลบแล้วจะไม่สามารถกู้คืนข้อมูลได้อีก",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
      }).then(function (result) {
        if (result.value) {
          preload.show()
          var jst = $.post(authen_api + 'drug.php?stage=deletelist', { rid: id }, function(){}, 'json')
                     .always(function(snap){
                        preload.hide()
                         if(snap.status == 'Success'){
                            getDruglist()
                         }else{
                             preload.hide()
                             Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาาด',
                                text: 'ไม่สามารถลบยาได้',
                                confirmButtonText: 'ลองใหม่',
                                confirmButtonClass: 'btn btn-danger',
                            })
                         }
                     })
        }
      })
}

function updateMEDLIST(id, qty){
    $('#modalMedPHRUpdate').modal()
    var jst = $.post(authen_api + 'drug.php?stage=info', { id: id, by: 'did' }, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                        $('#txtuDid').val(id)
                        $('#txtuDrugId').val(snap.data.did)
                        $('#txtuDrugTrade').val(snap.data.dname)
                        $('#txtuDrugGeneric').val(snap.data.dcname)
                        $('#txtuDrugDose').val(snap.data.ddose)
                        $('#txtuDrugCost').val(snap.data.dcost)
                        $('#txtuDrugPrice').val(snap.data.dprice)
                        $('#txtuDrugUnit').val(qty)

                        $unit = $('#txtuDrugUnit').val()
                        $price = $('#txtuDrugPrice').val()
                        $('#txtuSumprice').val($unit * $price)
                        
                        setTimeout(() => {
                            
                            $('#txtuDrugUnit').focus()
                        }, 500)
                   }else{
                    preload.hide()
                    Swal.fire(
                        {
                          icon: "error",
                          title: 'ไม่พบข้อมูล!',
                          text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                          confirmButtonClass: 'btn btn-danger',
                        }
                      )
                   }
               })
}

function focusOther(){
    setTimeout(() => {
        $('#txtOtheritem').focus()
    }, 1000)
}

function addNewmed(id){
    $('#modalMedPHR').modal()
    $('#modalDruglist').modal('hide')
    var jst = $.post(authen_api + 'drug.php?stage=info', { id: id, by: 'id' }, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                        $('#txtDid').val(id)
                        $('#txtDrugId').val(snap.data.did)
                        $('#txtDrugTrade').val(snap.data.dname)
                        $('#txtDrugGeneric').val(snap.data.dcname)
                        $('#txtDrugDose').val(snap.data.ddose)
                        $('#txtDrugCost').val(snap.data.dcost)
                        $('#txtDrugPrice').val(snap.data.dprice)
                        $('#txtDrugUnit').val('')
                        setTimeout(() => {
                            $('#txtDrugUnit').focus()
                        }, 500)
                   }else{
                    preload.hide()
                    Swal.fire(
                        {
                          icon: "error",
                          title: 'ไม่พบข้อมูล!',
                          text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                          confirmButtonClass: 'btn btn-danger',
                        }
                      )
                   }
               })
}

function deleteService(sid){
    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: "หากลบรายการนี้แล้วจะไม่สามารถนำกลับมาได้อีก",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันดำเนินการ',
        cancelButtonText: 'ตรวจสอบรายการก่อน',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            preload.show()
            var param = {
                service_id: sid,
                uid: $('#txtUid').val()
            }
            console.log(param);
            var jst = $.post(authen_api + 'service.php?stage=deleteservice', param, function(){}, 'json')
                        .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                window.location.reload()
                            }else{
                                Swal.fire({
                                      icon: "error",
                                      title: 'เกิดข้อผิดพลาด',
                                      text: 'ไม่สามารถลบข้อมูลได้',
                                      confirmButtonClass: 'btn btn-danger',
                                })
                            }
                        })
        }
    })
}

function finallizeService(){
    preload.show()
    $('#modalFinallize').modal()
    $('#txtfCose').val($('#txtFinalCost').val())
    $('#txtfPrice').val($('#txtFinalPrice').val())
    $('#txtfTotal').val($('#txtFinalPrice').val())

    if($('#txtfDf').val() != ''){
        $x = parseFloat($('#txtfPrice').val()) + parseFloat($('#txtfDf').val())
        $('#txtfTotal').val($x)
    }
    

    setTimeout(() => {
        var param = {
            patient_id: $('#txtPid').val(),
            service_id: $('#txtSeq').val()
        }
        $('#txtfDf').focus()
        preload.hide()
    }, 1000)
}

function updateDrugStock(id, dname, recent_q){
    $('#modalStock').modal()
    $('#txtDrugId').val(id)
    $('#txtDrugTrade').val(dname)
    $('#txtDrugQ').val(recent_q)
    $('#txtNewTotal').val($('#dstock_' + id).text().trim())
    setTimeout(()=>{
        $('#txtNewQ').focus()
    }, 500)
}

function editDrugStock(id, dname, recent_q){
    $('#modaleditStock').modal()
    $('#txtDrugIdu').val(id)
    $('#txtDrugTradeu').val(dname)
    $('#txtNewTotalu').val($('#dstock_' + id).text().trim())
    setTimeout(()=>{
        $('#txtNewTotalu').focus()
    }, 1000)
}

function editStock(){
    if($('#txtNewTotalu').val() == ''){
        $('#txtNewTotalu').addClass('is-invalid')
        return ;
    }

    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: "การแก้ไขจำนวนยาในคลังอาจส่งผลต่อข้อมูลอื่น ๆ กรุณาตรวจสอบให้ถูกต้องก่อนดำเนินการ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันดำเนินการ',
        cancelButtonText: 'กลับไปตรวจสอบ',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            preload.show()
            $('#modaleditStock').modal('hide')
            var param = {
                did: $('#txtDrugIdu').val(),
                newq: $('#txtNewTotalu').val()
            }
            var jst = $.post(authen_api + 'drug.php?stage=updatestock', param, function(){}, 'json')
                        .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                $('#dstock_' + $('#txtDrugIdu').val()).text($('#txtNewTotalu').val())
                                $('#txtNewTotalu').val('')
                                Swal.fire(
                                    {
                                    icon: "success",
                                    title: 'สำเร็จ!',
                                    text: 'จำนวนคงคลังยาถูกแก้ไขแล้ว',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถแก้ไขยาคงคลังได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }
                        })
        }
    })
}

function saveStock(){
    if($('#txtNewQ').val() == ''){
        $('#txtNewQ').addClass('is-invalid')
        return ;
    }

    Swal.fire({
        title: 'ยืนยันดำเนินการ',
        text: "ท่านต้องการเพิ่มยา " + $('#txtDrugTrade').val() + ' จำนวน ' + $('#txtNewQ').val() + ' (ea.) ใช่หรือไม่',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'กลับไปตรวจสอบ',
        confirmButtonClass: 'btn btn-danger mr-1',
        cancelButtonClass: 'btn btn-secondary',
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            preload.show()

            $('#modalStock').modal('hide')
            var param = {
                did: $('#txtDrugId').val(),
                newq: $('#txtNewTotal').val()
            }
            var jst = $.post(authen_api + 'drug.php?stage=newstock', param, function(){}, 'json')
                        .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                $('#dstock_' + $('#txtDrugId').val()).text($('#txtNewTotal').val())
                                $('#txtNewQ').val('')
                                Swal.fire(
                                    {
                                    icon: "success",
                                    title: 'สำเร็จ!',
                                    text: 'จำนวนคงคลังยาถูกแก้ไขแล้ว',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถแก้ไขยาคงคลังได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }
                        })
        }
    })
}

function updateDrug(id, drug_id, drug_name, cname, dose, cost, price){

    $('.form-control').removeClass('is-invalid')
    preload.show()
    var jst = $.post(authen_api + 'drug.php?stage=info', { id: id, by: 'id' }, function(){}, 'json')
               .always(function(snap){
                   preload.hide()
                   if(snap.status == 'Success'){
                        $('#txtDid').val(id)
                        $('#txtDrugId').val(snap.data.did)
                        $('#txtDrugTrade').val(snap.data.dname)
                        $('#txtDrugGeneric').val(snap.data.dcname)
                        $('#txtDrugDose').val(snap.data.ddose)
                        $('#txtDrugCost').val(snap.data.dcost)
                        $('#txtDrugPrice').val(snap.data.dprice)
                        $('#txtDrugId').focus()
                   }else{
                        preload.hide()
                        Swal.fire(
                            {
                            icon: "error",
                            title: 'ไม่พบข้อมูล!',
                            text: 'ไม่พบข้อมูลยาดังกล่าวในฐานข้อมูล',
                            confirmButtonClass: 'btn btn-danger',
                            }
                        )
                   }
               })

    
}

function deleteDrug(id){
    Swal.fire({
        title: 'คำเตือน',
        text: "หากลบแล้วจะไม่สามารถกู้คืนข้อมูลได้อีก",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยันลบ',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
      }).then(function (result) {
        if (result.value) {
          preload.show()
          var jst = $.post(authen_api + 'drug.php?stage=delete', { rid: id }, function(){}, 'json')
                     .always(function(snap){
                         if(snap.status == 'Success'){
                            preload.hide()

                            Swal.fire({
                                title: 'ลบยาสำเร็จ',
                                text: "กดปุ่ม 'รีโหลด' เพื่อโหลดรายการยาใหม่",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'รีโหลด',
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false,
                            }).then(function (result) {
                                if (result.value) {
                                    window.location.reload()
                                }
                            })
                         }else{
                             preload.hide()
                             Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาาด',
                                text: 'ไม่สามารถลบยาได้',
                                confirmButtonText: 'ลองใหม่',
                                confirmButtonClass: 'btn btn-danger',
                            })
                         }
                     })
        }
      })

      
}

function openQuickAdd(){
    $('#modalMedPHRQuick').modal()
    setTimeout(()=>{ $('#txtqDrugId').focus()}, 700)
}

function resetNewform(){
    $('.form-control').removeClass('is-invalid')
}

function checknewDrugFrom(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtNewDrugId').val() == ''){ $check++; $('#txtNewDrugId').addClass('is-invalid') }
    if($('#txtNewDrugTrade').val() == ''){ $check++; $('#txtNewDrugTrade').addClass('is-invalid') }
    if($('#txtNewDrugGeneric').val() == ''){ $check++; $('#txtNewDrugGeneric').addClass('is-invalid') }
    if($('#txtNewDrugDose').val() == ''){ $check++; $('#txtNewDrugDose').addClass('is-invalid') }
    if($('#txtNewDrugCost').val() == ''){ $check++; $('#txtNewDrugCost').addClass('is-invalid') }
    if($('#txtNewDrugPrice').val() == ''){ $check++; $('#txtNewDrugPrice').addClass('is-invalid') }

    if($check != 0){
        Swal.fire({
        title: "คำเตือน",
        text: "กรุณากรอกข้อมูลให้ครบถ้วน",
        icon: "error",
        confirmButtonClass: 'btn btn-danger',
        confirmButtonText: 'รับทราบ',
        buttonsStyling: false,
        });
        return false;
    }

    var param = {
        did: $('#txtNewDrugId').val(),
        tname: $('#txtNewDrugTrade').val(),
        gname: $('#txtNewDrugGeneric').val(),
        dose: $('#txtNewDrugDose').val(),
        cost: $('#txtNewDrugCost').val(),
        price: $('#txtNewDrugPrice').val()
    }

    preload.show()

    $('#modalNewdrug').modal('hide')

    var jst = $.post(authen_api + 'drug.php?stage=new', param, function(){}, 'json')
                   .always(function(snap){
                      preload.hide()
                       if(snap.status == 'Success'){

                            Swal.fire({
                                title: 'เพิ่มยาใหม่สำเร็จ',
                                text: "กดปุ่ม 'รีโหลด' เพื่อโหลดรายการยาใหม่",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'รีโหลด',
                                confirmButtonClass: 'btn btn-success',
                                buttonsStyling: false,
                            }).then(function (result) {
                                if (result.value) {
                                    window.location.reload()
                                }
                            })

                            setTimeout(() => {
                                $('.swal2-confirm').focus()
                            }, 500)
                        
                       }else if(snap.status == 'Fail'){
                            if(snap.error_stage == '2'){
                                preload.hide()
                                Swal.fire({
                                    icon: "error",
                                    title: 'รหัสยาซ้ำ',
                                    text: 'กรุณาให้รหัสยาใหม่ หรือเว้นว่างเพื่อใช้รหัสอัตโนมัติ',
                                    confirmButtonText: 'รับทราบ',
                                    confirmButtonClass: 'btn btn-danger',
                                })
                            }else{
                                preload.hide()
                                Swal.fire({
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถเพิ่มยาใหม่ได้',
                                    confirmButtonText: 'รับทราบ',
                                    confirmButtonClass: 'btn btn-danger',
                                })
                            }
                       }else{
                            preload.hide()
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถเพิ่มยาใหม่ได้',
                                confirmButtonClass: 'btn btn-danger',
                            })
                       }
                   })
    

    return ;
}

function checkDrugFrom(){
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtDid').val() == ''){ $check++; $('#txtDid').addClass('is-invalid') }
    if($('#txtDrugId').val() == ''){ $check++; $('#txtDrugId').addClass('is-invalid') }
    if($('#txtDrugTrade').val() == ''){ $check++; $('#txtDrugTrade').addClass('is-invalid') }
    if($('#txtDrugGeneric').val() == ''){ $check++; $('#txtDrugGeneric').addClass('is-invalid') }
    if($('#txtDrugDose').val() == ''){ $check++; $('#txtDrugDose').addClass('is-invalid') }
    if($('#txtDrugCost').val() == ''){ $check++; $('#txtDrugCost').addClass('is-invalid') }
    if($('#txtDrugPrice').val() == ''){ $check++; $('#txtDrugPrice').addClass('is-invalid') }

    if($check != 0){
        Swal.fire({
        title: "คำเตือน",
        text: "กรุณากรอกข้อมูลให้ครบถ้วน",
        icon: "error",
        confirmButtonClass: 'btn btn-danger',
        confirmButtonText: 'รับทราบ',
        buttonsStyling: false,
        });
        return false;
    }

    var param = {
        rid: $('#txtDid').val(),
        did: $('#txtDrugId').val(),
        tname: $('#txtDrugTrade').val(),
        gname: $('#txtDrugGeneric').val(),
        dose: $('#txtDrugDose').val(),
        cost: $('#txtDrugCost').val(),
        price: $('#txtDrugPrice').val()
    }

    $record_id = $('#txtDid').val();
    preload.show()

    if($('#txtDid').val() == ''){

    }else{
        var jst = $.post(authen_api + 'drug.php?stage=update', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       if(snap.status == 'Success'){

                        $('#ddid_' + $record_id).text($('#txtDrugId').val())
                        $('#dname_' + $record_id).text($('#txtDrugTrade').val())
                        $('#dcname_' + $record_id).text($('#txtDrugGeneric').val())
                        $('#ddose_' + $record_id).text($('#txtDrugDose').val())
                        $('#dcost_' + $record_id).text($('#txtDrugCost').val())
                        $('#dprince_' + $record_id).text($('#txtDrugPrice').val())

                        $('#txtDid').val('')
                        $('#txtDrugId').val('')
                        $('#txtDrugTrade').val('')
                        $('#txtDrugGeneric').val('')
                        $('#txtDrugDose').val('')
                        $('#txtDrugCost').val('')
                        $('#txtDrugPrice').val('')
                        
                        preload.hide()
                        Swal.fire(
                            {
                              icon: "success",
                              title: 'สำเร็จ',
                              text: 'ข้อมูลจาดังกล่าวถูกปรับปรุงเรียบร้อยแล้ว',
                              confirmButtonClass: 'btn btn-success',
                            }
                          )
                       }
                   })
    }
    

    return ;
}