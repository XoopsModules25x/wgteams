    <table class="table <{$members[0].rel_tablestyle}>">
        <tbody>
            <tr>
                <{foreach item=member from=$members}>
                    <{if $member.rel_nb_cols|default:0 == 2}>
                        <td class="width50">
                    <{elseif $member.rel_nb_cols|default:0 == 3}>
                        <td class="width33">
                    <{elseif $member.rel_nb_cols|default:0 == 4}>
                        <td class="width">
                    <{else}>
                    <{/if}>
                        <{if $member.rel_displaystyle|default:'' == 'left'}>
                            <{include file='db:wgteams_member_left.tpl' member=$member}>
                        <{elseif $member.rel_displaystyle|default:'' == 'right'}>
                            <{include file='db:wgteams_member_right.tpl' member=$member}>
                        <{else}>
                            <{include file='db:wgteams_member_default.tpl' member=$member}>
                        <{/if}>
                    </td>
                    <{if $member.rel_counter % $member.rel_nb_cols == 0}>
                        </tr><tr>
                    <{/if}>
                <{/foreach}>
            </tr>
        </tbody>
    </table>