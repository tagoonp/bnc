var service = {
    create(pid){
        Swal.fire({
            title: 'ยืนยันดำเนินการ',
            text: "ท่านยืนยันการสร้างรายการบริการครั้งใหม่หรือไม่",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            confirmButtonClass: 'btn btn-danger mr-1',
            cancelButtonClass: 'btn btn-secondary',
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                window.location = '../../../controller/create_service.php?patient_id=' + pid
            }
        })
    },
    delete(sid){
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
    },
    calculateAppDate(){
        if(($('#txtNumDate').val() == '') || ($('#txtNumDate').val() == '0')){
            Swal.fire({
                icon: "error",
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกจำนวนวันให้ถูกต้อง',
                confirmButtonClass: 'btn btn-danger',
            })
            return ;
        }
        $numofday = $('#txtNumDate').val()
        $numofday = parseInt($numofday) ;

        var date = new Date(new Date().setDate(new Date().getDate() + $numofday));
        console.log(date);
        console.log(date.getDate());

        $d = date.getDate();
        if($d < 10){
            $d = '0' + $d;
        }
        
        $m =  date.getMonth() + 1
        if($m < 10){
            $m = '0' + $m
        }
        
        console.log(date.getFullYear());

        $newdate = date.getFullYear() + '-' + $m + '-' + $d;
        $('#txtAppDate').val($newdate)
    },
    calculateAppWeek(){

        if(($('#txtNumWeek').val() == '') || ($('#txtNumWeek').val() == '0')){
            Swal.fire({
                icon: "error",
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกจำนวนสัปดาห์ให้ถูกต้อง',
                confirmButtonClass: 'btn btn-danger',
            })
            return ;
        }

        $numofweek = $('#txtNumWeek').val()
        $numofday = parseInt($numofweek) * 7;

        var date = new Date(new Date().setDate(new Date().getDate() + $numofday));
        console.log(date);
        console.log(date.getDate());

        $d = date.getDate();
        if($d < 10){
            $d = '0' + $d;
        }
        
        $m =  date.getMonth() + 1
        if($m < 10){
            $m = '0' + $m
        }
        
        console.log(date.getFullYear());

        $newdate = date.getFullYear() + '-' + $m + '-' + $d;
        $('#txtAppDate').val($newdate)
        
    },
    deleteApp(aid){
        Swal.fire({
            title: 'คำเตือน',
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
                    app_id: aid,
                    uid: $('#txtUid').val()
                }
                var jst = $.post(authen_api + 'service.php?stage=deleteapp', param, function(){}, 'json')
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
}