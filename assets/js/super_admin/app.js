/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../../scss/super_admin/app.scss';

// Jquery
import $ from 'jquery';

// Toasttr
import toastr from 'toastr';

// Import calendar graph
import { SVGGraph, CanvasGraph, StrGraph } from 'calendar-graph';
import { rectColor, today, oneYearAgo, diffDays, formatDate } from '../../../node_modules/calendar-graph/src/utils';


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

	// Filter table list
	// Display content that match
	if ($("#contentList").length > 0) {

		$(document).on('keyup', "#contentFilterInput", function(e) {
			if ($(this).val().length > 0) {
				$("#contentList tbody tr")
					.stop()
					.hide('fast', () => { toggleEmptyMsg() })
					.each((i, item) => {
						if ($(item).data("keys").indexOf($(this).val().toLowerCase()) > 0) {
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
		
		const data = [
		  { date: '2018-01-01', count: 16 },
		  { date: '2018-03-03', count: 34 },
		  { date: '2018-03-04', count: 54 },
		  { date: '2018-05-06', count: 200 },
		  // ...and so on
		];

		new SVGGraph('[data-type="calendar-graph"]', data, {
		  	startDate: oneYearAgo(),
		  	endDate: today(),
		  	colorFun: (v) => {
		    	return rectColor(v);
		  	}
		});

		// Add tooltip
		$('[data-type="calendar-graph"] .cg-day').hover((e) => {
			var text = `${$(e.target).attr("data-count")} contributions on ${$(e.target).attr("data-date")}`;
			$(e.target).tooltip({title: text, trigger: "manual"}).tooltip("show");
		}, (e) => {
			$(e.target).tooltip("hide");
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