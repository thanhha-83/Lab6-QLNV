function removeVietnameseTones(str) {
    str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
    str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
    str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
    str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
    str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
    str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
    str = str.replace(/đ/g, "d");
    str = str.replace(/À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ/g, "A");
    str = str.replace(/È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ/g, "E");
    str = str.replace(/Ì|Í|Ị|Ỉ|Ĩ/g, "I");
    str = str.replace(/Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ/g, "O");
    str = str.replace(/Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ/g, "U");
    str = str.replace(/Ỳ|Ý|Ỵ|Ỷ|Ỹ/g, "Y");
    str = str.replace(/Đ/g, "D");
    // Some system encode vietnamese combining accent as individual utf-8 characters
    // Một vài bộ encode coi các dấu mũ, dấu chữ như một kí tự riêng biệt nên thêm hai dòng này
    str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // ̀ ́ ̃ ̉ ̣  huyền, sắc, ngã, hỏi, nặng
    str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // ˆ ̆ ̛  Â, Ê, Ă, Ơ, Ư
    return str;
}

function validateMaNV() {
    var n = document.getElementById('maNV').value;
    var error = document.getElementById('errorMaNV');
    var isExist = "";
    $.ajax(
        {
            url: './ajax/getMaNV.php',
            method: 'POST',
            data: { n: n },
            async: false,
            success: function (data) {
                isExist = data;
            }
        });
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Mã nhân viên không được để trống";
    }
    else if (isExist == '1') {
        error.style.visibility = "visible";
        error.innerHTML = "Mã nhân viên đã tồn tại";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z0-9\s]+$/.test(n)) {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Mã nhân viên không được chứa kí tự đặt biệt";
    }
}

function validateHoNV() {
    var n = removeVietnameseTones(document.getElementById('hoNV').value);
    var error = document.getElementById('errorHoNV');
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Họ nhân viên không được để trống";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z\s]+$/.test(n)) {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
    else {
        if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
            error.style.visibility = "visible";
            error.innerHTML = "Không được chứa kí tự đặc biệt";
        }
        else {
            error.style.visibility = "visible";
            error.innerHTML = "Không được chứa kí tự số";
        }
    }
}

function validateTenNV() {
    var n = removeVietnameseTones(document.getElementById('tenNV').value);
    var error = document.getElementById('errorTenNV');
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Tên nhân viên không được để trống";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z\s]+$/.test(n)) {
        error.style.visibility = "hidden"
        error.innerHTML = "";
    }
    else {
        if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
            error.style.visibility = "visible";
            error.innerHTML = "Không được chứa kí tự đặc biệt";
        }
        else {
            error.style.visibility = "visible";
            error.innerHTML = "Không được chứa kí tự số";
        }

    }
}

function validateNS() {
    var dob = document.getElementById('ngaySinh').value;
    var error = document.getElementById('errorNgaySinh');
    if (dob == "dd-mm-yyyy") {
        error.style.visibility = "visible";
        error.innerHTML = "Ngày sinh không được để trống";
    }
    else if (dob.length != 10) {
        error.style.visibility = "visible";
        error.innerHTML = "Ngày sinh không được để trống";
    }
    else {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
}

function validateDC() {
    var n = removeVietnameseTones(document.getElementById('diaChi').value);
    var error = document.getElementById('errorDiaChi');
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Địa chỉ không được để trống";
    }
    else if (/^[A-Za-z0-9,/-\s]+$/.test(n)) {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Không được chứa kí tự đặc biệt";
    }
}

function validateAnh() {
    var anh = document.getElementById('hinhAnh').value;
    var error = document.getElementById('errorHinhAnh');
    console.log(anh);
    if (anh == null || anh == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Bạn chưa chọn ảnh";
    }
    else {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
}

function validateMaLNV() {
    var n = document.getElementById('maLNV').value;
    var error = document.getElementById('errorMaLNV');
    var isExist = "";
    $.ajax(
        {
            url: './ajax/getMaLNV.php',
            method: 'POST',
            data: { n: n },
            async: false,
            success: function (data) {
                isExist = data;
            }
        });
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Mã loại nhân viên không được để trống";
    }
    else if (isExist == '1') {
        error.style.visibility = "visible";
        error.innerHTML = "Mã loại nhân viên đã tồn tại";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z0-9\s]+$/.test(n)) {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Mã loại nhân viên không được chứa kí tự đặt biệt";
    }
}

function validateTenLNV() {
    var n = removeVietnameseTones(document.getElementById('tenLNV').value);
    var error = document.getElementById('errorTenLNV');
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Tên loại nhân viên không được để trống";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z0-9\s]+$/.test(n)) {
        error.style.visibility = "hidden"
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Không được chứa kí tự đặc biệt";
    }
}

function validateMaPB() {
    var n = document.getElementById('maPB').value;
    var error = document.getElementById('errorMaPB');
    var isExist = "";
    $.ajax(
        {
            url: './ajax/getMaPB.php',
            method: 'POST',
            data: { n: n },
            async: false,
            success: function (data) {
                isExist = data;
            }
        });
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Mã phòng ban không được để trống";
    }
    else if (isExist == '1') {
        error.style.visibility = "visible";
        error.innerHTML = "Mã phòng ban đã tồn tại";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z0-9\s]+$/.test(n)) {
        error.style.visibility = "hidden";
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Mã phòng ban không được chứa kí tự đặt biệt";
    }
}

function validateTenPB() {
    var n = removeVietnameseTones(document.getElementById('tenPB').value);
    var error = document.getElementById('errorTenPB');
    if (n == null || n == "") {
        error.style.visibility = "visible";
        error.innerHTML = "Tên phòng ban không được để trống";
    }
    else if (n.charAt(0) == ' ') {
        error.style.visibility = "visible";
        error.innerHTML = "Kí tự đầu tiên không được là khoảng trắng";
    }
    else if (/^[A-Za-z0-9\s]+$/.test(n)) {
        error.style.visibility = "hidden"
        error.innerHTML = "";
    }
    else if (/[\/!:\-\*?"<>_|~@#$`%^.&[()-,+=/\\/'";\]{}]/.test(n)) {
        error.style.visibility = "visible";
        error.innerHTML = "Không được chứa kí tự đặc biệt";
    }
}

function validateThemNV() {
    var v1 = document.getElementById("errorMaNV").style.visibility;
    var v2 = document.getElementById("errorHoNV").style.visibility;
    var v3 = document.getElementById("errorTenNV").style.visibility;
    var v4 = document.getElementById("errorNgaySinh").style.visibility;
    var v5 = document.getElementById("errorDiaChi").style.visibility;
    var v6 = document.getElementById("errorHinhAnh").style.visibility;

    if (v1 == "hidden" && v2 == "hidden" && v3 == "hidden" && v4 == "hidden" && v5 == "hidden" && v6 == "hidden") {
        return true;
    }
    else {
        $('#errorThemNhanVien').modal('show');
        return false;
    }
}

function validateSuaNV() {
    var v1 = document.getElementById("errorHoNV").style.visibility;
    var v2 = document.getElementById("errorTenNV").style.visibility;
    var v3 = document.getElementById("errorNgaySinh").style.visibility;
    var v4 = document.getElementById("errorDiaChi").style.visibility;

    if (v1 == "hidden" && v2 == "hidden" && v3 == "hidden" && v4 == "hidden") {
        return true;
    }
    else {
        $('#errorSuaNhanVien').modal('show');
        return false;
    }
}

function validateThemLNV() {
    var v1 = document.getElementById("errorMaLNV").style.visibility;
    var v2 = document.getElementById("errorTenLNV").style.visibility;

    if (v1 == "hidden" && v2 == "hidden") {
        return true;
    }
    else {
        $('#errorThemLoaiNhanVien').modal('show');
        return false;
    }
}

function validateSuaNV() {
    var v1 = document.getElementById("errorTenLNV").style.visibility;
    if (v1 == "hidden") {
        return true;
    }
    else {
        $('#errorSuaLoaiNhanVien').modal('show');
        return false;
    }
}

function validateThemPB() {
    var v1 = document.getElementById("errorMaPB").style.visibility;
    var v2 = document.getElementById("errorTenPB").style.visibility;

    if (v1 == "hidden" && v2 == "hidden") {
        return true;
    }
    else {
        $('#errorThemPhongBan').modal('show');
        return false;
    }
}

function validateSuaNV() {
    var v1 = document.getElementById("errorTenPB").style.visibility;
    if (v1 == "hidden") {
        return true;
    }
    else {
        $('#errorSuaPhongBan').modal('show');
        return false;
    }
}