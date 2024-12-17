document.addEventListener('DOMContentLoaded', function () {
    const umServerSelect = document.getElementById('umServerSelect');
    const profilesTable = document.getElementById('profilesTable');

    umServerSelect.addEventListener('change', function () {
        const serverId = this.value;

        if (!serverId) {
            profilesTable.innerHTML = '<p class="text-muted">Select a UM Server to view profiles.</p>';
            return;
        }

        fetch(`/policy/fetch-profiles/${serverId}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    profilesTable.innerHTML = `<p class="text-danger">${data.error}</p>`;
                } else {
                    displayProfiles(data);
                }
            })
            .catch(err => {
                console.error(err);
                profilesTable.innerHTML = '<p class="text-danger">Error fetching profiles. Please try again.</p>';
            });
    });

    window.editProfile = function (id) {
        if (!id) {
            alert('Profile ID is missing.');
            return;
        }
        console.log(`Navigating to edit profile with ID: ${id}`);
        window.location.href = `/policy/edit-profile/${id}`;
    };
    

    function displayProfiles(profiles) {
        const tableHtml = `
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Validity</th>
                        <th>Group</th>
                        <th>Starts When</th>
                        <th>Price (GHC)</th>
                        <th>Override Shared Users</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                    <tbody>
                        ${profiles.map(profile => `
                            <tr>
                                <td>${profile.id || 'N/A'}</td>
                                <td>${profile.name || 'N/A'}</td>
                                <td>${profile.validity || 'N/A'}</td>
                                <td>${profile['name-of-users'] || 'N/A'}</td>
                                <td>${profile['starts-when'] || 'N/A'}</td>
                                <td>${profile.price || 'N/A'}</td>
                                <td>${profile['override-shared-users'] || 'N/A'}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="editProfile('${profile.id}')">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProfile('${profile.id}')">Delete</button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
            </table>`;
        profilesTable.innerHTML = tableHtml;
    }

    window.editProfile = function (id) {
        window.location.href = `/policy/edit-profile/${id}`;
    };

    window.deleteProfile = function (id) {
        if (confirm('Are you sure you want to delete this profile?')) {
            fetch(`/policy/delete-profile/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Profile deleted successfully.');
                        umServerSelect.dispatchEvent(new Event('change')); // Reload profiles
                    } else {
                        alert('Failed to delete profile.');
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('An error occurred. Please try again.');
                });
        }
    };
});