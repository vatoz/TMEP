﻿<?php

  // INIT
  require dirname(__FILE__)."/../../init.php";;

  // Posledni zaznamy
  $q = MySQLi_query($GLOBALS["DBC"], "SELECT kdy, teplota FROM tme  WHERE zarizeni=".ZARIZENI." ORDER BY kdy DESC LIMIT 1440");

  // budeme brat kazdy 40ty zaznam, abychom se do grafu rozumne vesli
  $a = 10;
  $count = 0;

    while($t = MySQLi_fetch_assoc($q))
    {

    // budeme za tu dobu, aktualne 40 minut, pocitat prumernou teplotu,
    // abychom meli graf "uhlazenejsi" (vypada to lepe)
    $teplota = $teplota+$t['teplota'];
    $count++;

      // uz mame dostatek mereni?
      if($a == 10)
      {

        // pridame teplotu do pole
        if(round($teplota/$count, 1) == 0){ $ydata[] = jednotkaTeploty(0, $u, 0); }
        else{ $ydata[] = round(jednotkaTeploty($teplota/$count, $u, 0), 1); }
        // pridame popisek do pole
        $labels[] = substr($t['kdy'], 11, 5);

        // "vynulujeme" teplotu
        $teplota = "";
        // vynulujeme pocitadla
        $count = 0;

        $a = 0;      

      }

    // iterujeme
    $a++;

    }

    // abychom ziskali spravnou posloupnoust udaju, tak obe pole obratime
    $ydata = array_reverse($ydata);
    $labels = array_reverse($labels);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'graf-24-hodin-teplota', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0 },
            credits: { enabled: 0 },
            title: { text: '<?php echo $lang['teplota24hodin']; ?>' },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 4 }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' <?php echo "$jednotka"; ?>'; },
                    style: { color: '#c4423f' }
                },
                title: {
                    text: null,
                    style: { color: '#c4423f' }
                },
                opposite: false
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['teplota'] ?>': '<?php echo "$jednotka"; ?>',
                    }[this.series.name];
                    return '<b>'+ this.x +'</b><br /><b>'+ this.y +' '+ unit + '</b>';
                },
                crosshairs: true,
            },
            legend: {
                enabled: false
            },
            series: [{
                name: '<?php echo $lang['teplota'] ?>',
                type: 'spline',
                color: '#c4423f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }]
        });

        $(".tabs > li").click(function () { chart.reflow(); });

    });
    
});
</script>