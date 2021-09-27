$(document).ready(function() {
    // tự động nhập alias khi nhập title:
    $('body').on('keyup', '#inputTitle', function(event) {
        var value = $('#inputTitle').val();
        value = convertAlias(value);
        $("#inputAlias").val(value.split(/\s{1,}/g).join('-'));
    });

    // convert alias:
    $('#inputAlias').keyup(function () {
        var text = $(this).val();
        $("#inputAlias").val(convertAlias(text));  
    });
});

function convertAlias(text) {
    return text.toUpperCase().toLowerCase()
        .split(/đ|Đ/g).join('d')
        .normalize('NFD')
        .replace(/ +|_/g,'-').replace(/[-]+/g, '-').replace(/[^\w-]+/g,'');
}

// hiển thị ảnh đại diện:
function zoomImage(path, title, buttonText) {
    Swal.fire({
        customClass: 'swal-wide',
        imageUrl: path,
        imageWidth: 500,
        // imageHeight: 250,
        imageAlt: title,
        confirmButtonText: buttonText,
    })
}
