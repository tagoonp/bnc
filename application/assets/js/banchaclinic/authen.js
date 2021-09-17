var authen = {
    login(){

        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtUsername').val() == ''){ $check++; $('#txtUsername').addClass('is-invalid') }
        if($('#txtPassword').val() == ''){ $check++; $('#txtPassword').addClass('is-invalid') }
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
        
        var jxr = $.post(authen_api + 'authen.php?stage=checklogin', { username : $('#txtUsername').val() , password : $('#txtPassword').val()}, function(){}, 'json')
                   .always(function(snap){
                       if(snap.status == 'Success'){
                           window.location = authen_controller + 'authen.php?stage=createsession&uid=' + snap.uid
                       }else{
                            Swal.fire({
                                title: "ขออภัย",
                                text: "ข้อมูลบัญชีผู้ใช้ไม่ถูกต้อง",
                                icon: "error",
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: 'รับทราบ',
                                buttonsStyling: false,
                            });
                            return false;
                       }
                   })
    }
}