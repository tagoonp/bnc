$arr1 = ["ก", "ข", "ค", "ฆ", "ง", "จ"];
$arr2 = ["ว", "ม", "ส", "ษ", "ศ", "ฆ"];
$arr3 = ["ฉ", "ช", "ซ", "ห", "ฌ", "อ", "ฮ"];
$arr4 = ["ณ", "ญ", "น", "ร", "ล", "ย", "ฬ", "ฤ"];
$arr5 = ["ด", "ต", "ถ", "ท", "ธ", "ฐ", "ฎ", "ฏ", "ฑ", "ฒ"];
$arr6 = ["บ", "ป", "พ", "ฟ", "ผ", "ฝ"];

$arr_thchar = ["ก", "ข", "ค", "ฆ", "ง", "จ", "ว", "ม", "ส", "ษ", "ศ", "ฆ", "ฉ", "ช", "ซ", "ห", "ฌ", "อ", "ฮ", "ณ", "ญ", "น", "ร", "ล", "ย", "ฬ", "ฤ", "ด", "ต", "ถ", "ท", "ธ", "ฐ", "ฎ", "ฏ", "ฑ", "ฒ", "บ", "ป", "พ", "ฟ", "ผ", "ฝ"];



$(function(){

    $code_prefix = '';
    $code_lname = [];
    $code_fname = [];

    $('#txtLname').keyup(function(){
        $prefix_found = false;
        $code_lname = [];
        $code_fname = [];

        // 1.ตัดแซ่
        // 2.ตัดสระ
        // 3.ทำให่้ครบจำนวน
        
        $lname = $('#txtLname').val()

        if($lname != ''){

            $lname_b = $lname.split("แซ่")
            if($lname_b.length > 1){
                $lname = $lname_b[1];
            }

            for (var i = 0; i < $lname.length; i++) {
                console.log($lname.charAt(i));
                if($prefix_found == false){
                    if($arr_thchar.includes($lname.charAt(i))){
                        $code_prefix = ($lname.charAt(i) + '.')
                        $prefix_found = true;
                    }
                }else{
                    if($arr1.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '1')){
                                $code_lname.push('1')
                            }else{
                                $code_lname.push('1')
                            }
                        }
                    }
                    if($arr2.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '2')){
                                $code_lname.push('2')
                            }else{
                                $code_lname.push('2')
                            }
                        }
                    }
        
                    if($arr3.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '3')){
                                $code_lname.push('3')
                            }else{
                                $code_lname.push('3')
                            }
                        }
                    }
        
                    if($arr4.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '4')){
                                $code_lname.push('4')
                            }else{
                                $code_lname.push('4')
                            }
                        }
                    }
        
                    if($arr5.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '5')){
                                $code_lname.push('5')
                            }else{
                                $code_lname.push('5')
                            }
                        }
                    }
        
                    if($arr6.includes($lname.charAt(i))){
                        if(($arr_thchar.includes($lname.charAt(i))) && ($code_lname.length <= 3)){
                            if((i != 0) && ($code_lname[$code_lname.length - 1] != '6')){
                                $code_lname.push('6')
                            }else{
                                $code_lname.push('6')
                            }
                        }
                    }
                }    
            }
        }else{
            $prefix_found = false;
        }


        $fname = $('#txtFname').val()
        if($fname != ''){
            for (var i = 0; i < $fname.length; i++) {
                if($code_fname.length < 2){
                    if($arr1.includes($fname.charAt(i))){


                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g1');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '1')){
                                $code_fname.push('1')
                            }else{
                                $code_fname.push('1')
                            }
                        }
                    }
                    if($arr2.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g2');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '2')){
                                $code_fname.push('2')
                            }else{
                                $code_fname.push('2')
                            }
                        }
                    }
        
                    if($arr3.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g3');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '3')){
                                $code_fname.push('3')
                            }else{
                                $code_fname.push('3')
                            }
                        }
                    }
        
                    if($arr4.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g4');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '4')){
                                $code_fname.push('4')
                            }else{
                                $code_fname.push('4')
                            }
                        }
                    }
        
                    if($arr5.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g5');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '5')){
                                $code_fname.push('5')
                            }else{
                                $code_fname.push('5')
                            }
                        }
                    }
        
                    if($arr6.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g6');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '6')){
                                $code_fname.push('6')
                            }else{
                                $code_fname.push('6')
                            }
                        }
                    }
                }
            }
        }

        if($code_fname.length < 2){
            for (let index = $code_fname.length; index < 2; index++) {
                $code_fname.push('0')
            }
        }

        if($code_lname.length < 2){
            for (let index = $code_lname.length; index < 2; index++) {
                $code_lname.push('0')
            }
        }
        console.log($code_prefix +  $code_lname.join('') + '.' + $code_fname.join(''));   
        $('#txtHn').val($code_prefix +  $code_lname.join('') + '.' + $code_fname.join(''))
    })

    $('#txtFname').keyup(function(){
        $code_lname = [];
        $code_fname = [];
        $fname = $('#txtFname').val()
        if($fname != ''){
            for (var i = 0; i < $fname.length; i++) {
                if($code_fname.length < 2){
                    if($arr1.includes($fname.charAt(i))){


                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g1');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '1')){
                                $code_fname.push('1')
                            }else{
                                $code_fname.push('1')
                            }
                        }
                    }
                    if($arr2.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g2');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '2')){
                                $code_fname.push('2')
                            }else{
                                $code_fname.push('2')
                            }
                        }
                    }
        
                    if($arr3.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g3');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '3')){
                                $code_fname.push('3')
                            }else{
                                $code_fname.push('3')
                            }
                        }
                    }
        
                    if($arr4.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g4');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '4')){
                                $code_fname.push('4')
                            }else{
                                $code_fname.push('4')
                            }
                        }
                    }
        
                    if($arr5.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g5');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '5')){
                                $code_fname.push('5')
                            }else{
                                $code_fname.push('5')
                            }
                        }
                    }
        
                    if($arr6.includes($fname.charAt(i))){
                        if(($arr_thchar.includes($fname.charAt(i))) && ($code_fname.length < 2)){
                            console.log($fname.charAt(i) + ' g6');
                            if((i != 0) && ($code_fname[$code_fname.length - 1] != '6')){
                                $code_fname.push('6')
                            }else{
                                $code_fname.push('6')
                            }
                        }
                    }
                }
            }

            if($code_fname.length < 2){
                for (let index = $code_fname.length; index < 2; index++) {
                    $code_fname.push('0')
                }
            }

            if($code_lname.length < 2){
                for (let index = $code_lname.length; index < 2; index++) {
                    $code_lname.push('0')
                }
            }

            $('#txtHn').val($code_prefix +  $code_lname.join('') + '.' + $code_fname.join(''))
        }
        // console.log($code_prefix +  $code_lname.join('') + '.' + $code_fname.join(''));   
        
    })

    $('#newpatientForm').submit(function(){
        $check = 0;
        $('.form-control').removeClass('is-invalid')
        if($('#txtHn').val() == ''){ $check++; $('#txtHn').addClass('is-invalid') }
        if($('#txtFname').val() == ''){ $check++; $('#txtFname').addClass('is-invalid') }

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
            hn: $('#txtHn').val(),
            fname: $('#txtFname').val(),
            lname: $('#txtLname').val(),
            dd: $('#txtDD').val(),
            mm: $('#txtMM').val(),
            yy: $('#txtYY').val(),
            pid: $('#txtPid').val()
        }
    
        preload.show()
        $('#modalNewPatient').modal('hide')

        var jst = $.post(authen_api + 'patient.php?stage=new', param, function(){}, 'json')
                   .always(function(snap){
                       console.log(snap);
                      preload.hide()
                       if(snap.status == 'Success'){
                        window.location = 'app-cashing.php?searchkey=' + $('#txtHn').val()
                        // window.location.reload()
                       }else{
                        if(snap.error_stage == '2'){
                            Swal.fire({
                                icon: "error",
                                title: 'พบข้อมูลซ้ำ',
                                text: 'มีผู้ป่วยเลขปัตรนี้ในระบบแล้ว กรุณาตรวจสอบอีกครั้ง',
                                confirmButtonText: 'รับทราบ',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }else{
                            Swal.fire({
                                icon: "error",
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถขึ้นทะเบียนผู้ป่วยใหม่ได้',
                                confirmButtonText: 'ลองใหม่',
                                confirmButtonClass: 'btn btn-danger',
                            })
                        }
                       }
                    })

    })
})

function openNewPatient(){
    $('#modalNewPatient').modal()
    setTimeout(() => { $('#txtFname').focus() }, 500)
}

function saveApp(){
    console.log('asd');
    $check = 0;
    $('.form-control').removeClass('is-invalid')
    if($('#txtAppDate').val() == ''){
        $check++; $('#txtAppDate').addClass('is-invalid')
    }

    if($('#txtAppPlace').val() == ''){
        $check++; $('#txtAppPlace').addClass('is-invalid')
    }

    if($check != 0){
        return ;
    }

    var param = {
     puid: $('#txtuPid').val(),
     dateapp: $('#txtAppDate').val(),
     timeapp: $('#txtAppTime').val(),
     placeapp: $('#txtAppPlace').val(),
     infoapp: $('#txtAppInfo').val()
    }

    

    Swal.fire({
        title: 'ยืนยัน',
        text: "ท่านต้องการืนยันนัดหมายในวันที่ " + $('#txtAppDate').val() + ' หรือไม่?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
      }).then(function (result) {
        if (result.value) {
            preload.show()
            var jst = $.post(authen_api + 'patient.php?stage=addApp', param, function(){}, 'json')
            .always(function(snap){
                preload.hide()
                if(snap.status == 'Success'){
                    window.location.reload()
                }else{
                    Swal.fire({
                        icon: "error",
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเพิ่มนัดหมายได้ได้',
                        confirmButtonText: 'ลองใหม่',
                        confirmButtonClass: 'btn btn-danger',
                    })
                }
            })
        }
      })
}