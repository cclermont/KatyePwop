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

// Import calendar graph
import { SVGGraph, CanvasGraph, StrGraph } from 'calendar-graph';
import { rectColor, today, oneYearAgo, diffDays, formatDate } from '../../../node_modules/calendar-graph/src/utils';


$(() => {

	// Add calendar to dashboard
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

});