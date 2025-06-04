<!-- Kuis Header dan Sidebar -->
<nav class="bg-white border-b border-gray-200 shadow-sm px-6 py-3 flex justify-between items-center">
    <div class="text-lg font-semibold text-gray-800">
        🧠 Kuis Aktif
    </div>
    <div class="text-sm text-gray-600">
        Waktu Tersisa: <span id="countdown" class="font-bold text-red-600"></span>
    </div>
    <button class="text-gray-600 hover:text-gray-800" id="sidebarToggle" title="Navigasi Soal">
        <!-- List/Menu Icon -->
        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="4" y="5" width="16" height="2" rx="1"/>
            <rect x="4" y="11" width="16" height="2" rx="1"/>
            <rect x="4" y="17" width="16" height="2" rx="1"/>
        </svg>
    </button>
</nav>

<aside class="material-sidebar-popup hidden" id="materialSidebar">
    <div class="sidebar-popup-overlay" id="sidebarOverlay"></div>
    <div class="sidebar-popup-content">
        <div class="sidebar-title">Navigasi Soal</div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Soal</div>
            <ul class="sidebar-list">
                @foreach ($test->questions as $index => $question)
                    <li class="sidebar-item">
                        <a href="#question-{{ $index + 1 }}" class="question-link flex items-center space-x-2">
                            <span class="sidebar-icon">○</span>
                            <span>Soal {{ $index + 1 }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</aside>

<script>
    document.getElementById('sidebarToggle').onclick = function () {
        document.getElementById('materialSidebar').classList.toggle('hidden');
    };
    document.getElementById('sidebarOverlay').onclick = function () {
        document.getElementById('materialSidebar').classList.add('hidden');
    };

    // Navigasi soal aktif & highlight jawaban
    const inputs = document.querySelectorAll("input[type='radio']");
    const questionLinks = document.querySelectorAll(".question-link");

    function updateHighlight() {
        questionLinks.forEach((link, index) => {
            const questionId = `answers[${inputs[index]?.name.match(/\d+/)[0]}]`;
            const answered = document.querySelector(`input[name='${questionId}']:checked`);
            const icon = link.querySelector('.sidebar-icon');

            if (answered) {
                icon.textContent = '◉';
                link.classList.add('text-green-600');
            } else {
                icon.textContent = '○';
                link.classList.remove('text-green-600');
            }
        });
    }

    inputs.forEach(input => input.addEventListener('change', updateHighlight));
    document.addEventListener('DOMContentLoaded', updateHighlight);
</script>
