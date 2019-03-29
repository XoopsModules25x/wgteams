<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<{if $labels_list}>
    <table class="table table-bordered  table-striped"><thead><tr class="head"><th class="center"><{$smarty.const._AM_WGTEAMS_LABEL_ID}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_LABEL_NAME}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_LABEL_TYPE}></th>
<th class="center width5"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
</tr>
</thead>
<{if $labels_count}>
    <tbody><{foreach item=label from=$labels_list}>
        <tr class="<{cycle values='odd, even'}>"><td class="center"><{$label.id}></td>
<td class="center"><{$label.name}></td>
<td class="center"><{$label.type}></td>
<td class="center  width5">
<a href="labels.php?op=edit&amp;lbl_id=<{$label.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="labels"></a>
<a href="labels.php?op=delete&amp;lbl_id=<{$label.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="labels"></a>
</td>
</tr>

<{/foreach}>
</tbody>

<{/if}>
</table>
<div class="clear">&nbsp;</div>
<{if $pagenav}>
    <div class="xo-pagenav floatright"><{$pagenav}></div><div class="clear spacer"></div>

<{/if}>

<{/if}>
<{if $form}>
    <{$form}>
<{/if}>
<{if $error}>
    <div class="errorMsg"><strong><{$error}></strong>
</div>

<{/if}>
<br>
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>
