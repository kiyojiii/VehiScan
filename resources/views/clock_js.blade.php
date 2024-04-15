<style>
    .clock {
        border: 2px solid #f7d853;
        background-color: #a41d21;
        padding: 10px;
        color: white;
    }
</style>
<script>
    function updateClock() {
    var currentTime = new Date();
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var day = days[currentTime.getDay()];
    var month = months[currentTime.getMonth()];
    var date = currentTime.getDate();
    var year = currentTime.getFullYear();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    var seconds = currentTime.getSeconds();
    var meridiem = hours < 12 ? 'AM' : 'PM';

    // Convert hours from 24-hour to 12-hour format
    hours = hours % 12;
    hours = hours ? hours : 12; // If hours is 0, set it to 12

    // Add leading zeros to minutes and seconds if they are less than 10
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    // Construct the formatted time string
    var timeString = day + ', ' + month + ' ' + date + ', ' + year + ', ' + hours + ':' + minutes + ':' + seconds + ' ' + meridiem;

    // Update the clock element with the new time
    document.getElementById('digitalClock').textContent = timeString;
}

// Update the clock every second
setInterval(updateClock, 1000);

// Initial call to display the clock immediately
updateClock();
</script>