<script>
document.addEventListener('DOMContentLoaded', function () {
    const loadButton = document.getElementById('loadButton');
    const umServerSelect = document.getElementById('um-server');
    const profileSelect = document.getElementById('profile');
    const limitationSelect = document.getElementById('limitation');
    const createButton = document.getElementById('createButton');

    // Function to show notifications
    function showNotification(message, type) {
        const notification = document.getElementById('notification');
        notification.className = `alert alert-${type}`;
        notification.textContent = message;
        notification.classList.remove('d-none');

        setTimeout(() => {
            notification.classList.add('d-none');
        }, 3000);
    }

    // Handle Load Button Click
    loadButton.addEventListener('click', function () {
        const serverId = umServerSelect.value;

        if (!serverId) {
            showNotification('Please select a UM Server first.', 'danger');
            return;
        }

        profileSelect.disabled = true;
        limitationSelect.disabled = true;
        createButton.disabled = true;

        let profilesLoaded = false;
        let limitationsLoaded = false;

        // Fetch Profiles
        fetch(`/api/fetch-profiles/${serverId}`)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    profileSelect.innerHTML = '<option value="">Select Profile</option>' +
                        data.map(profile => `<option value="${profile.name}">${profile.name}</option>`).join('');
                    profileSelect.disabled = false;
                } else {
                    showNotification(data.error || 'Failed to fetch profiles.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error fetching profiles:', error);
                showNotification('Error fetching profiles.', 'danger');
            });

        // Fetch Limits
        fetch(`/api/fetch-limitations/${serverId}`)
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)) {
                    limitationSelect.innerHTML = '<option value="">Select Limits</option>' +
                        data.map(limit => `<option value="${limit.name}">${limit.name}</option>`).join('');
                    limitationSelect.disabled = false;
                    createButton.disabled = false;
                    showNotification('Profiles and limits loaded successfully!', 'success');
                } else {
                    showNotification(data.error || 'Failed to fetch limits.', 'danger');
                }
            })
            .catch(error => {
                console.error('Error fetching limits:', error);
                showNotification('Error fetching limits.', 'danger');
            })
            .finally(() => {
                if (profilesLoaded && limitationsLoaded) {
                    createButton.disabled = false;
                    showNotification('Profiles and limits loaded successfully!', 'success');
                }
            });
    });
});
</script>