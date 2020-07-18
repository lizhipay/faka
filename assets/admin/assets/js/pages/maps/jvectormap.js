$(function () {
    
    if( $('#world-map-markers').length > 0 ){

        $('#world-map-markers').vectorMap(
        {
            map: 'world_mill_en',
            backgroundColor: 'transparent',
            borderColor: '#fff',
            borderOpacity: 0.25,
            borderWidth: 0,
            color: '#e6e6e6',
            regionStyle : {
                initial : {
                fill : '#394456'
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
                latLng : [-33.00, 151.00],
                name : 'Australia : 250'
                
            },
                {
                latLng : [36.77, -119.41],
                name : 'USA : 250'
                
            },
                {
                latLng : [55.37, -3.41],
                name : 'UK   : 250'
                
            },
                {
                latLng : [25.20, 55.27],
                name : 'UAE : 250'
            
            },
                {
                latLng : [35.65, 139.83],
                name : 'JP : 37'
            
            },
                {
                latLng : [-23.53, -46.62],
                name : 'BR : 162'
            
            },
                {
                latLng : [50.43, 30.51],
                name : 'UA : 129'
            
            }],

            series: {
                regions: [{
                    values: {
                        "US": '#ffec94',
                        "SA": '#ffaeae',
                        "AU": '#64e2d4',
                        "IN": '#b0e57c',
                        "GB": '#b4d8e7',
                        "JP": '#56baec',
                        "BR": '#fe8282',
                        "UA": '#e2ffcf',
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

    $('#india').vectorMap({
        map : 'in_mill',
        backgroundColor : 'transparent',
        regionStyle : {
            initial : {
                fill : '#f66d9b'
            }
        }
    });    
    
    $('#usa').vectorMap({
        map : 'us_aea_en',
        backgroundColor : 'transparent',
        regionStyle : {
            initial : {
                fill : '#9367B4'
            }
        }
    });           
            
    $('#australia').vectorMap({
        map : 'au_mill',
        backgroundColor : 'transparent',
        regionStyle : {
            initial : {
                fill : '#5CB65F'
            }
        }
    });
            
    $('#uk').vectorMap({
        map : 'uk_mill_en',
        backgroundColor : 'transparent',
        regionStyle : {
            initial : {
                fill : '#17C2D7'
            }
        }
    });
});