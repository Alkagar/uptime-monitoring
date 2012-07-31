<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

<script src="js/RGraph.common.core.js"></script>

<script src="js/RGraph.common.annotate.js"></script>  <!-- Just needed for annotating -->
<script src="js/RGraph.common.context.js"></script>   <!-- Just needed for context menus -->
<script src="js/RGraph.common.effects.js"></script>   <!-- Just needed for visual effects -->
<script src="js/RGraph.common.key.js"></script>       <!-- Just needed for keys -->
<script src="js/RGraph.common.resizing.js"></script>  <!-- Just needed for resizing -->
<script src="js/RGraph.common.tooltips.js"></script>  <!-- Just needed for tooltips -->
<script src="js/RGraph.common.zoom.js"></script>      <!-- Just needed for zoom -->

<script src="js/RGraph.bar.js"></script>              <!-- Just needed for Bar charts -->
<script src="js/RGraph.bipolar.js"></script>          <!-- Just needed for Bi-polar charts -->
<script src="js/RGraph.cornergauge.js"></script>      <!-- Just needed for CornerGauge charts -->
<script src="js/RGraph.fuel.js"></script>             <!-- Just needed for Fuel charts -->
<script src="js/RGraph.funnel.js"></script>           <!-- Just needed for Funnel charts -->
<script src="js/RGraph.gantt.js"></script>            <!-- Just needed for Gantt charts -->
<script src="js/RGraph.gauge.js"></script>            <!-- Just needed for Gauge charts -->
<script src="js/RGraph.hbar.js"></script>             <!-- Just needed for Horizontal Bar charts -->
<script src="js/RGraph.hprogress.js"></script>        <!-- Just needed for Porizontal Progress bars -->
<script src="js/RGraph.led.js"></script>              <!-- Just needed for LED charts -->
<script src="js/RGraph.line.js"></script>             <!-- Just needed for Line charts -->
<script src="js/RGraph.meter.js"></script>            <!-- Just needed for Meter charts -->
<script src="js/RGraph.odo.js"></script>              <!-- Just needed for Odometers -->
<script src="js/RGraph.pie.js"></script>              <!-- Just needed for Pie AND Donut charts -->
<script src="js/RGraph.radar.js"></script>            <!-- Just needed for Radar charts -->
<script src="js/RGraph.rose.js"></script>             <!-- Just needed for Rose charts -->
<script src="js/RGraph.rscatter.js"></script>         <!-- Just needed for Rscatter charts -->
<script src="js/RGraph.scatter.js"></script>          <!-- Just needed for Scatter charts -->
<script src="js/RGraph.thermometer.js"></script>      <!-- Just needed for Thermometer charts -->
<script src="js/RGraph.vprogress.js"></script>        <!-- Just needed for Vertical Progress bars -->
<script src="js/RGraph.waterfall.js"></script>        <!-- Just needed for Waterfall charts  -->
<canvas id="myCanvas" width="1000" height="400">[No canvas support]</canvas>

<script>
   $(document).ready(function() {
         var data = $('#data').hide().text().split('|');
         var larger = $('#dataLarger').hide().text().split('|');
         //var data = [280, 45, 133, 166, 84, 259, 266, 960, 219, 311, 67, 89];
         for(i in data) {
               data[i] = 1 * data[i];
         }

         for(i in larger) {
               larger[i] = 1 * larger[i];
         }
         alert(larger.length + ' ping valus higher than 500 ms was removed');
         var bar = new RGraph.Line('myCanvas', data);
         bar.Set('chart.gutter.left', 35);
         bar.Draw();

   });
</script>
<?php
   echo CHtml::tag('h1', array(), Yii::app()->name);
   $timesText = array();
   $larger = array();
   foreach($logs as $log) {
      $result = CJSON::decode($log->result_info);
      if(isset($result['pingTimeInMs']) &&  $result['pingTimeInMs'] < 500) {
         //if(isset($result['pingTimeInMs']) ){
         $timesText[] = $result['pingTimeInMs'];
      } else if(isset($result['ping_time_in_ms']) &&  $result['ping_time_in_ms'] < 500){
         //} else  {
         $timesText[] = $result['ping_time_in_ms'];
      }
    else if(isset($result['ping_time_in_ms']) &&  $result['ping_time_in_ms'] > 500){
         $larger[] = $result['ping_time_in_ms'];
      } else 
      if(isset($result['pingTimeInMs']) &&  $result['pingTimeInMs'] > 500) {
         $larger[] = $result['pingTimeInMs'];
         }

   }
   $timesText = join('|', $timesText);
   $larger = join('|', $larger);
   echo CHtml::tag('div', array('id' => 'data'), $timesText);
   echo CHtml::tag('div', array('id' => 'dataLarger'), $larger);
