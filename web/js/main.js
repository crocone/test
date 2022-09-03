$(function () {
    $('#getCode').click(function (e) {
        e.preventDefault();
        const successBlock = $(".resultSuccess")
        const errorBlock = $(".resultError")
        successBlock.bsHide();
        errorBlock.bsHide();
        $.ajax({
            url: 'http://localhost:8000/api/generate',
            type: 'get',
            dataType: 'json',
            username: 'user',
            password: 'user',
            success: function (data) {
                if (data.result === 'success') {
                    $(".codeResult").val(data.code)
                    successBlock.bsShow();
                } else {
                    errorBlock.text(data.message).bsShow();
                }
            },
            error: function () {

            }
        });
        return false;
    })

    $('.copyCode').on('click', () => {
        if (!navigator.clipboard) {
            $('.codeResult').select()
            document.execCommand("copy");
            alert("Ссылка успешно скопирована!");
        } else {
            const codeToCopy = $('.codeResult').val()
            navigator.clipboard.writeText(codeToCopy).then(
                function () {
                    alert("Код успешно скопирован!"); // success
                })
                .catch(
                    function () {
                        alert("Произошла ошибка"); // error
                    });
        }

    })

    $.fn.bsShow = function () {
        $(this).removeClass('d-none');
    }
    $.fn.bsHide = function () {
        $(this).addClass('d-none');
    }

})
