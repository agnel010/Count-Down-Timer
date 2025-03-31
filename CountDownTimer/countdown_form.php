<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Countdown Timer</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background: linear-gradient(to right, #8e2de2, #4a00e0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .outer-box {
            width: 100%;
            max-width: 400px;
            background: linear-gradient(to right, rgba(142, 45, 226, 0.9), rgba(74, 0, 224, 0.9));
            padding: 20px;
            border-radius: 10px;
            box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
            color: white;
        }

        h1 {
            color: #fff;
            margin-bottom: 15px;
        }

        p {
            margin-bottom: 10px;
            color: #ddd;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 2px solid #bbb;
            border-radius: 5px;
            font-size: 1rem;
        }

        input {
            background: rgba(255, 255, 255, 0.8);
            text-align: center;
            color: #333;
        }

        .preview {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            margin: 10px 0;
        }

        .controls {
            display: flex;
            gap: 5px;
        }

        button {
            background: linear-gradient(to right, #ff0080, #800080);
            border: none;
            color: white;
            cursor: pointer;
            transition: 0.3s ease;
        }

        button:hover {
            background: linear-gradient(to right, #800080, #ff0080);
        }

        #countdown-display {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 10px;
            color: white;
        }

        .error {
            color: #ff4444;
            margin: 10px 0;
        }

        .success {
            color: #00ff00;
            margin: 10px 0;
        }
        </style>
</head>
<body>
<div class="outer-box">
    <h1>Set a Countdown</h1>
    <p>Enter the countdown details below</p>

    <div id="message"></div>

    <form id="countdown-form" method="POST" action="save_countdown.php">
        <input type="text" id="countdown_name" name="countdown_name" placeholder="Countdown Name" required>
        <input type="number" id="hours" name="hours" min="0" max="24" placeholder="Hours" required>
        <input type="number" id="minutes" name="minutes" min="0" max="59" placeholder="Minutes" required>
        <input type="number" id="seconds" name="seconds" min="0" max="59" placeholder="Seconds" required>
        <div class="preview">Preview: <span id="preview-time">00:00:00</span></div>
        <button type="submit">Start Countdown</button>
    </form>

    <div id="countdown-section" style="display: none;">
        <p>Live Countdown</p>
        <div id="countdown-display">00:00:00</div>
        <div class="controls">
            <button onclick="pauseCountdown()">Pause</button>
            <button onclick="resumeCountdown()">Resume</button>
            <button onclick="resetCountdown()">Reset</button>
        </div>
        <p>Status: <span id="status">Live</span></p>
    </div>
</div>

<script>
    let countdownInterval;
    let timeRemaining;
    let isPaused = false;
    let countdownId = null; // Track the countdown ID

    function updatePreview() {
        let hours = String(document.getElementById("hours").value).padStart(2, '0');
        let minutes = String(document.getElementById("minutes").value).padStart(2, '0');
        let seconds = String(document.getElementById("seconds").value).padStart(2, '0');
        document.getElementById("preview-time").textContent = `${hours}:${minutes}:${seconds}`;
    }

    function startCountdown(hours, minutes, seconds, name, id) {
        countdownId = id; // Store the countdown ID
        document.getElementById("countdown-section").style.display = "block";
        timeRemaining = (hours * 3600) + (minutes * 60) + seconds;
        updateCountdownDisplay();

        countdownInterval = setInterval(() => {
            if (!isPaused) {
                timeRemaining--;
                updateCountdownDisplay();
                if (timeRemaining <= 0) {
                    clearInterval(countdownInterval);
                    document.getElementById("status").textContent = "Completed";
                    updateStatus('completed');
                    alert(name + " countdown completed!");
                }
            }
        }, 1000);
    }

    function updateCountdownDisplay() {
        let hours = Math.floor(timeRemaining / 3600);
        let minutes = Math.floor((timeRemaining % 3600) / 60);
        let seconds = timeRemaining % 60;
        document.getElementById("countdown-display").textContent =
            `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    function updateStatus(newStatus) {
        if (!countdownId) return;

        const formData = new FormData();
        formData.append('countdown_id', countdownId);
        formData.append('status', newStatus);

        fetch('update_status.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                console.error('Status update failed:', data.message);
            }
        })
        .catch(error => console.error('Error updating status:', error));
    }

    function pauseCountdown() {
        isPaused = true;
        document.getElementById("status").textContent = "Paused";
        updateStatus('paused');
    }

    function resumeCountdown() {
        isPaused = false;
        document.getElementById("status").textContent = "Live";
        updateStatus('active');
    }

    function resetCountdown() {
        clearInterval(countdownInterval);
        document.getElementById("countdown-section").style.display = "none";
        document.getElementById("status").textContent = "Live";
        countdownId = null;
    }

    document.getElementById("hours").addEventListener("input", updatePreview);
    document.getElementById("minutes").addEventListener("input", updatePreview);
    document.getElementById("seconds").addEventListener("input", updatePreview);

    document.getElementById("countdown-form").addEventListener("submit", function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);
        
        fetch("save_countdown.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const messageDiv = document.getElementById("message");
            messageDiv.innerHTML = '';
            
            if (data.success) {
                messageDiv.innerHTML = '<div class="success">' + data.message + '</div>';
                const hours = parseInt(formData.get("hours")) || 0;
                const minutes = parseInt(formData.get("minutes")) || 0;
                const seconds = parseInt(formData.get("seconds")) || 0;
                const name = formData.get("countdown_name");
                startCountdown(hours, minutes, seconds, name, data.countdown_id);
            } else {
                messageDiv.innerHTML = '<div class="error">' + data.message + '</div>';
                console.log("Server response:", data);
            }
            setTimeout(() => messageDiv.innerHTML = '', 3000);
        })
        .catch(error => {
            console.error("Fetch error:", error);
            const messageDiv = document.getElementById("message");
            messageDiv.innerHTML = '<div class="error">Error: ' + error.message + '</div>';
            setTimeout(() => messageDiv.innerHTML = '', 3000);
        });
    });
</script>
</body>
</html>