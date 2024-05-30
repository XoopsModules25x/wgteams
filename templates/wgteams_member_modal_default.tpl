<{foreach item=member from=$members name=fe_members}>
    <div class="modal fade" id="memberModal<{$member.member_id|default:0}>" tabindex="-1" role="dialog" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="memberModalLabel"><{if $member.member_title|default:false}><{$member.member_title}> <{/if}><{$member.member_name}></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <{if $member.member_image|default:false}>
                        <div class="row member-img center <{$member.rel_tablestyle}>">
                            <img class="img-fluid center <{$member.rel_imagestyle}>" src="<{$member.member_image_url}><{$member.member_image}>" alt="<{$member.member_name}>" title="<{$member.member_name}>">
                        </div>
                    <{/if}>
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
                    <{foreach item=info_general from=$member.general name=info_general}>
                        <{if $info_general.info|default:false || $info_general.info_name|default:''}>
                            <div class='row <{if $member.rel_tablestyle|default:'' == 'wgteams-striped'}><{cycle values="wgteams-odd, wgteams-even"}><{else}><{$member.rel_tablestyle}><{/if}>'>
                                <{if $member.infofield_labels|default:false}>
                                     <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 member-label"><{$info_general.info_name}></div>
                                     <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 member-label member-info">
                                <{else}>
                                     <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 member-text member-info">
                                <{/if}>
                                <{$info_general.info}></div>
                            </div>
                        <{/if}>
                    <{/foreach}>
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
                </div>
            </div>
        </div>
    </div>
<{/foreach}>
