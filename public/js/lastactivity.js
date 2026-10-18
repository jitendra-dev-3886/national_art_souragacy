
        const lastActivity = new Date("{{ session('last_activity') }}");
        const expireIn = {{ config('session.lifetime') * 60 * 1000 }};

        function updateCountdown() {
            const now = new Date();
            const diff = expireIn - (now - lastActivity);
            if (diff <= 0) {
                document.getElementById("countdown").innerText = "Session expired.";
                window.location.href = "/logout";
                return;
            }
            const minutes = Math.floor(diff / 60000);
            const seconds = Math.floor((diff % 60000) / 1000);
            document.getElementById("countdown").innerText =
                `Session expires in ${minutes}m ${seconds}s`;
        }

        setInterval(updateCountdown, 1000);
