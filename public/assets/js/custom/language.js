function validate(data) {
    var msg = '';
    $.each(data.data, function (key, val) {
        msg += val + '\n';
    });
    alert(msg);
}

$(function () {
    /**
     * Language
     */
    $("#add-language").on("click", function () {
        $('#frm-add-language').find('input').each(function (key, val) {
            $(val).val('');
        })
        $('#language_title').text('Add Language');
        $('#language_submit').text('Save');
        $('#language').modal('show');
    });
    $(".edit-language").on("click", function () {
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'getByID',
            method: 'GET',
            dataType: 'json',
            data: {
                'language_id': id
            },
            success: function (data) {
                if (data.status == 600) validate(data);
                if (data.status == 200) {
                    $('#language_id').val(data.data.language_id);
                    $('#label_as').val(data.data.label_as);
                    $('#name').val(data.data.name);
                    $('#language_code').val(data.data.language_code);
                    $('#locale').val(data.data.locale);
                    $('#language_title').text('Update Language');
                    $('#language_submit').text('Update');
                    $('#language').modal('show');
                }
            }
        })
    });
    $(".delete-language").on("click", function () {
        if (confirm('Are you sure you want to delete ' + $(this).attr('data-label') + ' language?')) {
            var id = $(this).attr('data-id');

            $.ajax({
                url: 'deleteLanguage',
                method: 'post',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'language_id': id
                },
                success: function (data) {
                    if (data.status == 600) validate(data);
                    if (data.status == 200) window.location.reload();
                }
            })
        }
    });
});