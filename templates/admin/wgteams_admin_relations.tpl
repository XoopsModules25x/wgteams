<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>
<{if $relations_list}>
	<table class="table table-bordered  table-striped"><thead><tr class="head"><th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_ID}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_TEAM_ID}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_MEMBER_ID}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_1_FIELD}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_1}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_2_FIELD}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_2}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_3_FIELD}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_3}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_4_FIELD}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_4}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_5_FIELD}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_INFO_5}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_RELATION_WEIGHT}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
<th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
<th class="center width5"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
</tr>
</thead>
<{if $relations_count}>
	<tbody><{foreach item=relation from=$relations_list}>
        <tr class="<{cycle values='odd, even'}>"><td class="center"><{$relation.id}></td>
<td class="center"><{$relation.team_id}></td>
<td class="center"><{$relation.member_id}></td>
<td class="center"><{$relation.info_1_field}></td>
<td class="center"><{$relation.info_1}></td>
<td class="center"><{$relation.info_2_field}></td>
<td class="center"><{$relation.info_2}></td>
<td class="center"><{$relation.info_3_field}></td>
<td class="center"><{$relation.info_3}></td>
<td class="center"><{$relation.info_4_field}></td>
<td class="center"><{$relation.info_4}></td>
<td class="center"><{$relation.info_5_field}></td>
<td class="center"><{$relation.info_5}></td>
<td class="center"><{$relation.weight}></td>
<td class="center"><{$relation.submitter}></td>
<td class="center"><{$relation.date_create}></td>
<td class="center  width5">
<a href="relations.php?op=edit&amp;rel_id=<{$relation.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="relations" /></a>
<a href="relations.php?op=delete&amp;rel_id=<{$relation.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="relations" /></a>
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
<br />
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>