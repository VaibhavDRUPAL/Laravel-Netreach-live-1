function callAJAX(url, method, data = null, isFormData = false, formName = null) {
    url = window.location.origin + '/chatbot/' + url;
    var promise = new Promise(function (resolve, reject) {
        if (method == 'POST' && isFormData == true) {
            $.ajax({
                url: url,
                method: method,
                contentType: false,
                processData: false,
                cache: false,
                data: new FormData($('#' + formName)[0]),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    resolve(data);
                }
            })
        } else if (method == 'POST') {
            $.ajax({
                url: url,
                method: method,
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    resolve(data);
                }
            })
        } else {
            $.ajax({
                url: url,
                method: method,
                contentType: "application/json",
                dataType: "json",
                data: data,
                success: function (data) {
                    resolve(data);
                }
            })
        }
    });
    return promise;
}

function validate(data) {
    var msg = '';
    $.each(data.data, function (key, val) {
        msg += val + '\n';
    });
    alert(msg);
}

function scrollChatboxToBottom() {
    var chatbox = document.getElementById("chatbox");
    var currentScroll = chatbox.scrollTop;
    var newScroll = currentScroll + 50;

    $(chatbox).animate({ scrollTop: newScroll }, 1000);
}

$(function () {
    /**
     * Chatbot
     */
    $(".chatbot-toggler").on("click", function () {
        $('.chatbot').toggle("scale");
        $('.chatbot-toggler img').toggle("scale");
        $('.chatbot-toggler i').toggle("scale");
    });

    $('.chatbot .refresh-icon').on("click", function () {
        callAJAX("reset-confirm", "GET").then(function (data) {
            $('#reset-content').empty();
            $('#reset-content').append(data.data);
            $('.chatbot .modal').show();
        });
    });

    $(document).on("click", '.chatbot .button-group .confirm-btn', function () {
        $('.chatbot .modal').hide();
        $('#chatbot').empty();
        callAJAX("reset", "POST").then(function (data) {
            $('#language-list').empty().append(data.data);
        });
        $('#chatbox').scrollTop(0);
    });

    $(document).on("click", '.chatbot .button-group .cancel-btn', function () {
        $('.chatbot .modal').hide();
    });
    $(document).on('click', '.locale', function () {
        var input = $(this);
        request = {
            locale: $('#locale').length ? $('#locale').val() : $(this).attr('data-value')
        };
        callAJAX("greetings", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) {
                $('#language-list').find('span').each(function (key, value) {
                    if ($(value).attr('data-key') != $(input).attr('data-key')) $(value).remove();
                })
                $(input).addClass('selected').css('max-width', '100%');
                $('#chatbot').append(data.data);
            }
        });
        setTimeout(scrollChatboxToBottom, 500);
    })
    $(document).on('click', '.question', function () {
        var input = $(this);
        request = {
            locale: $(this).attr('data-locale'),
            question_id: $(this).attr('data-id')
        };
        callAJAX("answer", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) {
                $(input).parent().empty().append($(input).removeClass().addClass('selected'))
                $('#chatbot').append(data.data);
            }
        });
        setTimeout(scrollChatboxToBottom, 500);
    })
    $(document).on('click', '.show-more, .load-more', function () {
        var input = $(this);
        request = {
            locale: $(this).attr('data-locale'),
            question_id: $(this).attr('data-id')
        }, isLoadMore = $(this).hasClass('load-more');

        if (isLoadMore) request.offset = $(this).attr('data-offset');

        callAJAX("showMore", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) {
                if (!isLoadMore) $(input).parent().empty().append($(input).removeClass().addClass('selected'));
                else if (data.data != null) $(input).parent().remove();

                if (data.data == null) {
                    $(input).parent().find('span.load-more').remove();
                    alert('No more questions to load, Select any one from above.');
                    callAJAX("thankYou", "GET", request).then(function (data) {
                        if (data.status == 600) validate(data);
                        if (data.status == 200) {
                            $('#chatbot').append(data.data);
                        }
                    });
                } else $('#chatbot').append(data.data);
            }
        });
        setTimeout(scrollChatboxToBottom, 500);
    })
    $(document).on('click', '.no-thats-all', function () {
        var input = $(this);
        callAJAX("thankYou", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) {
                $(input).parent().empty().append($(input).removeClass().addClass('selected'));
                $('#chatbot').append(data.data);
            }
        });
        setTimeout(scrollChatboxToBottom, 500);
    })
    $(document).on('submit', '#frm-user-details', function (e) {
        e.preventDefault();
        callAJAX("userDetails", "POST", null, true, 'frm-user-details').then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) $('#user-submitted, #thank-you').removeClass('d-none');
        });
        setTimeout(scrollChatboxToBottom, 500);
    })
    /**
     * Chatbot admin panel greetings
     */
    $(document).on('click', '.edit-greeting', function () {
        var id = $(this).attr('data-id'),
            request = {
                greeting_id: id,
                count: $('#greetings-field').find('section').length
            };

        callAJAX("greetings/get-all", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) {
                $('#greetings-field').empty();
                $('#greeting_id').val(id);
                $('#greetings-field').append(data.data);
                $('#greetings').modal('show');
            }
        });
    })
    $(document).on('click', '.delete-greeting', function () {
        if (confirm('Are you sure you want to remove greeting?')) {
            var id = $(this).attr('data-id'),
                request = {
                    greeting_id: id
                };
            callAJAX("greetings/delete-greeting", "GET", request).then(function (data) {
                if (data.status == 600) validate(data);
                if (data.status == 200) location.reload();
            });
        }
    })
    $(document).on('click', '#add-greetings', function () {
        var request = {
            add_on: true,
            count: $('#greetings-field').find('section').length
        }
        callAJAX("greetings/get-all", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) $('#greetings-field').append(data.data);
        });
    })
    /**
     * Chatbot admin panel questionnaire
     */
    $(document).on('click', '.new-question, .new-questionnaire', function () {
        var id = $(this).attr('parent-id');

        var request = {
            question_id: id != undefined ? id : null
        };

        callAJAX("questionnaire/add-question", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) {
                if (id != undefined) $('#parent_question_id').val(id);

                $('#question-field').empty();
                $('#add-question').attr('parent-id', id);
                $('#question-field').append(data.data);
                $('#new-question').modal('show');
            }
        });
    })
    $(document).on('click', '#add-question', function () {
        var request = {
            question_id: $(this).attr('parent-id') != undefined ? $(this).attr('parent-id') : null
        };
        callAJAX("questionnaire/add-question", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) $('#question-field').append(data.data);
        });
    })
    $(document).on('click', '.edit-question', function () {
        $('#self_question_id').val($(this).attr('parent-id'));
        $('#self_locale').val($(this).attr('data-locale'));
        $('#self_question').val($(this).attr('data-body'));
        $('#edit-question').modal('show');
    })
    $(document).on('click', '.edit-answer-sheet', function () {
        var id = $(this).attr('parent-id'),
            locale = $(this).attr('data-locale'),
            question = $(this).attr('data-body'),
            request = {
                question_id: id,
                locale: $(this).attr('data-locale'),
                count: $('#answer-field').find('section').length
            };

        callAJAX("questionnaire/get-all", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) {
                $('#answer-field').empty();
                $('#question_id').val(id);
                $('#locale').val(locale);
                $('#question').empty().append('Question: ' + question);
                $('#answer-field').append(data.data);
                $('#answer-sheet').modal('show');
            }
        });
    })
    $(document).on('click', '.delete-question, .destroy-question', function () {
        var msg = $(this).hasClass('destroy-question') ? 'Are you sure you want to delete this whole questionnaire?' : 'Are you sure you want to delete this question?',
            url = $(this).hasClass('destroy-question') ? 'destroy-question' : 'delete-question';
        url = 'questionnaire/' + url;

        if (confirm(msg)) {
            var request = {
                question_id: $(this).attr('parent-id'),
                locale: $(this).attr('data-locale')
            }

            callAJAX(url, "POST", request).then(function (data) {
                if (data.status == 600) validate(data);

                if (data.status == 200) location.reload();
            });
        }
    })
    $(document).on('click', '#add-answer', function () {
        var request = {
            count: $('#answer-field').find('section').length
        };

        callAJAX("questionnaire/add-answer", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) {
                $('#answer-field').append(data.data);
                $('#answer-sheet').modal('show');
            }
        });
    })
    /**
     * Chatbot admin panel common
     */
    $(document).on('click', '.remove-greeting, .remove-answer, .remove-question, .remove-content', function () {
        var flag = true;
        console.log($(this).hasClass('remove-content'));
        console.log($('#content-field').find('section').length);
        console.log($('#content-field').find('section').length == 1);
        if ($(this).hasClass('remove-question') && $('#question-field').find('section').length == 1) flag = false;
        else if ($(this).hasClass('remove-answer') && $('#answer-field').find('section').length == 1) flag = false;
        else if ($(this).hasClass('remove-content') && $('#content-field').find('section').length == 1) flag = false;
        else $(this).closest('section').remove();

        if (!flag) return alert('Required at least one field!')

        if ($(this).hasClass('remove-question') || $(this).hasClass('remove-answer')) {
            if ($(this).hasClass('remove-question')) var input = $('#question-field');
            if ($(this).hasClass('remove-answer')) var input = $('#answer-field');

            $(input).find('section').each(function (key, val) {
                var field = $(val).find('input');
                $(field).attr('name', $(val).find('input').attr('data-name') + '_' + key);
                $(field).attr('data-index', key);
            })
        }
    })
    $(document).on('change', '.media-type', function () {
        var request = {
            media_type: $(this).val(),
            field_type: $('#field-type').val(),
            index: $(this).attr('data-index')
        }, input = $(this);

        callAJAX("media-type", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);

            if (data.status == 200) {
                $(input).parent('div').next('div').empty();
                $(input).parent('div').next('div').append(data.data);
                if ($(input).val() == 'link') {
                    var parent = $(input).parent().parent();
                    var clone = $(parent).find('div').first().clone();
                    $(parent).find('div').first().after(clone);
                    $(clone).removeClass().addClass('col-md-3');
                    $(parent).find('div:nth-child(3)').removeClass().addClass('col-md-6');
                    $(parent).find('div:nth-child(2)').empty().append(data.data);
                    var title = $(parent).find('div:nth-child(2) input');
                    $(title).attr('name', $(title).attr('name') + '_title');
                }
            }
        });
    })
    $(document).on('click', '.book-an-appointment', function () {
        window.location.href = '/';
    })
    $(document).on('click', '.representative', function () {
        $('.chatbot-toggler').trigger('click');
        $('#chatbot').empty();
        window.Tawk_API.toggle();
    })
    if ($('#chatbot-user-details').length > 0) {
        $('#chatbot-user-details').dataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            searching: false,
            bPaginate: true,
            ajax: {
                url: '/chatbot/users/get-all',
                type: 'GET'
            },
            columns: [
                {
                    data: 'full_name',
                    title: 'Full name'
                },
                {
                    data: 'phone_number',
                    title: 'Mobile No'
                },
                {
                    data: 'ip_address',
                    title: 'IP Address'
                },
                {
                    data: 'country',
                    title: 'Country'
                },
                {
                    data: 'state',
                    title: 'State'
                },
                {
                    data: 'city',
                    title: 'City'
                },
                {
                    data: 'zip',
                    title: 'Zip Code'
                },
                {
                    data: 'created_at',
                    title: 'Created At'
                }
            ]
        })
    }
    if ($('#anonymous-visitors').length > 0) {
        $('#anonymous-visitors').dataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            searching: false,
            bPaginate: true,
            ajax: {
                url: '/chatbot/visitor/get-all',
                type: 'GET'
            },
            columns: [
                {
                    data: 'ip_address',
                    title: 'IP Address'
                },
                {
                    data: 'country',
                    title: 'Country'
                },
                {
                    data: 'state',
                    title: 'State'
                },
                {
                    data: 'city',
                    title: 'City'
                },
                {
                    data: 'zip',
                    title: 'Zip Code'
                },
                {
                    data: 'created_at',
                    title: 'Created At'
                }
            ]
        })
    }
    /**
     * Content
     */
    $(document).on('click', '.edit-content', function () {
        var id = $(this).attr('data-id');
        var request = {
            'content_id': id
        };

        callAJAX("content/get-content", "GET", request).then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) {
                $('#content-field').empty();
                $('#content_id').val(id);
                $('#content-field').append(data.data);
                $('#content').modal('show');
            }
        });
    });
    $(document).on('click', '#add-content', function () {
        callAJAX("content/get-content", "GET").then(function (data) {
            if (data.status == 600) validate(data);
            if (data.status == 200) $('#content-field').append(data.data);
        });
    });
});
