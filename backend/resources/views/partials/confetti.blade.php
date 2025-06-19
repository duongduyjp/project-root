<!-- Confetti & Teddy Bear Effect (dùng chung) -->
<div id="fireworks-container"></div>
<style>
#fireworks-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 99999;
    overflow: hidden;
}
.firework {
    position: absolute;
    width: 30px;
    height: 30px;
    pointer-events: none;
    border-radius: 3px;
    box-shadow: 0 0 8px rgba(0,0,0,0.3);
}
.firework-1 { background: #ff0000; }
.firework-2 { background: #00ff00; }
.firework-3 { background: #0000ff; }
.firework-4 { background: #ffff00; }
.firework-5 { background: #ff00ff; }
.firework-6 { background: #00ffff; }
.firework-7 { background: #ff8800; }
.firework-8 { background: #8800ff; }
.teddy-bear {
    position: absolute;
    font-size: 50px;
    pointer-events: none;
    z-index: 99999;
    filter: drop-shadow(3px 3px 6px rgba(0,0,0,0.4));
}
@keyframes teddyFloat {
    0% {
        transform: translate(0, 0) rotate(0deg) scale(0.5);
        opacity: 1;
    }
    25% {
        transform: translate(var(--x), var(--y)) rotate(90deg) scale(0.8);
        opacity: 1;
    }
    50% {
        transform: translate(calc(var(--x) * 2), calc(var(--y) * 2)) rotate(180deg) scale(1);
        opacity: 1;
    }
    75% {
        transform: translate(calc(var(--x) * 3), calc(var(--y) * 3)) rotate(270deg) scale(1.2);
        opacity: 1;
    }
    100% {
        transform: translate(calc(var(--x) * 4), calc(var(--y) * 4)) rotate(360deg) scale(1.5);
        opacity: 0;
    }
}
.teddy-animation {
    animation: teddyFloat 4s ease-out forwards;
}
@keyframes confetti {
    0% {
        transform: translate(0, 0) rotate(0deg);
        opacity: 1;
    }
    25% {
        transform: translate(var(--x), var(--y)) rotate(90deg);
        opacity: 1;
    }
    50% {
        transform: translate(calc(var(--x) * 2), calc(var(--y) * 2)) rotate(180deg);
        opacity: 1;
    }
    75% {
        transform: translate(calc(var(--x) * 3), calc(var(--y) * 3)) rotate(270deg);
        opacity: 1;
    }
    100% {
        transform: translate(calc(var(--x) * 4), calc(var(--y) * 4)) rotate(360deg);
        opacity: 0;
    }
}
.firework-animation {
    animation: confetti 3s ease-out forwards;
}
</style>
<script>
window.createConfetti = function() {
    const colors = ['firework-1', 'firework-2', 'firework-3', 'firework-4', 'firework-5', 'firework-6', 'firework-7', 'firework-8'];
    const teddyBears = ['🧸', '🐻', '🐨', '🐼', '🦊', '🐰', '🐱', '🐶'];
    const container = document.getElementById('fireworks-container');
    const centerX = window.innerWidth / 2;
    const centerY = window.innerHeight / 2;
    for (let i = 0; i < 80; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            const color = colors[Math.floor(Math.random() * colors.length)];
            confetti.className = `firework ${color}`;
            const shapes = ['square', 'circle', 'triangle'];
            const shape = shapes[Math.floor(Math.random() * shapes.length)];
            if (shape === 'circle') {
                confetti.style.borderRadius = '50%';
            } else if (shape === 'triangle') {
                confetti.style.width = '0';
                confetti.style.height = '0';
                confetti.style.borderLeft = '12px solid transparent';
                confetti.style.borderRight = '12px solid transparent';
                confetti.style.borderBottom = '25px solid ' + getComputedStyle(document.querySelector('.' + color)).backgroundColor;
                confetti.style.background = 'transparent';
            }
            confetti.style.left = centerX + 'px';
            confetti.style.top = centerY + 'px';
            confetti.style.position = 'fixed';
            const angle = Math.random() * 360;
            const distance = 100 + Math.random() * 200;
            const x = Math.cos(angle * Math.PI / 180) * distance;
            const y = Math.sin(angle * Math.PI / 180) * distance;
            confetti.style.setProperty('--x', x + 'px');
            confetti.style.setProperty('--y', y + 'px');
            container.appendChild(confetti);
            setTimeout(() => {
                confetti.classList.add('firework-animation');
            }, 10);
            setTimeout(() => {
                if (confetti.parentNode) {
                    confetti.parentNode.removeChild(confetti);
                }
            }, 3000);
        }, i * 40);
    }
    for (let i = 0; i < 15; i++) {
        setTimeout(() => {
            const teddy = document.createElement('div');
            const teddyEmoji = teddyBears[Math.floor(Math.random() * teddyBears.length)];
            teddy.className = 'teddy-bear';
            teddy.textContent = teddyEmoji;
            teddy.style.left = centerX + 'px';
            teddy.style.top = centerY + 'px';
            teddy.style.position = 'fixed';
            const angle = Math.random() * 360;
            const distance = 150 + Math.random() * 250;
            const x = Math.cos(angle * Math.PI / 180) * distance;
            const y = Math.sin(angle * Math.PI / 180) * distance;
            teddy.style.setProperty('--x', x + 'px');
            teddy.style.setProperty('--y', y + 'px');
            container.appendChild(teddy);
            setTimeout(() => {
                teddy.classList.add('teddy-animation');
            }, 10);
            setTimeout(() => {
                if (teddy.parentNode) {
                    teddy.parentNode.removeChild(teddy);
                }
            }, 4000);
        }, i * 150);
    }
}
</script> 