<?php

  if(isset($ydata)){ unset($ydata); unset($ydata2); unset($ydata3); unset($labels); }

   // nacteme mesicni teploty      
   $dotaz = MySQLi_query($GLOBALS["DBC"], "SELECT den, prumer_vlhkost as prumer, nejnizsi_vlhkost as nejnizsi, nejvyssi_vlhkost as nejvyssi
                         FROM tme_denni 
                         AND zarizeni=".ZARIZENI."
                         WHERE nejnizsi_vlhkost > 0 AND den LIKE '".intval($_GET['rok'])."-%' 
                         ORDER BY den DESC");

    if(MySQLi_num_rows($dotaz) > 0)
    {

   // hodime do pole
   while($data = MySQLi_fetch_assoc($dotaz))
   {

    if(round($data['nejnizsi']) > 0)
    {

     if(round($data['nejvyssi'], 2) == 0){ $ydata[] = "0"; }
     else{ $ydata[] = jednotkaTeploty(round($data['nejvyssi'], 2), $u, 0); }

     if(round($data['nejnizsi'], 2) == 0){ $ydata2[] = "0"; }
     else{ $ydata2[] = jednotkaTeploty(round($data['nejnizsi'], 2), $u, 0); }

     if(round($data['prumer'], 2) == 0){ $ydata3[] = "0"; }
     else{ $ydata3[] = jednotkaTeploty(round($data['prumer'], 2), $u, 0); }

     $labels[] = formatDnu($data['den']);

    }

   }

   // abychom ziskali spravnou posloupnoust udaju, tak obe pole obratime
   $ydata = array_reverse($ydata);
   $ydata2 = array_reverse($ydata2);
   $ydata3 = array_reverse($ydata3);
   $labels = array_reverse($labels);

?>
<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: { renderTo: 'rocniVlhkost', zoomType: 'x', backgroundColor: '#ffffff', borderRadius: 0 },
            credits: { enabled: 0 },
            title: { text: null },
            xAxis: { categories: ['<?php echo implode("','", $labels); ?>'], 
            labels: { rotation: -45, align: 'right', step: 10 }
            },
            yAxis: [{ 
                labels: {
                    formatter: function() { return this.value +' %'; },
                    style: { color: '#1260c0' }
                },
                title: {
                    text: null,
                    style: { color: '#1260c0' }
                },
                opposite: false,
                max: 100
            }],
            tooltip: {
                formatter: function() {
                    var unit = {
                        '<?php echo $lang['max'] ?>': ' %',
                        '<?php echo $lang['avg'] ?>': ' %',
                        '<?php echo $lang['min'] ?>': ' %'
                    }[this.series.name];
                    return '<b>'+ this.x +'</b><br /><b>'+ this.y +' '+ unit + '</b>';
                },
                crosshairs: true,
            },
            legend: {
                layout: 'horizontal',
                align: 'left',
                x: 44,
                verticalAlign: 'top',
                y: -5,
                floating: true,
                backgroundColor: '#FFFFFF'
            },
            series: [{
                name: '<?php echo $lang['max'] ?>',
                type: 'spline',
                color: '#294d9f',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata); ?>],
                marker: { enabled: false }
            }, {
                name: '<?php echo $lang['avg'] ?>',
                type: 'spline',
                color: '#7993cd',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata3); ?>],
                marker: { enabled: false }
    
            }, {
                name: '<?php echo $lang['min'] ?>',
                type: 'spline',
                color: '#becced',
                yAxis: 0,
                data: [<?php echo implode(", ", $ydata2); ?>],
                marker: { enabled: false }
            }]
        });

        $(".tabs > li").click(function () { chart.reflow(); });

    });
    
});
</script>
<?php }