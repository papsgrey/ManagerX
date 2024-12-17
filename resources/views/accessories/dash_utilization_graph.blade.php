<script>
    function showUtilization(service) {
        // Get the title element
        const titleElement = document.getElementById('live-view-title');

        // Logic to update the utilization details and title based on the selected service
        if (service === 'broadband') {
            titleElement.innerHTML = 'Live View Broadband';
            document.getElementById('customers-count').innerHTML = '9851';
            document.getElementById('projects-count').innerHTML = '1026';
            document.getElementById('revenue-count').innerHTML = '228.89';
            document.getElementById('hours-count').innerHTML = '10589';
        } else if (service === 'hotspot') {
            titleElement.innerHTML = 'Live View Hotspot';
            document.getElementById('customers-count').innerHTML = '520';
            document.getElementById('projects-count').innerHTML = '150';
            document.getElementById('revenue-count').innerHTML = '100.50';
            document.getElementById('hours-count').innerHTML = '2589';
        }
    }
</script>

<script>
    // Initialize Flatpickr for both input fields
    flatpickr("#from-date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: new Date(), // Default to current date and time
        onChange: function(selectedDates, dateStr, instance) {
            console.log("Selected From Date: ", dateStr);
        }
    });

    flatpickr("#to-date", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        defaultDate: new Date(new Date().getTime() + (24 * 60 * 60 * 1000)), // Default to the next day
        onChange: function(selectedDates, dateStr, instance) {
            console.log("Selected To Date: ", dateStr);
        }
    });

    // Function to handle the "Update" button click
    function updateDateRange() {
        let fromDate = document.getElementById('from-date').value;
        let toDate = document.getElementById('to-date').value;

        console.log("From: ", fromDate);
        console.log("To: ", toDate);

        // Example: Update your chart or data based on selected dates
        // updateChart(fromDate, toDate);
    }
</script>


