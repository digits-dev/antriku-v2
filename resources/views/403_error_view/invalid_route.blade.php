<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied</title>
    <style>
        :root {
            --primary: #ff5a5f;
            --secondary: #3a3a3a;
            --background: #f8f9fa;
            --text: #333333;
            --shadow: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            background-color: var(--background);
            color: var(--text);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
        }

        .container {
            max-width: 800px;
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 10px 30px var(--shadow);
            position: relative;
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
        }

        .lock-icon {
            width: 120px;
            height: 120px;
            margin-bottom: 30px;
            position: relative;
        }

        .lock-body {
            width: 60px;
            height: 45px;
            background-color: var(--secondary);
            border-radius: 8px;
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: lockBody 1s ease-in-out;
        }

        .lock-hole {
            width: 20px;
            height: 10px;
            background-color: var(--background);
            border-radius: 50%;
            position: absolute;
            bottom: 18px;
            left: 50%;
            transform: translateX(-50%);
        }

        .lock-arc {
            width: 76px;
            height: 76px;
            border: 12px solid var(--primary);
            border-bottom: none;
            border-radius: 50px 50px 0 0;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            animation: lockArc 1s ease-in-out;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 16px;
            color: var(--primary);
            font-weight: 700;
            animation: slideUp 0.6s ease-out;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 24px;
            color: var(--secondary);
            font-weight: 600;
            animation: slideUp 0.7s ease-out;
        }

        p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 32px;
            color: #666;
            animation: slideUp 0.8s ease-out;
        }

        .btn {
            display: inline-block;
            padding: 14px 32px;
            background-color: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: 0 4px 12px rgba(255, 90, 95, 0.3);
            animation: slideUp 0.9s ease-out;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(255, 90, 95, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: var(--primary);
            border-radius: 50%;
            opacity: 0.2;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes lockBody {
            0% {
                transform: translateX(-50%) translateY(-20px);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateX(-50%) translateY(0);
            }
        }

        @keyframes lockArc {
            0% {
                transform: translateX(-50%) translateY(-20px) scale(0.8);
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                transform: translateX(-50%) translateY(0) scale(1);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
            
            h2 {
                font-size: 1.2rem;
            }
            
            .lock-icon {
                width: 100px;
                height: 100px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="lock-icon">
            <div class="lock-arc"></div>
            <div class="lock-body">
                <div class="lock-hole"></div>
            </div>
        </div>
        
        <h1>Access Denied</h1>
        <h2>403 Forbidden</h2>
        
        <p>
            Sorry, you don't have permission to access this page. 
            Please contact <b>Information Technology Group (ITG)</b> if you believe this is an error.
        </p>
        
        <a href="/admin" class="btn">Return to Home</a>
        
        <div class="particles" id="particles"></div>
    </div>

    <script>
        // Create animated particles in the background
        const particlesContainer = document.getElementById('particles');
        const particleCount = 20;
        
        for (let i = 0; i < particleCount; i++) {
            createParticle();
        }
        
        function createParticle() {
            const particle = document.createElement('div');
            particle.classList.add('particle');
            
            // Random position
            const posX = Math.random() * 100;
            const posY = Math.random() * 100;
            
            // Random size
            const size = Math.random() * 8 + 4;
            
            // Random opacity
            const opacity = Math.random() * 0.2 + 0.1;
            
            // Apply styles
            particle.style.left = `${posX}%`;
            particle.style.top = `${posY}%`;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            particle.style.opacity = opacity;
            
            // Add to container
            particlesContainer.appendChild(particle);
            
            // Animate
            animateParticle(particle);
        }
        
        function animateParticle(particle) {
            // Random movement
            const duration = Math.random() * 10 + 10;
            const xMove = Math.random() * 40 - 20;
            const yMove = Math.random() * 40 - 20;
            
            particle.style.transition = `transform ${duration}s linear, opacity ${duration}s linear`;
            particle.style.transform = `translate(${xMove}px, ${yMove}px)`;
            particle.style.opacity = '0';
            
            // Remove and recreate
            setTimeout(() => {
                particle.remove();
                createParticle();
            }, duration * 1000);
        }
    </script>
</body>
</html>