<{if $team_show|default:false}>
    <div class="row">
        <{if $team.show_teamname|default:false}>
            <div class="team-heading col-12"><h3 class="team-name center"><{$team.team_name}></h3></div>
        <{/if}>
    </div>
    <div class="row">
        <{if $team.team_image|default:false}>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 team-img">
                <img class="img-responsive img-fluid <{$team.team_imagestyle|default:''}>" src="<{$wgteams_teams_upload_url}><{$team.team_image}>" alt="<{$team.team_name}>" title="<{$team.team_name}>">
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
        <{else}>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <{/if}>
            <{if $team.team_descr|default:false}>
                <div class="team-descr"><p class="team-descr"><{$team.team_descr}></p></div>
            <{/if}>
            <{if $team.team_read_more|default:false}>
                <div class="team-readmore"><a href="<{$wgteams_url_index}>?team_id=<{$team.team_id}>" class="" alt="<{$team.team_read_more}>" title="<{$team.team_read_more}>"><{$team.team_read_more}></a></div>
            <{/if}>
        </div>
    </div>
<{/if}>
<{if $team.members|default:false}>
    <{include file='db:wgteams_members_list.tpl' members=$team.members}>
<{/if}>
