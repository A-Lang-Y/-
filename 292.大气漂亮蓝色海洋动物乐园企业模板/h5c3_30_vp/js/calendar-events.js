$(document).ready(function() {
	
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();
		
		$('#calendar').fullCalendar({
			editable: true,
			events: [
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, 1)
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, d-5)
				},
				{
					id: 999,
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, d-3, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, d, 10, 30)
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, d+1, 19, 0),
					allDay: false
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m, 28),
					url: '#'
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m+1, 12)
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m+1, d+5)
				},
				{
					id: 999,
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m+1, d-6, 16, 0),
					allDay: false
				},
				{
					id: 999,
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m+1, d+4, 16, 0),
					allDay: false
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m-1, d-2, 10, 30)
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m-1, d+5, 19, 0),
					allDay: false
				},
				{
					title: 'Ut wisi eniminim venm quis nostrud',
					start: new Date(y, m-1, 28),
					url: '#'
				}
			]
		});
		
	});