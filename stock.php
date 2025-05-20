
<!--<script>
    setTimeout(function() {window.location.href = "compte.php"; }, 2000); // 2000 millisecondes = 2 s
</script>
<div id="calendar"></div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            {
                title: 'Tâche 1',
                start: '2023-10-10',
                end: '2023-10-12'
            },
            // Ajouter d'autres tâches ici
        ]
    });
    calendar.render();
});
</script>-->
<script>
    function showNotification(title, message) {
    if (Notification.permission === 'granted') {
        new Notification(title, { body: message });
    } else if (Notification.permission !== 'denied') {
        Notification.requestPermission().then(permission => {
            if (permission === 'granted') {
                new Notification(title, { body: message });
            }
        });
    }
}

// Exemple d'utilisation
showNotification('Rappel', 'Vous avez une tâche à faire aujourd\'hui !');
</script>


<canvas id="taskChart"></canvas>

<script>
    const ctx = document.getElementById('taskChart').getContext('2d');
const taskChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Terminées', 'En cours', 'En retard'],
        datasets: [{
            label: 'Tâches',
            data: [12, 19, 3],
            backgroundColor: ['#28a745', '#007BFF', '#dc3545']
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>