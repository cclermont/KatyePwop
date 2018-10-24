/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../../scss/admin/app.scss';

// Jquery
import $ from 'jquery';

// Toasttr
import toastr from 'toastr';

// Import Chart js
import Chart from 'chart.js';

// Import Ekko light box
import 'ekko-lightbox'

// Import video js
import Videojs from '../../../node_modules/video.js/dist/video.min'

// Import jquery image preview
import '../../../node_modules/jquery.upload.preview.psk/assets/js/jquery.uploadPreview';

// Import calendar graph
import { SVGGraph, CanvasGraph, StrGraph } from 'calendar-graph';
import { rectColor, today, oneYearAgo, diffDays, formatDate } from '../shared/utils';


$(() => {

	// Enable boostrap 4 tooltip
	$('[data-toggle="tooltip"]').tooltip();

	// Init Toast tr notification
	if ($("[data-notify]").length > 0 && $("[data-notify]").data("notify").length > 0) {
		switch($("[data-notify]").data("notify-type")){
			case "error":
				toastr.error($("[data-notify]").data("notify"));
			break;
			case "success":
				toastr.success($("[data-notify]").data("notify"));
			break;
		}
	}

	// Lightbox image gallery
	$(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    // Modal and video player
    $('#videoModal').on('shown.bs.modal', function (e) {
    	var player = Videojs('video-player');
		player.ready(() => {
			 player.play();
		});
	});
	$('#videoModal').on('hide.bs.modal', function (e) {
		var player = Videojs('video-player');
		player.ready(() => {
			 player.pause();
		});
	});

	// Filter table list
	// Display content that match
	if ($("#contentList").length > 0) {

		$(document).on('keyup', "#contentFilterInput", function(e) {
			if ($(this).val().length > 0) {
				$("#contentList tbody tr")
					.stop()
					.hide('fast', () => { toggleEmptyMsg() })
					.each((i, item) => {
						if ($(item).data("keys").indexOf($(this).val().toLowerCase()) > -1) {
							$(item).stop().show('fast', () => { toggleEmptyMsg() });
						}
					});
			} else {
				$("#contentList tbody tr").stop().show('fast', () => { toggleEmptyMsg() });
			}

			
		});

		// Toggle empty msg
		function toggleEmptyMsg(){
			if ($("#contentList tbody tr").length == 0 || $("#contentList tbody tr:visible").length == 0) {
				$("#emptyMsg").removeClass('d-none');
			} else {
				$("#emptyMsg").addClass('d-none');
			}
		}
	}

	// Add calendar to dashboard
	// Calendar graph config
	if ($('[data-type="calendar-graph"]').length > 0) {
		
		const data = $('[data-type="calendar-graph"]').data('values');

		new SVGGraph('[data-type="calendar-graph"]', data, {
		  	startDate: oneYearAgo(),
		  	endDate: today(),
		  	colorFun: (v) => {
		    	return rectColor(v);
		  	}
		});

		// Add tooltip
		$('[data-type="calendar-graph"] .cg-day').hover((e) => {
			var text = $(e.target).attr("data-count") + " messages le " + $(e.target).attr("data-date");
			$(e.target).tooltip({title: text, trigger: "manual"}).tooltip("show");
		}, (e) => {
			$(e.target).tooltip("hide");
		});
	}

	// Add Pie chart to dashboard
	if ($('[data-type="pie-chart"]').length > 0) {

		var data = {
			    datasets: [{
			        data: $('[data-type="pie-chart"]').data("values"),
			        backgroundColor: [
			            '#ff6384',
			            '#36a2eb',
			            '#cc65fe',
			            '#ffce56'
			        ]
			    }],

			    // These labels appear in the legend and in the tooltips when hovering different arcs
			    labels: $('[data-type="pie-chart"]').data("labels")
			};

		new Chart($('[data-type="pie-chart"]'),{
		    type: 'pie',
		    data: data,
		    options: {
		    	cutoutPercentage: 20,
		    	legend: {
		    		display: true,
		    		position: 'right'
		    	}
		    }
		});
	}

	// Display img preview when choosen a file
	if ($('[data-type="profile-pic-container"]').length > 0) {
		$.uploadPreview({
		    input_field: '[data-type="upload-btn"] input',
		    preview_box: '[data-type="profile-pic"]',
		    label_field: '[data-type="upload-btn"] span',
		    label_default: $('[data-type="upload-btn"]').data("label-default"),
		    label_selected: $('[data-type="upload-btn"]').data("label-selected")
		});
	}

	// Handling the modal confirmation message.
	$(document).on('submit', 'form[data-confirmation]', function (event) {
	    var $form = $(this),
	        $confirm = $('#confirmationModal');

	    if ($confirm.data('result') !== 'yes') {
	        //cancel submit event
	        event.preventDefault();

	        $confirm
	            .off('click', '#btnYes')
	            .on('click', '#btnYes', function () {
	                $confirm.data('result', 'yes');
	                $form.find('input[type="submit"]').attr('disabled', 'disabled');
	                $form.submit();
	            })
	            .modal('show');
	    }
	});

});