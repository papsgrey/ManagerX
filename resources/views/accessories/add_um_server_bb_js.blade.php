<script>
    // Store servers
    let serverList = [];

    // Handle form submission
    document.getElementById('um-server-form').addEventListener('submit', function (event) {
    event.preventDefault();

    // Capture form values
    const serverName = document.getElementById('server-name').value;
    const serverIp = document.getElementById('server-ip').value;
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Create server object
    const server = {
        name: serverName,
        ip: serverIp,
        username: username,
        password: password,
        status: 'Offline' // Default status for now
    };

    // Send form data to server using fetch API
    fetch('{{ route('show_list_umservers') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(server)
    })
    .then(response => response.json())
    .then(data => {
        // Update the server list UI
        updateServerList();

        // Close the modal
        var modal = new bootstrap.Modal(document.getElementById('addUMServerModal'));
        modal.hide();

        // Clear form
        document.getElementById('um-server-form').reset();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

// Update server list in the UI (Table Format)
function updateServerList() {
    const serverTableBody = document.getElementById('server-table-body');
    serverTableBody.innerHTML = ''; // Clear existing rows

    // Fetch server list from server
    fetch('{{ route('show_list_umservers') }}')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        // Check if data is an array
        if (Array.isArray(data)) {
            data.forEach((server, index) => {
                const serverRow = `
                    <tr>
                        <th scope="row">${index + 1}</th>
                        <td>${server.server_name}</td>
                        <td>${server.ip_address}</td>
                        <td>${server.username}</td>
                        <td>
                            <span class="badge ${server.status === 'Online' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger'}">
                                ${server.status}
                            </span>
                        </td>
                    </tr>
                `;
                serverTableBody.innerHTML += serverRow;
            });
        } else {
            console.error('Unexpected data format:', data);
        }
    })
    .catch(error => {
        console.error('Error fetching server list:', error);
    });
}

// Call this function when you want to update the server list
document.addEventListener('DOMContentLoaded', updateServerList);
</script>

