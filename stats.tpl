<h1>Projectstatistik</h1>
<div style="margin: 10px 10px">
 <code>
  <strong>Mitglieder gesamt:</strong> {$users_count}<br /><br />
  <strong>Davon aktiv:</strong> {$users_active}<br /><br />
{if $users_active > 0}
  <strong>Durchschnittliche Uptimer aller aktiven User:</strong> {$avg_uptime}<br /><br />
  <strong>Gesamte Uptime aller aktiven User:</strong> {$sum_uptime}
 </code>
</div>
{/if}

<h1>Prozentualer Anteil der Betriebssysteme</h1>
<table style="width: 100%;" class="p">
  <tr>
    <th style="width: 30%;">Betriebssystem</th>
    <th colspan="2" style="width: 70%;">Clients</th>
  </tr>
  {foreach from=$os item=item}
  <tr>
    <td>{$item.os}</td>
    <td class="right-aligned"> &nbsp;{$item.count} &nbsp;</td>
    <td><img src="img/barh.gif" style="width: {$item.width}px; height: 11px;" alt="{$item.percent}" /> {$item.percent}</td>
  </tr>
  {/foreach}  
</table>
