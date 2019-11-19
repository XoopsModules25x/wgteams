<{if $bookmarks != 0}>
<{include file="db:system_bookmarks.tpl"}>
<{/if}>

<{if $fbcomments != 0}>
<{include file="db:system_fbcomments.tpl"}>
<{/if}>
<div class="pull-right"><{$copyright}></div>
<{if $pagenav != ''}>
    <div class="pull-right"><{$pagenav}></div>
<{/if}>
<br>
<{if $xoops_isadmin}>
   <div class="text-center bold"><a href="<{$xoops_url}>/modules/wgteams/admin/"><{$smarty.const._CO_WGTEAMS_ADMIN}></a></div><br>
<{/if}>
