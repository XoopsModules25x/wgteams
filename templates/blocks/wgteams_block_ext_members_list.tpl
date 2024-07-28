<div class="member_list row">
    <{foreach item=member from=$members name=fe_members}>
        <{if $member_show_details|default:false}>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-panel" <{if $useModal|default:false}>data-toggle="modal" data-target="#memberModal<{$member.member_id}>" data-member-id="<{$member.member_id}>" data-bs-toggle="modal" data-bs-target="#memberModal<{$member.member_id}>"<{/if}>>
        <{elseif $member.rel_nb_cols|default:0 == 2}>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 member-panel" <{if $useModal|default:false}>data-toggle="modal" data-target="#memberModal<{$member.member_id}>" data-member-id="<{$member.member_id}>" data-bs-toggle="modal" data-bs-target="#memberModal<{$member.member_id}>"<{/if}>>
        <{elseif $member.rel_nb_cols|default:0 == 3}>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 member-panel" <{if $useModal|default:false}>data-toggle="modal" data-target="#memberModal<{$member.member_id}>" data-member-id="<{$member.member_id}>" data-bs-toggle="modal" data-bs-target="#memberModal<{$member.member_id}>"<{/if}>>
        <{elseif $member.rel_nb_cols|default:0 == 4}>
            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 member-panel" <{if $useModal|default:false}>data-toggle="modal" data-target="#memberModal<{$member.member_id}>" data-member-id="<{$member.member_id}>" data-bs-toggle="modal" data-bs-target="#memberModal<{$member.member_id}>"<{/if}>>
        <{else}>
            <div>
        <{/if}>
        <{if $useTab|default:false}><a href="<{$wgteams_url_index}>?team_id=<{$team.team_id}>&amp;rel_id=<{$member.member_id}>" class="member-link" alt="<{$member.member_name}>" title="<{$member.member_name}>" target="_blank"><{/if}>
        <{if $member.rel_displaystyle|default:'' == 'left'}>
            <{include file='db:wgteams_member_left.tpl' member=$member}>
        <{elseif $member.rel_displaystyle|default:'' == 'right'}>
            <{include file='db:wgteams_member_right.tpl' member=$member}>
        <{else}>
            <{include file='db:wgteams_member_default.tpl' member=$member}>
        <{/if}>
            </div>
        <{if $smarty.foreach.fe_members.iteration % $member.rel_nb_cols == 0 && $smarty.foreach.fe_members.iteration < $smarty.foreach.fe_members.total}>
            </div>
            <div class="member_list row">
        <{/if}>
        <{if $useTab|default:false}></a><{/if}>
    <{/foreach}>
</div>
<{if $useModal|default:false}>
    <{if $member.rel_displaystyle|default:'' == 'left'}>
         <{include file='db:wgteams_member_modal_left.tpl' member=$member}>
    <{elseif $member.rel_displaystyle|default:'' == 'right'}>
         <{include file='db:wgteams_member_modal_right.tpl' member=$member}>
    <{else}>
         <{include file='db:wgteams_member_modal_default.tpl' member=$member}>
    <{/if}>
<{/if}>
