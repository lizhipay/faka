$(function(){
    "use strict";

    $('.sparkbar').sparkline('html', { type: 'bar' });

    $('.sparkline-pie').sparkline('html', {
        type: 'pie',
        offset: 90,
        width: '100px',
        height: '100px',
        sliceColors: ['#29bd73', '#182973', '#ffcd55']
    })    

    // notification popup
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-bottom-right';
    toastr.options.showDuration = 1000;
    toastr['info']('Hello, welcome to Brego, a unique admin Template.');
    
});



$(function(){
    "use strict";    
    if( $('#world-map-markers').length > 0 ){

        $('#world-map-markers').vectorMap( {
            map: 'world_mill_en',
            backgroundColor: 'transparent',
            borderColor: '#fff',
            borderOpacity: 0.25,
            borderWidth: 0,
            color: '#e6e6e6',
            regionStyle : {
                initial : {
                fill : '#e2e4e7'
                }
            },
            markerStyle: {
                initial: {
                    r: 5,
                    'fill': '#fff',
                    'fill-opacity':1,
                    'stroke': '#000',
                    'stroke-width' : 1,
                    'stroke-opacity': 0.4
                },
            },
        
            markers : [{
                latLng : [21.00, 78.00],
                name : 'INDIA : 350'
            
            },
                {
                latLng : [36.77, -119.41],
                name : 'USA : 250'
                
            },              
                {
                latLng : [48.37, 31.16],
                name : 'UA : 39'
            
            },
                {
                latLng : [35.65, 139.83],
                name : 'JP : 37'
            
            }],

            series: {
                regions: [{
                    values: {
                        "US": '#17C2D7',
                        "IN": '#9367B4',
                        "JP": '#5CB65F',
                        "UA": '#f66d9b',
                    },
                    attribute: 'fill'
                }]
            },

            hoverOpacity: null,
            normalizeFunction: 'linear',
            zoomOnScroll: false,
            scaleColors: ['#000000', '#000000'],
            selectedColor: '#000000',
            selectedRegions: [],
            enableZoom: false,
            hoverColor: '#fff',
        });
    }
});
