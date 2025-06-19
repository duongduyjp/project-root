// Biến toàn cục
var currentWord = '';
var hasPraise = false;
var praiseMessage = '';

// Khởi tạo game
function initListenGame(word, praise, message) {
    currentWord = word;
    hasPraise = praise;
    praiseMessage = message;
    
    const speakButton = document.getElementById('speakButton');
    
    // Phát âm khi click nút loa
    speakButton.addEventListener('click', function() {
        speak(currentWord);
        
        // Hiệu ứng khi click
        this.style.transform = 'scale(0.9)';
        setTimeout(() => {
            this.style.transform = 'scale(1)';
        }, 150);
    });

    // Hiệu ứng pháo giấy và gấu bông khi trả lời đúng
    if (hasPraise) {
        createConfettiAndTeddy();
        
        // Đọc câu khích lệ
        if ('speechSynthesis' in window && praiseMessage) {
            const utterance = new SpeechSynthesisUtterance(praiseMessage);
            utterance.lang = 'vi-VN';
            utterance.rate = 1.5;
            utterance.pitch = 1.2;
            speechSynthesis.speak(utterance);
        }
    }
}

// Hàm phát âm sử dụng cùng cấu hình như trang từ vựng
function speak(text) {
    if ('speechSynthesis' in window) {
        const synth = window.speechSynthesis;
        let voices = synth.getVoices();
        if (!voices.length) {
            synth.onvoiceschanged = () => speak(text);
            synth.getVoices();
            return;
        }
        // Ưu tiên voice Google (giống Google Dịch)
        let googleVoice = voices.find(v => v.name.includes('Google') && v.lang.startsWith('en'));
        // Nếu không có, ưu tiên giọng nữ tiếng Anh
        let femaleVoice = voices.find(v => v.lang.startsWith('en') && v.name.match(/female|woman|girl|Samantha|Jenny|Linda|Susan|Zira|Emma|Amy|Joanna|Kendra|Kimberly|Salli|Ivy|Mia|Olivia|Tessa|Victoria|Fiona|Karen|Moira|Tessa/i) && v.gender !== 'male');
        if (!femaleVoice) {
            femaleVoice = voices.find(v => v.lang.startsWith('en') && v.gender !== 'male');
        }
        if (!femaleVoice) {
            femaleVoice = voices.find(v => v.lang.startsWith('en'));
        }
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US';
        utterance.rate = 0.85;
        if (googleVoice) {
            utterance.voice = googleVoice;
        } else if (femaleVoice) {
            utterance.voice = femaleVoice;
        }
        synth.speak(utterance);
    } else {
        alert('Trình duyệt của bạn không hỗ trợ phát âm!');
    }
}

// Tạo hiệu ứng pháo giấy và gấu bông
function createConfettiAndTeddy() {
    const container = document.getElementById('confetti-container');
    const centerX = window.innerWidth / 2;
    const centerY = window.innerHeight / 2;
    
    // Tạo pháo giấy
    for (let i = 0; i < 50; i++) {
        setTimeout(() => {
            const confetti = document.createElement('div');
            confetti.className = 'confetti';
            
            // Random loại pháo giấy
            const types = ['', 'square', 'triangle'];
            const randomType = types[Math.floor(Math.random() * types.length)];
            if (randomType) confetti.classList.add(randomType);
            
            // Random màu sắc
            const colors = ['#ff6b6b', '#4ecdc4', '#45b7d1', '#96ceb4', '#feca57', '#ff9ff3', '#a8e6cf', '#ff8b94'];
            confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
            
            // Random vị trí bắn ra từ giữa
            const angle = (Math.PI * 2 * i) / 50;
            const distance = 50 + Math.random() * 100;
            const startX = centerX + Math.cos(angle) * distance;
            const startY = centerY + Math.sin(angle) * distance;
            
            confetti.style.left = startX + 'px';
            confetti.style.top = startY + 'px';
            
            container.appendChild(confetti);
            
            // Xóa sau khi animation kết thúc
            setTimeout(() => {
                confetti.remove();
            }, 3000);
        }, i * 50);
    }
    
    // Tạo gấu bông
    const teddyEmojis = ['🧸', '🐻', '🐨', '🐼'];
    for (let i = 0; i < 15; i++) {
        setTimeout(() => {
            const teddy = document.createElement('div');
            teddy.className = 'teddy-bear';
            teddy.textContent = teddyEmojis[Math.floor(Math.random() * teddyEmojis.length)];
            
            // Random vị trí bắn ra từ giữa
            const angle = (Math.PI * 2 * i) / 15;
            const distance = 80 + Math.random() * 120;
            const startX = centerX + Math.cos(angle) * distance;
            const startY = centerY + Math.sin(angle) * distance;
            
            teddy.style.left = startX + 'px';
            teddy.style.top = startY + 'px';
            
            container.appendChild(teddy);
            
            // Xóa sau khi animation kết thúc
            setTimeout(() => {
                teddy.remove();
            }, 3000);
        }, i * 100);
    }
} 