<div class="row member-table">
    <{if $member.member_image|default:false}>
        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 member-panel-right">
    <{else}>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-panel-right">
    <{/if}>
        <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
            <{if $member.member_labels|default:false}>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$smarty.const._MA_WGTEAMS_MEMBER_NAME}></div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-text member-name">
            <{else}>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-name">
            <{/if}>
            <{if $member.member_title|default:false}><{$member.member_title}> <{/if}><{$member.member_name}></div>
        </div>
        <{if $member.member_address|default:false}>
            <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                <{if $member.member_labels|default:false}>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$smarty.const._MA_WGTEAMS_MEMBER_ADDRESS}></div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-text member-address">
                <{else}>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-address">
                <{/if}>
                <{$member.member_address}></div>
            </div>
        <{/if}>
        <{if $member.member_phone|default:false}>
            <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                <{if $member.member_labels|default:false}>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$smarty.const._MA_WGTEAMS_MEMBER_PHONE}></div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-phone">
                <{else}>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-phone">
                <{/if}>
                <{$member.member_phone}></div>
            </div>
        <{/if}>
        <{if $member.member_email|default:false}>
            <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                <{if $member.member_labels|default:false}>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$smarty.const._MA_WGTEAMS_MEMBER_EMAIL}></div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-email">
                <{else}>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-email">
                <{/if}>
                <{$member.member_email}></div>
            </div>
        <{/if}>
        <{if $member_show_index|default:false}>
            <{foreach item=info_index from=$member.index name=info_index}>
                <{if $info_index.info|default:false || $info_index.info_name|default:''}>
                    <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                    <{if $member.infofield_labels|default:false}>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$info_index.info_name}></div>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-info">
                    <{else}>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-info">
                    <{/if}>
                        <{$info_index.info}></div>
                    </div>
                <{/if}>
            <{/foreach}>
        <{/if}>
        <{if $member_show_team|default:false}>
            <{foreach item=info_team from=$member.team name=info_team}>
                <{if $info_team.info|default:false || $info_team.info_name|default:''}>
                    <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                        <{if $member.infofield_labels|default:false}>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$info_team.info_name}></div>
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-info">
                        <{else}>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-info">
                        <{/if}>
                        <{$info_team.info}></div>
                    </div>
                <{/if}>
            <{/foreach}>
        <{/if}>
        <{if $member_show_details|default:false}>
            <{foreach item=info_details from=$member.details name=info_details}>
                <{if $info_details.info|default:false || $info_details.info_name|default:''}>
                    <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                    <{if $member.infofield_labels|default:false}>
                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$info_details.info_name}></div>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-info">
                    <{else}>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-info">
                    <{/if}>
                            <{$info_details.info}></div>
                        </div>
                <{/if}>
            <{/foreach}>
        <{/if}>
    </div>
    <{if $member.member_image|default:false}>
        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
            <img class="img-responsive img-fluid center member-img <{$member.rel_imagestyle}>" src="<{$member.member_image_url}><{$member.member_image}>" alt="<{$member.member_name}>" title="<{$member.member_name}>">
        </div>
    <{/if}>
</div>
