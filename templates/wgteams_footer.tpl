<{if $bookmarks != 0}>
<{include file="db:system_bookmarks.html"}>
<{/if}>

<{if $fbcomments != 0}>
<{include file="db:system_fbcomments.html"}>
<{/if}>
<div class="pull-left"><{$copyright}></div>
<{if $pagenav != ''}>
    <div class="pull-right"><{$pagenav}></div>
<{/if}>
<br />
<{if $xoops_isadmin}>
   <div class="text-center bold"><a href="<{$admin}>"><{$smarty.const._MA_WGTEAMS_ADMIN}></a></div><br />
<{/if}>
