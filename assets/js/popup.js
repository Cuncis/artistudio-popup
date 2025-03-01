document.addEventListener('DOMContentLoaded', function () {
    new Vue({
        el: '#my-vue-popup',
        data: {
            showPopup: false,
            popupData: {
                title: '',
                description: '',
            }
        },
        mounted() {
            // Get the page ID dynamically (assuming it's stored in a global JS variable)
            let pageId = document.body.getAttribute('data-page-id'); // Adjust as needed

            // Fetch data from the WordPress REST API with page filter
            fetch(`/wp-json/artistudio/v1/popups?page_id=${pageId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        this.popupData = data[0]; // Assuming first popup entry
                        setTimeout(() => {
                            this.showPopup = true;
                        }, 2000);
                    }
                })
                .catch(error => console.error('Error fetching popup data:', error));
        },
        methods: {
            closePopup() {
                this.showPopup = false;
            }
        }
    });
});

