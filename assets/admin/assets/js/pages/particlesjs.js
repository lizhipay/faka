particlesJS("particles-js", {
	"particles": {
		"number": {
			"value": 30,
			"density": {
				"enable": true,
				"value_area": 700
			}
		},
		"color": {
			"value": ["#fc3c5f", "#993cfc", "#3ca9fc", "#3cfc5f", "#fcdf3c"]
		},
		"shape": {
			"type": "circle",
			"stroke": {
				"width": 0,
				"color": "#000000"
			},
			"polygon": {
				"nb_sides": 15
			}
		},
		"opacity": {
			"value": 0.5,
			"random": false,
			"anim": {
				"enable": false,
				"speed": 1.2,
				"opacity_min": 0.15,
				"sync": false
			}
		},
		"size": {
			"value": 2.5,
			"random": false,
			"anim": {
				"enable": true,
				"speed": 2,
				"size_min": 0.15,
				"sync": false
			}
		},
		"line_linked": {
			"enable": true,
			"distance": 110,
			"color": "#d6d6d6",
			"opacity": 1,
			"width": 1
		},
		"move": {
			"enable": true,
			"speed": 1.6,
			"direction": "none",
			"random": false,
			"straight": false,
			"out_mode": "out",
			"bounce": false,
			"attract": {
				"enable": false,
				"rotateX": 600,
				"rotateY": 1200
			}
		}
	},
	"interactivity": {
		"detect_on": "canvas",
		"events": {
			"onhover": {
				"enable": false,
				"mode": "repulse"
			},
			"onclick": {
				"enable": false,
				"mode": "push"
			},
			"resize": true
		},
		"modes": {
			"grab": {
				"distance": 400,
				"line_linked": {
					"opacity": 1
				}
			},
			"bubble": {
				"distance": 400,
				"size": 30,
				"duration": 2,
				"opacity": 8,
				"speed": 3
			},
			"repulse": {
				"distance": 200,
				"duration": 0.4
			},
			"push": {
				"particles_nb": 4
			},
			"remove": {
				"particles_nb": 2
			}
		}
	},
	"retina_detect": true
});