<!-- Header -->
<{include file='db:wgteams_admin_header.tpl'}>

<{if $form|default:false}>
    <{$form}>
<{/if}>

<{if $relations_list|default:false}>
    <table class="table table-bordered  table-striped" id="sortable">
        <thead>
            <tr class="head">
                <th class="center">&nbsp;</th>
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
                <th class="center"><{$smarty.const._AM_WGTEAMS_SUBMITTER}></th>
                <th class="center"><{$smarty.const._AM_WGTEAMS_DATE_CREATE}></th>
                <th class="center width5"><{$smarty.const._AM_WGTEAMS_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $relations_count|default:false}>
            <{foreach item=relation from=$relations_list}>
                <tr class="even" id="rorder_<{$relation.id}>">
                    <td class="center">
                    <{if $relation.nb_rels_team|default:0 > 1}>
                        <img src="<{$wgteams_icons_url}>/16/up_down.png" alt="drag&drop" class="icon-sortable">
                    <{else}>
                        &nbsp;
                    <{/if}>
                    </td>
                    <td class="center"><{$relation.member_name}></td>
                    <td class="center"><{$relation.info_1_field|default:false}></td>
                    <td class="left"><{$relation.info_1}></td>
                    <td class="center"><{$relation.info_2_field|default:false}></td>
                    <td class="left"><{$relation.info_2}></td>
                    <td class="center"><{$relation.info_3_field|default:false}></td>
                    <td class="left"><{$relation.info_3}></td>
                    <td class="center"><{$relation.info_4_field|default:false}></td>
                    <td class="left"><{$relation.info_4}></td>
                    <td class="center"><{$relation.info_5_field|default:false}></td>
                    <td class="left"><{$relation.info_5}></td>
                    <td class="center"><{$relation.submitter}></td>
                    <td class="center"><{$relation.date_create}></td>
                    <td class="center  width5">
                    <a href="relations.php?op=edit&amp;rel_id=<{$relation.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="relations"></a>
                    <a href="relations.php?op=delete&amp;rel_id=<{$relation.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="relations"></a>
                    </td>
                </tr>
                <{/foreach}>
            </tbody>
        <{/if}>
    </table>

    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:false}>
        <div class="xo-pagenav floatright"><{$pagenav}></div><div class="clear spacer"></div>
    <{/if}>
<{/if}>

<{if $error|default:false}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>
<br>
<!-- Footer -->
<{include file='db:wgteams_admin_footer.tpl'}>
