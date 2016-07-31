]);

        var options = {
          title: 'Company Performance',
          curveType: 'none',
          legend: { position: 'bottom' }
        };

        var chart<?echo($br);?> = new google.visualization.LineChart(document.getElementById('curve_chart<?echo($br);?>'));

        chart<?echo($br);?>.draw(data<?echo($br);?>, options<?echo($br);?>);
      }
    </script>
  
    <div id="curve_chart<?echo($br);?>" style="width: 900px; height: 500px"></div>
  