console.log($('#txtUid').val());

$('.zero-configuration').DataTable({
    "ordering": false
});

var invoice = {
    search(id){
        
        preload.show()
        var jst = $.post(authen_api + 'invoice.php?stage=info', {inv_id: id}, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                            $('#modalUpdateInvoice').modal()
                            $('#txtCompany').val(snap.data.inv_company)
                            $('#txtInvoiceu').val(snap.data.inv_number)
                            $('#txtMoneyu').val(snap.data.inv_cost)
                            $('#txtDiscount').val(snap.data.inv_discount)
                            $('#txtInvDue').val(snap.data.inv_due_date)
                            $('#txtInvid').val(id)
                       }else{
                            Swal.fire(
                                {
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่พบข้อมูลที่ท่านต้องการ',
                                confirmButtonClass: 'btn btn-danger',
                                }
                            )
                       }
                   })
    },
    search2(id){
        
        preload.show()
        var jst = $.post(authen_api + 'invoice.php?stage=info', {inv_id: id}, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                       preload.hide()
                       if(snap.status == 'Success'){
                            $('#modalUpdateCheck').modal()
                            $('#txtCompany2').val(snap.data.inv_company)
                            $('#txtInvoiceu2').val(snap.data.inv_number)
                            $('#txtMoneyu2').val(snap.data.inv_cost)
                            $('#txtDiscount2').val(snap.data.inv_discount)
                            $('#txtInvDue2').val(snap.data.inv_due_date)
                            $('#txtInvid2').val(id)
                       }else{
                            Swal.fire(
                                {
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่พบข้อมูลที่ท่านต้องการ',
                                confirmButtonClass: 'btn btn-danger',
                                }
                            )
                       }
                   })
    },
    filter(){
        window.location = 'app-bill-list.php?filter=1&start=' + $('#txtFilterStart').val() + '&end=' + $('#txtFilterEnd').val() + '&status=' + $('#txtStatus').val()
    },
    delete(id, inv_no){
        Swal.fire({
            title: 'คำเตือน',
            text: "หากลบแล้วจะไม่สามารถนำกลับมาได้อีก",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยันลบ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                preload.show()
                var param = {
                    uid: $('#txtUid').val(),
                    inv_id: id
                }
                var jst = $.post(authen_api + 'invoice.php?stage=delete', param, function(){}, 'json')
                       .always(function(snap){
                           preload.hide()
                           if(snap.status == 'Success'){
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "บิลหมายเลข " + inv_no + " ถูกลบเรียบร้อยแล้ว",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'รีโหลดข้อมูล',
                                    confirmButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                }).then(function (result2) {
                                    if (result2.value) {
                                        window.location.reload()
                                    }
                                })
                           }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'ไม่สามารถลบข้อมูลได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                           }
                       })
            }
        })
    },
    update(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtCompany').val() == ''){
            $check++; $('#txtCompany').addClass('is-invalid')
        }
        if($('#txtInvoiceu').val() == ''){
            $check++; $('#txtInvoiceu').addClass('is-invalid')
        }
        if($('#txtMoneyu').val() == ''){
            $check++; $('#txtMoneyu').addClass('is-invalid')
        }
        if($('#txtInvDue').val() == ''){
            $check++; $('#txtInvDue').addClass('is-invalid')
        }
        if($check != 0){
            return ;
        }
        var param = {
            uid: $('#txtUid').val(),
            inv_id: $('#txtInvid').val(),
            inv_no: $('#txtInvoiceu').val(),
            inv_company: $('#txtCompany').val(),
            inv_duedate: $('#txtInvDue').val(),
            inv_money: $('#txtMoneyu').val(),
            inv_disc: $('#txtDiscount').val(),
            inv_chkno: $('#txtCheck').val()
        }

        Swal.fire({
            title: 'ยืนยันดำเนินการ',
            text: "ท่านยืนยันการแก้ไขข้อมูลบิลนี้หรือไม่?",
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
                var jst = $.post(authen_api + 'invoice.php?stage=update', param, function(){}, 'json')
                       .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                $('#modalNewInvoice').modal('hide')
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "บิลหมายเลข " + $('#txtInvoiceu').val() + " ได้ถูกปรับปรุงข้อมูลเรียบร้อยแล้ว",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'รีโหลดข้อมูล',
                                    confirmButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                }).then(function (result2) {
                                    if (result2.value) {
                                        window.location.reload()
                                    }
                                })
                            }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'ไม่สามารถเพิ่มข้อมูลได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }
                        })
            }
        })
    },
    update2(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtCompany2').val() == ''){
            $check++; $('#txtCompany2').addClass('is-invalid')
        }
        if($('#txtInvoiceu2').val() == ''){
            $check++; $('#txtInvoiceu2').addClass('is-invalid')
        }
        if($('#txtMoneyu2').val() == ''){
            $check++; $('#txtMoneyu2').addClass('is-invalid')
        }
        if($('#txtInvDue2').val() == ''){
            $check++; $('#txtInvDue2').addClass('is-invalid')
        }
        if($('#txtCheck2').val() == ''){
            $check++; $('#txtCheck2').addClass('is-invalid')
        }
        if($check != 0){
            return ;
        }
        var param = {
            uid: $('#txtUid').val(),
            inv_id: $('#txtInvid2').val(),
            inv_no: $('#txtInvoiceu2').val(),
            inv_company: $('#txtCompany2').val(),
            inv_duedate: $('#txtInvDue2').val(),
            inv_money: $('#txtMoneyu2').val(),
            inv_disc: $('#txtDiscount2').val(),
            inv_chkno: $('#txtCheck2').val()
        }

        Swal.fire({
            title: 'ยืนยันดำเนินการ',
            text: "ท่านยืนยันการจ่ายบิลยานี้หรือไม่?",
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
                var jst = $.post(authen_api + 'invoice.php?stage=update2', param, function(){}, 'json')
                       .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                $('#modalNewInvoice').modal('hide')
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "บิลหมายเลข " + $('#txtInvoiceu').val() + " ได้ถูกปรับปรุงข้อมูลเรียบร้อยแล้ว",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'รีโหลดข้อมูล',
                                    confirmButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                }).then(function (result2) {
                                    if (result2.value) {
                                        window.location.reload()
                                    }
                                })
                            }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'ไม่สามารถเพิ่มข้อมูลได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }
                        })
            }
        })
    },
    save(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtInvoice').val() == ''){
            $check++; $('#txtInvoice').addClass('is-invalid')
        }
        if($('#txtInvDate').val() == ''){
            $check++; $('#txtInvDate').addClass('is-invalid')
        }
        if($('#txtName').val() == ''){
            $check++; $('#txtName').addClass('is-invalid')
        }
        if($('#txtMoney').val() == ''){
            $check++; $('#txtMoney').addClass('is-invalid')
        }
        if($check != 0){
            return ;
        }
        var param = {
            uid: $('#txtUid').val(),
            inv_no: $('#txtInvoice').val(),
            inv_company: $('#txtName').val(),
            inv_date: $('#txtInvDate').val(),
            inv_money: $('#txtMoney').val()
        }

        Swal.fire({
            title: 'ยืนยันดำเนินการ',
            text: "ท่านยืนยันการเพิ่มบิลนี้หรือไม่?",
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
                var jst = $.post(authen_api + 'invoice.php?stage=add', param, function(){}, 'json')
                       .always(function(snap){
                            preload.hide()
                            if(snap.status == 'Success'){
                                $('#modalNewInvoice').modal('hide')
                                Swal.fire({
                                    title: 'สำเร็จ',
                                    text: "บิลหมายเลข " + $('#txtInvoice').val() + " ได้ถูกบันทึกเรียบร้อยแล้ว",
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonColor: '#3085d6',
                                    confirmButtonText: 'รีโหลดข้อมูล',
                                    confirmButtonClass: 'btn btn-danger',
                                    buttonsStyling: false,
                                }).then(function (result2) {
                                    if (result2.value) {
                                        window.location.reload()
                                    }
                                })
                            }else if(snap.status == 'Duplicate'){
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'ข้อมูลซ้ำ',
                                    text: 'พบหมายเลข invoice นี้จากบริษัทนี้แล้ว',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }else{
                                Swal.fire(
                                    {
                                    icon: "error",
                                    title: 'เกิดข้อผิดพลาด!',
                                    text: 'ไม่สามารถเพิ่มข้อมูลได้',
                                    confirmButtonClass: 'btn btn-danger',
                                    }
                                )
                            }
                        })
            }
        })
    }
}

$(function(){
    $('#txtInvoice').on('keypress',function(e) {
        if(e.which == 13) {
            $('#txtMoney').focus()
        }
    });
    $('#txtName').on('keypress',function(e) {
        if(e.which == 13) {
            $('#txtInvoice').focus()
        }
    });
    $('#txtInvDate').on('change',function(e) {
        $('#txtName').focus()
    });
    $('#txtMoney').on('keypress',function(e) {
        if(e.which == 13) {
            invoice.save()
        }
    });

    $('.pickadate').pickadate({
        format: 'yyyy-mm-dd',
        holder: 'เลือกวันที่ต้องการนัด',
        selectMonths: true,
        selectYears: 2,
        min: -30,
        max: 0
    });

    $('.pickadate2').pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        max: 0
    });

    $('.pickadate3').pickadate({
        format: 'yyyy-mm-dd',
        selectMonths: true,
        min: 0
    });
})

function setInvoiceFocuus(){
    setTimeout(() => {
        $('#txtInvDate').focus()
    }, 500)
}

function resetNewform(){
    $('.form-control').removeClass('is-invalid')
    $('#txtInvoice').val('')
    $('#txtName').val('')
    $('#txtSerial').val('')
    $('#txtMoney').val('')
}