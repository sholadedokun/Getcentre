$(function() {
    
    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2015 Q1',
            flight: 2666,
            hotel: null,
            tours: 2647
        }, {
            period: '2015 Q2',
            flight: 2778,
            hotel: 2294,
            tours: 2441
        }, {
            period: '2015 Q3',
            flight: 4912,
            hotel: 1969,
            tours: 2501
        }, {
            period: '2015 Q4',
            flight: 3767,
            hotel: 3597,
            tours: 5689
        }, {
            period: '2016 Q1',
            flight: 6810,
            hotel: 1914,
            tours: 2293
        }, {
            period: '2016 Q2',
            flight: 5670,
            hotel: 4293,
            tours: 1881
        }, {
            period: '2016 Q3',
            flight: 4820,
            hotel: 3795,
            tours: 1588
        }, {
            period: '2016 Q4',
            flight: 15073,
            hotel: 5967,
            tours: 5175
        }, {
            period: '2017 Q1',
            flight: 10687,
            hotel: 4460,
            tours: 2028
        }, {
            period: '2017 Q2',
            flight: 8432,
            hotel: 5713,
            tours: 1791
        }],
        xkey: 'period',
        ykeys: ['flight', 'hotel', 'tours'],
        labels: ['flight', 'hotel', 'Tours'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2011',
            a: 100,
            b: 90
        }, {
            y: '2012',
            a: 75,
            b: 65
        }, {
            y: '2013',
            a: 50,
            b: 40
        }, {
            y: '20014',
            a: 75,
            b: 65
        }, {
            y: '2015',
            a: 50,
            b: 40
        }, {
            y: '2016',
            a: 75,
            b: 65
        }, {
            y: '2017',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
