<{include file='db:wgteams_header.tpl'}>
<{if $teams_list|default:0 > 0}>
    <div class="row">
        <div id="team" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-team">
            <{foreach item=teams from=$teams_list}>
                <{foreach item=team from=$teams}>
                    <{include file='db:wgteams_teams_list.tpl' team=$team}>
                <{/foreach}>
            <{/foreach}>
        </div>
    </div>
<{/if}>
<{include file='db:wgteams_footer.tpl'}>
