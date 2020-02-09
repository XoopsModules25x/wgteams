<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<style>
    .maintenance-btn {
        margin:0;
        padding: 4px 10px;
        border:1px solid #ccc;
        border-radius:5px;
        line-height:26px;
    }
    .img-unused {
        padding:10px;
    }
    .img-unused img {
        width:50px;
        margin-right:20px;
    }
</style>

<table class='table table-bordered'>
    <thead>
        <tr class='head'>
            <th class='center'><{$smarty.const._AM_WGTEAMS_MAINTENANCE_TYP}></th>
            <th class='center'><{$smarty.const._AM_WGTEAMS_MAINTENANCE_DESC}></th>
            <{if $show_result}>
                <th class='center'><{$smarty.const._AM_WGTEAMS_MAINTENANCE_RESULTS}></th>
            <{else}>
                <th class='center'><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
            <{/if}>
        </tr>
    </thead>
    <tbody>
        <{if $show_unnused}>
            <tr class="<{cycle values='odd, even'}>">
                <td class='left'><{$smarty.const._AM_WGTEAMS_MAINTENANCE_DELETE_UNUSED}></td>
                <td class='left'><{$maintainance_dui_desc}></td>

                <td class='center '>
                    <{if $show_result}>
                        <{foreach item=image from=$result_unused}>
                            <div class='img-unused'>
                                <img src='<{$image.url}>'><a class='btn maintenance-btn' href='maintenance.php?op=delete_unused_image&del_img_path=<{$image.path}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
                            </div>
                        <{/foreach}>
                        <{if $result_success}><span><{$result_success}></span><{/if}>
                    <{else}>
                        <p class='left'><a class='btn maintenance-btn' href='maintenance.php?op=unused_images_search' title='<{$smarty.const._AM_WGTEAMS_EXEC}>'><{$smarty.const._AM_WGTEAMS_EXEC}></a></p>
                    <{/if}>
                </td>
            </tr>
        <{/if}>
        <{if $show_checkspace}>
            <tr class="<{cycle values='odd, even'}>">
                <td class='left'><{$smarty.const._AM_WGTEAMS_MAINTENANCE_CHECK_SPACE}></td>
                <td class='left'><{$maintainance_cs_desc}></td>
                <td class='left'>
                    <{if $show_result}>
                        <{if $result_success}><span><{$result_success}></span><{/if}>
                        <{if $result_error}><span class='maintenance-error'><{$result_error}></span><{/if}>
                    <{else}>
                        <p class='left'><a class='btn maintenance-btn' href='maintenance.php?op=check_space' title='<{$smarty.const._AM_WGTEAMS_EXEC}>'><{$smarty.const._AM_WGTEAMS_EXEC}></a></p>
                    <{/if}>
                </td>
            </tr>
        <{/if}>
    </tbody>
</table>

<{if $show_result}>
	<p><a class='btn maintenance-btn pull-right' href='maintenance.php?op=list' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a></p>
<{/if}>

<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<div class='errorMsg'><strong><{$error}></strong></div>
<{/if}>
<br>
<!-- Footer --><{include file='db:wgteams_admin_footer.tpl'}>
