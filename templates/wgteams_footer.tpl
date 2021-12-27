<{if $bookmarks|default:false != 0}>
    <{include file="db:system_bookmarks.tpl"}>
<{/if}>

<{if $fbcomments|default:false != 0}>
    <{include file="db:system_fbcomments.tpl"}>
<{/if}>
<{if $copyright|default:'' != ''}>
    <div class="pull-right"><{$copyright}></div>
<{/if}>
<{if $pagenav|default:'' != ''}>
    <div class="pull-right"><{$pagenav}></div>
<{/if}>
<br>
<{if $xoops_isadmin|default:false}>
   <div class="text-center bold"><a href="<{$xoops_url}>/modules/wgteams/admin/"><{$smarty.const._CO_WGTEAMS_ADMIN}></a></div><br>
<{/if}>
