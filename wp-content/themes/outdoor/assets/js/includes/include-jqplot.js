var data = [
    ['One', 25],['Two', 15], ['Three', 16], 
    ['Four', 17],['Five', 12], ['Six', 15]
];
var plot1 = jQuery.jqplot ('chart1', [data], { 
  seriesDefaults: {
    shadow: false,
    renderer:$.jqplot.DonutRenderer,
      rendererOptions: {
      startAngle: -90,
      diameter: 140,
      dataLabelPositionFactor: 0.6,
      innerDiameter: 28,
      showDataLabels: true
    }
  },
  grid:{
    background:'transparent',
    borderColor:'transparent',
    shadow:false,
    drawBorder:false,
    shadowColor:'transparent'
  },
  seriesColors: [
    "#3f4bb8",
    "#e13c4c",
    "#ff8137",
    "#ffbb42",
    "#20bdd0",
    "#2b70bf",
    "#f25463",
    "#f1a114",
    "#f5707d",
    "#ffd07d",
    "#4c7737"],
  legend: { 
    show:false, 
    location: 'e'
  }
});
$windowBrowser.resize(function() {
  plot1.replot({
    resetAxes: true
  });
});