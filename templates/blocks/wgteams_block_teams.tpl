<{if $block > 0}>
    <div id="team" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 container-team">
        <{if $template == 'bcards'}> 
            <{foreach name=team item=team from=$block}>
                <{if $numbTeams == 6}>
                    <div class='wgt-card-panel col-xs-12 col-sm-2'>
                <{elseif $numbTeams == 4}>
                    <div class='wgt-card-panel col-xs-12 col-sm-3'>
                <{elseif $numbTeams == 3}>
                    <div class='wgt-card-panel col-xs-12 col-sm-4'>
                <{elseif $numbTeams == 2}>
                    <div class='wgt-card-panel col-xs-12 col-sm-6'>
                <{else}>
                    <div class='wgt-card-panel col-xs-12 col-sm-12'>
                <{/if}> 
                    <div class='wgt-card'>
                        <{if $team.team_image|default:false}>
                            <a class='' href='<{$wgteams_url_index}>?op=list&amp;team_id=<{$team.team_id}>' title='<{$smarty.const._MB_WGTEAMS_SHOWTEAM}>'>
                                <img class="wgt-card-img img-responsive center <{$team.team_imagestyle|default:''}>" src="<{$wgteams_teams_upload_url}><{$team.team_image}>" alt="<{$team.team_name}>" title="<{$team.team_name}>"></a>
                        <{/if}>
                        <div class="wgt-car-body">
                            <{if $showName}><h5 class="team-name center"><{$team.team_name}></h5><{/if}>
                            <{if $showDesc}><p class="team-descr"><{$team.team_descr}></p><{/if}>
                            <p class="center">
                                <a class='btn btn-primary' href='<{$wgteams_url_index}>?op=list&amp;team_id=<{$team.team_id}>' title='<{$smarty.const._MB_WGTEAMS_SHOWTEAM}>'><{$smarty.const._MB_WGTEAMS_SHOWTEAM}></a>
                            </p>
                        </div>
                    </div>
                </div>
                <{if $smarty.foreach.team.iteration % $numbTeams == 0}>
                    <div class="clear"></div>
                <{/if}>
            <{/foreach}>
        <{elseif $template == 'list'}> 
            <ul class="nav nav-pills nav-stacked">
                <{foreach name=team item=team from=$block}>
                    <li class='wgt-list-item'>
                        <a class='' href='<{$wgteams_url_index}>?op=list&amp;team_id=<{$team.team_id}>' title='<{$smarty.const._MB_WGTEAMS_SHOWTEAM}>'>
                            <{if $team.team_image|default:false}>
                                <img class="wgt-list-img <{$team.team_imagestyle|default:''}>" src="<{$wgteams_teams_upload_url}><{$team.team_image}>" alt="<{$team.team_name}>" title="<{$team.team_name}>">
                            <{/if}>
                            <{if $showName}><{$team.team_name}><{/if}>
                        </a>
                    </li>
                <{/foreach}>
            </ul>
        <{else}>
            <{foreach name=team item=team from=$block}>
                <div class="row">
                    <{if $team.team_image|default:false}>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="team-img"><img class="img-responsive <{$team.team_imagestyle|default:''}>" src="<{$wgteams_teams_upload_url}><{$team.team_image}>" alt="<{$team.team_name}>" title="<{$team.team_name}>"></div>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <{else}>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <{/if}>
                            <{if $team.show_teamname|default:false}>
                                <div class="team-heading"><p class="team-name"><{$team.team_name}></p></div>
                            <{/if}>
                            <{if $team.team_descr|default:false}>
                                <div class="team-descr"><p class="team-descr"><{$team.team_descr}></p></div>
                            <{/if}>
                            <{if $team.team_read_more|default:false}>
                                <div class="team-readmore"><a href="<{$wgteams_url_index}>?team_id=<{$team.team_id}>" class="" alt="<{$team.team_read_more}>" title="<{$team.team_read_more}>"><{$team.team_read_more}></a></div>
                            <{/if}>
                        </div>
                </div>
            <{/foreach}>
        <{/if}>
    </div>
<{/if}>
