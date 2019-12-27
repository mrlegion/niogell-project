$(document).ready(function () {
    $('a[data-type="delete-btn"]').on('click', function (e) {
        e.preventDefault();
        Swal.fire({
            'title': 'Are you sure?',
            'text': 'You wan\'t delete this vote?',
            'icon': 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                // Show loader
                $('.loader-container').css('display', 'flex');
                // Send request to server
                $.ajax({
                    'url': 'delete',
                    'data': {id: $(this).data('vote-id')},
                    'method': 'GET',
                    'error': function (xhr, status, error) {
                        $('.loader-container').css('display', 'none');
                        Swal.fire('Error!', 'There was an error with your request. ' + xhr.responseText, 'error');
                    }
                }).done(function (data) {
                    $('.loader-container').css('display', 'none');
                    $.pjax.reload('#vote-container', {timeout: 3000});
                    Swal.fire('Deleted!', 'Selected vote has been deleted.', 'success');
                });

            }
        });
    })

});