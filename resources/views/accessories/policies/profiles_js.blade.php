<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
    function fetchProfiles(serverId) {
        fetch(`/fetch-profiles`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
            },
            body: JSON.stringify({ server_id: serverId })
        })
        .then(response => {
            if (!response.ok) {
                console.error("Network response was not ok:", response);
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (Array.isArray(data)) {
                displayProfiles(data);
            } else if (data.error) {
                alert("Error fetching profiles: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error fetching profiles:", error);
            alert("Failed to fetch profiles from the selected server.");
        });
    }
    function logError(message) {
        // Send the error log to the server
        fetch('/log-error', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });
    }

    function displayProfiles(profiles) {
        const profilesTable = document.getElementById('profilesTable');
        const tableHtml = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Validity</th>
                        <th>Name For Users</th>
                        <th>Start When</th>
                        <th>Price (GHC)</th>
                        <th>Override Share</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${profiles.map(profile => `
                        <tr>
                            <td>${profile.name || 'N/A'}</td>
                            <td>${profile.validity || 'N/A'}</td>
                            <td>${profile['name-of-users'] || 'N/A'}</td>
                            <td>${profile['start-when'] || 'N/A'}</td>
                            <td>${profile.price || 'N/A'}</td>
                            <td>${profile['override-shared-users'] || 'N/A'}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="editProfile(${profile.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteProfile(${profile.id})">Delete</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>`;
        profilesTable.innerHTML = tableHtml;
    }


    function logError(message) {
        // Send the error log to the server
        fetch('/log-error', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });
    }

    // Reuse for other tabs (limits, profile limits)
    function displayTable(tableId, data, columns, editFunc, deleteFunc) {
        const tableElement = document.getElementById(tableId);
        const tableHtml = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        ${columns.map(col => `<th>${col}</th>`).join('')}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    ${data.map(item => `
                        <tr>
                            ${columns.map(col => `<td>${item[col] || 'N/A'}</td>`).join('')}
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="${editFunc}(${item.id})">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="${deleteFunc}(${item.id})">Delete</button>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>`;
        tableElement.innerHTML = tableHtml;
    }


    // Function to format transfer limit by removing trailing zeros and appending MB or GB
function formatTransferLimit(value) {
    if (!value || isNaN(value)) return 'N/A'; // Handle invalid or missing values

    // Convert the value to a string for processing
    const stringValue = value.toString();

    // Check for nine trailing zeros (convert to GB)
    if (stringValue.endsWith('000000000')) {
        const gbValue = parseInt(stringValue.slice(0, -9), 10); // Remove 9 zeros
        return gbValue + ' G';
    }

    // Check for six trailing zeros (convert to MB)
    if (stringValue.endsWith('000000')) {
        const mbValue = parseInt(stringValue.slice(0, -6), 10); // Remove 6 zeros
        return mbValue + ' M';
    }

    // If neither, return original value
    return value + ' B';
}


    // Fetch Limits and Update the Table
function fetchLimits(serverId) {
    fetch(`/fetch-limits`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ server_id: serverId })
    })
    .then(response => response.ok ? response.json() : Promise.reject("Failed to fetch limits."))
    .then(data => displayLimits(data))
    .catch(error => alert(error));
}


// Display Limits with Formatted Transfer Limit
function displayLimits(limits) {
    const limitsTable = document.getElementById('limitsTable');
    const tableHtml = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Transfer Limit</th>
                    <th>Uptime Limit</th>
                    <th>Rate Limit RX</th>
                    <th>Rate Limit TX</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                ${limits.map(limit => `
                    <tr>
                        <td>${limit.name || 'N/A'}</td>
                        <td>${formatTransferLimit(limit.transfer_limit)}</td>
                        <td>${limit.uptime_limit || 'N/A'}</td>
                        <td>${formatTransferLimit(limit.rate_limit_rx)}</td>
                        <td>${formatTransferLimit(limit.rate_limit_tx)}</td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="editLimit(${limit.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteLimit(${limit.id})">Delete</button>
                        </td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    limitsTable.innerHTML = tableHtml;
}

// Fetch Profile Limits

function fetchProfileLimits(serverId) {
        fetch(`/fetch-profile-limits`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ server_id: serverId })
        })
        .then(response => response.json())
        .then(data => {
            const columns = ['profile', 'limitation'];
            displayTable('profileLimitsTable', data, columns, 'editProfileLimit', 'deleteProfileLimit');
        });
    }

    function editProfile(profileId) {
    if (!profileId) {
        alert("Profile ID is missing.");
        return;
    }

    // Redirect to the edit profile page
    window.location.href = `/profiles/edit/${profileId}`;
}


function deleteProfile(profileId) {
    if (!profileId) {
        alert("Profile ID is missing.");
        return;
    }

    if (confirm('Are you sure you want to delete this profile?')) {
        fetch(`/profiles/delete/${profileId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Profile deleted successfully.');
                document.getElementById('umServerSelect').dispatchEvent(new Event('change')); // Refresh the table
            } else {
                alert('Failed to delete profile: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error deleting profile:', error);
            alert('Failed to delete profile.');
        });
    }
}

// Display Profile Limits
function displayProfileLimits(profileLimits) {
    const profileLimitsTable = document.getElementById('profileLimitsTable');
    const tableHtml = `
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Profile</th>
                    <th>Limitation</th>
                </tr>
            </thead>
            <tbody>
                ${profileLimits.map(limit => `
                    <tr>
                        <td>${limit.profile || 'N/A'}</td>
                        <td>${limit.limitation || 'N/A'}</td>
                    </tr>
                `).join('')}
            </tbody>
        </table>
    `;
    profileLimitsTable.innerHTML = tableHtml;
}



// Add Event Listener for Dropdown Change
document.getElementById('umServerSelect').addEventListener('change', function() {
    const serverId = this.value;
    if (!serverId) return;

    // Call Fetch Functions
    fetchProfiles(serverId);       // Fetch Profiles
    fetchLimits(serverId);         // Fetch Limits
    fetchProfileLimits(serverId);  // Fetch Profile Limits
});


// JavaScript code for handling dropdown and add button
document.addEventListener('DOMContentLoaded', function () {
    const dropdownItems = document.querySelectorAll('.dropdown-item');
    const addButton = document.getElementById('addButton');
    let selectedAction = null; // Default to no action

    // Update selected action based on the dropdown selection
    dropdownItems.forEach(item => {
        item.addEventListener('click', function () {
            selectedAction = this.dataset.action; // Retrieve the action from `data-action` attribute
            document.getElementById('createOptions').textContent = this.textContent; // Update button text
        });
    });

    // Handle the "Add" button click
    addButton.addEventListener('click', function () {
        if (!selectedAction) {
            alert('Please select an action from the dropdown before proceeding.');
            return;
        }

        // Redirect based on the selected action
        let route;
        switch (selectedAction) {
            case 'limits':
                route = "{{ route('create_limits') }}";
                break;
            case 'profile':
                route = "{{ route('create_profile') }}";
                break;
            case 'profile_limitation':
                route = "{{ route('create_profile_limitation') }}";
                break;
            default:
                alert('Invalid action selected.');
                return;
        }

        // Redirect to the corresponding route
        window.location.href = route;
    });
});

    function editLimit(id) { window.location.href = `/limits/edit/${id}`; }
    function deleteLimit(id) { if (confirm('Delete this limit?')) fetch(`/limits/delete/${id}`, { method: 'DELETE' }); }
    function editProfileLimit(id) { window.location.href = `/profilelimits/edit/${id}`; }
    function deleteProfileLimit(id) { if (confirm('Delete this profile limit?')) fetch(`/profilelimits/delete/${id}`, { method: 'DELETE' }); }

</script>