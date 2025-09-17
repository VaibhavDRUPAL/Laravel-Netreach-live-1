$(document).ready(function () {
    $('#meet-counsellor-details').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        responsive: true,
        fixedColumns: true,
        columnDefs: [
            { orderable: false, targets: [5] } // Make the "Message" column non-sortable
        ],
        language: {
            search: "Search:",
            lengthMenu: "Display _MENU_ records per page",
            zeroRecords: "No matching records found",
            info: "Showing _START_ to _END_ of _TOTAL_ records",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)"
        }
    });
    $(document).on('click', '.follow-up-btn', function () {
        const meetId = $(this).data('id');
        const name = $(this).data('name');

        $('#followUpMeetId').val(meetId);
        $('#followUpName').val(name);
    });

});

$(document).on('click', '.viewFollowUpBtn', function () {

    const meetId = $(this).data('id');
    const modalBody = $('#followUpContainer');

    modalBody.html('<p>Loading...</p>');

    $.ajax({
        url: `/admin/meet-counsellor/followups/${meetId}
`,
        method: 'GET',
        success: function (response) {
            modalBody.html(response.html);
        },
        error: function () {
            modalBody.html('<p>Error loading follow-ups.</p>');
        }
    });
});

function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
    $('.viewFollowUpBtn').on('click', function () {
        const meetId = $(this).data('id');
        const followUpContent = $('#follow-up-' + meetId).html();
        $('#followUpContainer').html(followUpContent);
    })
    $(document).on('click', '.viewFollowUpBtn', function () {
        const meetId = $(this).data('id');
        const modalBody = $('#followUpContainer');

        modalBody.html('<p>Loading...</p>');

        $.ajax({
            url: `/admin/meet-counsellor/followups/${meetId}`,
            method: 'GET',
            success: function (response) {
                modalBody.html(response.html);
            },
            error: function () {
                modalBody.html('<p>Error loading follow-ups.</p>');
            }
        });
    });

}
