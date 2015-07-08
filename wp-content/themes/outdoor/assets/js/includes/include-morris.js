new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'graph',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    {"month": "2012-10", "sales": 4000, "rents": 5000},
    {"month": "2012-09", "sales": 4000, "rents": 5500},
    {"month": "2012-08", "sales": 3300, "rents": 5100},
    {"month": "2012-07", "sales": 3300, "rents": 5150},
    {"month": "2012-06", "sales": 3100, "rents": 4800},
    {"month": "2012-05", "sales": 2900, "rents": 4100},
    {"month": "2012-04", "sales": 2300, "rents": 4600},
    {"month": "2012-03", "sales": 2300, "rents": 3500},
    {"month": "2012-02", "sales": 2700, "rents": 1700},
    {"month": "2012-01", "sales": 2000, "rents": 1000}
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'month',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['sales', 'rents'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['sales', 'rents'],
  barRatio: 0.4,
  xLabelAngle: 35,
  hideHover: 'auto',
  smooth: false,
  resize: true,
  lineColors: ['#98b025','#d45050', '#000099']
});
}

if($("#hero-bar").length>0) {
Morris.Bar({
  element: 'hero-bar',
  data: [
    {month: 'Jan.', sales: 2000, rents:2400},
    {month: 'Feb.', sales: 3000, rents:3100},
    {month: 'Mar.', sales: 3600, rents:3000},
    {month: 'Apr.', sales: 4300, rents:4100},
    {month: 'May.', sales: 3300, rents:3500},
    {month: 'Jun.', sales: 3000, rents:3800},
    {month: 'Jul.', sales: 3400, rents:2900},
    {month: 'Aug.', sales: 2900, rents:3500},
    {month: 'Sep.', sales: 4000, rents:3500},
    {month: 'Oct.', sales: 3900, rents:3400}
  ],
  xkey: 'month',
  ykeys: ['sales', 'rents'],
  labels: ['sales', 'rents'],
  barRatio: 0.4,
  xLabelAngle: 35,
  hideHover: 'auto',
  resize: true,
  lineColors: ['#98b025','#d45050', '#000099']
});
