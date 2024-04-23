<{if $bookmarks|default:false != 0}>
    <{include file="db:system_bookmarks.tpl"}>
<{/if}>

<{if $fbcomments|default:false != 0}>
    <{include file="db:system_fbcomments.tpl"}>
<{/if}>
<{if $copyright|default:'' != ''}>
    <div class="pull-right"><{$copyright}></div>
<{/if}>
<{if $pagenav|default:'' != ''}>
    <div class="pull-right"><{$pagenav}></div>
<{/if}>
<br>
<{if !empty($xoops_isadmin)}>
   <div class="text-center bold"><a href="<{$xoops_url}>/modules/wgteams/admin/"><{$smarty.const._CO_WGTEAMS_ADMIN}></a></div><br>
<{/if}>

<script type="text/javascript">
    //---------- AJAX Modal Start -------------------
    $(document).ready(function () {
        $('[data-toggle="modal"]').on('click', function () {
            var memberId = $(this).data('member-id');
            var modal = $('#memberModal'); // Define the modal variable

            // Make an AJAX request to the server
            $.ajax({
                url: '<{$wgteams_url}>/index.php',
                type: 'POST',
                data: { member_id: memberId },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // console.log(response); // Debugging purposes only
                        // Update the modal content with the member details
                        modal.find('.member-name').text(response.data.member_name);
                        modal.find('.member-image').html(response.data.member_image);
                        modal.find('.member-details').html(response.data.member_details);
                        modal.modal('show');
                    } else {
                        console.error('AJAX Error1:', response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error2:', status, error);
                }
            });
        });
    });
    //---------- AJAX Modal End -------------------
</script>


