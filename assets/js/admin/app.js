/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../../scss/admin/app.scss';
import "tui-calendar/dist/tui-calendar.css";

// Jquery
import $ from 'jquery';

// Toasttr
import toastr from 'toastr';

// Import Chart js
import Chart from 'chart.js';

// Import Ekko light box
import 'ekko-lightbox'

// Import Full calendar component
// import listPlugin from '@fullcalendar/list';
// import { Calendar } from '@fullcalendar/core';
// import dayGridPlugin from '@fullcalendar/daygrid';
// import timeGridPlugin from '@fullcalendar/timegrid';
// import timelinePlugin from '@fullcalendar/timeline';
// import interactionPlugin from '@fullcalendar/interaction';

// TUI Calendar
import Calendar from 'tui-calendar';

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

	// TUI Calendar
	// register templates
  const templates = {
	    popupIsAllDay: function() {
	      return 'Tous les jours';
	    },
	    popupStateFree: function() {
	      return 'Libre';
	    },
	    popupStateBusy: function() {
	      return 'Occupé';
	    },
	    titlePlaceholder: function() {
	      return 'Sujet';
	    },
	    locationPlaceholder: function() {
	      return 'Localité';
	    },
	    startDatePlaceholder: function() {
	      return 'Date de début';
	    },
	    endDatePlaceholder: function() {
	      return 'Date de fin';
	    },
	    popupSave: function() {
	      return 'Enregistrer';
	    },
	    popupUpdate: function() {
	      return 'Modifier';
	    },
	    popupDetailDate: function(isAllDay, start, end) {
	      var isSameDate = moment(start).isSame(end);
	      var endFormat = (isSameDate ? '' : 'YYYY.MM.DD ') + 'hh:mm a';

	      if (isAllDay) {
	        return moment(start).format('YYYY.MM.DD') + (isSameDate ? '' : ' - ' + moment(end).format('YYYY.MM.DD'));
	      }

	      return (moment(start).format('YYYY.MM.DD hh:mm a') + ' - ' + moment(end).format(endFormat));
	    },
	    popupDetailLocation: function(schedule) {
	      return 'Location : ' + schedule.location;
	    },
	    popupDetailUser: function(schedule) {
	      return 'User : ' + (schedule.attendees || []).join(', ');
	    },
	    popupDetailState: function(schedule) {
	      return 'State : ' + schedule.state || 'Busy';
	    },
	    popupDetailRepeat: function(schedule) {
	      return 'Repeat : ' + schedule.recurrenceRule;
	    },
	    popupDetailBody: function(schedule) {
	      return 'Body : ' + schedule.body;
	    },
	    popupEdit: function() {
	      return 'Edit';
	    },
	    popupDelete: function() {
	      return 'Delete';
	    }
  	};

	if ($('[data-type="fullcalendar"]').length > 0) {
		
		var calendar = new Calendar('[data-type="fullcalendar"]', {
	  		defaultView: 'month',
	  		taskView: true,
	  		template: templates,
		    useCreationPopup: true,
		    useDetailPopup: true
		});

		calendar.on('beforeCreateSchedule', function(event) {
			alert("Create schedule");
			console.log("Event calendar");
			console.log(event);
			calendar.createSchedules([event]);
			calendar.render()
		});
	}

	// Message form
	$(document).on('click', 'input[data-type="posponed"]', function (event) {
		$('div[data-type="send-date-wrapper"]').toggleClass('d-none');
	});

	$(document).on('click', 'input[data-type="repeat"]', function (event) {
		$('div[data-type="repeat-wrapper"]').toggleClass('d-none');
	});

	$(document).on('click', 'input[data-type="customRepeated"]', function (event) {
		$('div[data-type="repeat-default"]').toggleClass('d-none');
		$('div[data-type="customRepeated-frequency-wrapper"]').toggleClass('d-none');
	});

	$('select[data-type="customRepeated-frequency"]').change(function (event) {
		
		$('div[data-type="customRepeated-every-wrapper"]').removeClass('d-none');
		$('div[data-type="customRepeated-week-wrapper"]').addClass('d-none');
		$('div[data-type="customRepeated-month-wrapper"]').addClass('d-none');
		$('div[data-type="customRepeated-year-wrapper"]').addClass('d-none');
		
		var every = '__n__ ';

		switch($(this).val()) {
			case 'weekly':
				every += 'semaine';
				$('div[data-type="customRepeated-week-wrapper"]').removeClass('d-none');
			break;
			case 'monthly':
				every += 'mois';
				$('div[data-type="customRepeated-month-wrapper"]').removeClass('d-none');
			break;
			case 'yearly':
				every += 'année';
				$('div[data-type="customRepeated-year-wrapper"]').removeClass('d-none');
			break;
			case 'daily':
				every += 'jour';
			break;
			default:
				$('div[data-type="customRepeated-every-wrapper"]').addClass('d-none');
		}

		$('[data-type="customRepeated-every"]').find('option').each(function(index, el) {
			var val = $(el).attr('value');
			if ($.trim(val).length > 0) {
				var text = every;
				text = text.replace('__n__', val);
				if ((text.indexOf('jour') > -1 || text.indexOf('année') > -1 || text.indexOf('semaine') > -1) && val > 1) {
					text += 's';
				}
				$(el).text(text);
			}
		});
	});
});