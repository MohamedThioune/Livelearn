function donutChart(containerElem, options) {
    'use strict';

    var params = (typeof options === 'undefined') ? {} : options,
        bgColor = params.bgColor || 'transparent',
        centerCircleRadiusPct = params.centerCircleRadiusPct || 0.615, /* ~ 40 / 65 */
        size = params.size || 65,
        fillColors = params.fillColors || [
            ['#00a89d', 50],
            ['#ED8B00', 80],
            ['#00843D', 100]],
        percentage = containerElem.textContent || 0,
        percentageLimit = (percentage > 100) ? 100 : null, /* Capture if percentage > 100 */
        chart = document.createElementNS('http://www.w3.org/2000/svg', 'svg'),
        back = document.createElementNS('http://www.w3.org/2000/svg', 'circle'),
        front = document.createElementNS('http://www.w3.org/2000/svg', 'circle'),
        wedge = document.createElementNS('http://www.w3.org/2000/svg', 'path'),
        halfSize = (size / 2), // Utility value
        unit = (Math.PI *2) / 100, // 1 degree in radians
        startangle = 0,
        endangle = (percentageLimit || percentage) * unit - 0.001, // Prevent path from going >= 360 degrees

        // Determine drawing points
        x1 = halfSize,
        y1 = 0,
        x2 = halfSize + halfSize * Math.sin(endangle),
        y2 = halfSize - halfSize * Math.cos(endangle),
        big = 0,
        d, color;


    // Need extra value if arc percentage is > 180 degrees (in radians)
    if (endangle - startangle > Math.PI) {
        big = 1;
    }


    // Draw path
    d = "M " + halfSize + "," + halfSize +  // Start at circle center
        " L " + x1 + "," + y1 +     // Draw line to (x1,y1)
        " A " + halfSize + "," + halfSize +       // Draw an arc of radius r
        " 0 " + big + " 1 " +       // Arc details...
        x2 + "," + y2 +             // Arc goes to to (x2,y2)
        " Z";                       // Close wedge back to (cx,cy)


    // SVG Element
    chart.setAttribute('class', 'donut-chart-svg');
    chart.setAttribute('width', size);
    chart.setAttribute('height', size);
    chart.setAttribute('viewBox', '0 0 ' + size + ' ' + size);

    // Back Circle
    back.setAttribute('cx', size / 2);
    back.setAttribute('cy', size / 2);
    back.setAttribute('r',  size / 2);
    back.setAttribute('class', 'donut-chart-background');

    chart.appendChild(back);

    // Wedge
    wedge.setAttribute('class', 'donut-chart-fill');
    wedge.setAttribute('d', d); // Set this wedge

    // Determine color
    for (var i=0; i < fillColors.length; i++) {
        color = fillColors[i][0];

        if (percentage <= fillColors[i][1]) {
            break;
        }
    }

    wedge.setAttribute('fill', color);
    chart.appendChild(wedge); // Add wedge to chart


    // Front Circle
    front.setAttribute('class', 'donut-chart-foreground');
    front.setAttribute('cx', halfSize);
    front.setAttribute('cy', halfSize);
    front.setAttribute('r',  (halfSize * centerCircleRadiusPct));
    chart.appendChild(front);

    // Text
    var text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
    text.setAttribute('class', 'donut-chart-text');
    text.setAttribute('x', '50%');
    text.setAttribute('y', '50%');
    text.setAttribute('font-size', 0.27 * size); /* 18/65 */
    text.setAttribute('dy', '.3em'); /* Currently the best way to vertically align svg text (including IE9) */
    text.textContent = percentage;
    chart.appendChild(text);

    containerElem.innerHTML = ''; // Clear contents
    containerElem.setAttribute('style', 'width:' + size + 'px; height:' + size + 'px;');
    containerElem.appendChild(chart);
}



/* Default */
for (var i = 0, e = document.querySelectorAll('.donut-chart'); i < e.length; i++ ) {
    donutChart(e[i]);
}


/* Different Sizes */
for (var i = 0, e = document.querySelectorAll('.is-small'); i < e.length; i++ ) {
    donutChart(e[i], { size: 50 });
}

for (var i = 0, e = document.querySelectorAll('.is-big'); i < e.length; i++ ) {
    donutChart(e[i], { size: 100 });
}


/* With Background Color (Controlled by CSS) */
for (var i = 0, e = document.querySelectorAll('.has-bg'); i < e.length; i++ ) {
    donutChart(e[i]);
}


/* Has Big Center */
for (var i = 0, e = document.querySelectorAll('.has-big-center'); i < e.length; i++ ) {
    donutChart(e[i], { centerCircleRadiusPct: .8 });
}


/* Has Foreground Color (Controlled by CSS) */
for (var i = 0, e = document.querySelectorAll('.has-foreground'); i < e.length; i++ ) {
    donutChart(e[i]);
}


/* Use Different Fill Colors */
for (var i = 0, e = document.querySelectorAll('.use-custom-colors'); i < e.length; i++ ) {
    donutChart(e[i], {
        fillColors: [
            ['#ff0000', 25],
            ['#E7807B', 50],
            ['#FE94B9', 75],
            ['#E77BD6', 90],
        ]
    });
}

