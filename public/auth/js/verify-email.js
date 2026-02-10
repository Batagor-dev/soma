document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("resendBtn");
    if (!btn) return;

    let cooldown = 60;
    btn.disabled = true;
    btn.innerHTML = `Tunggu ${cooldown}s`;

    const timer = setInterval(() => {
        cooldown--;
        btn.innerHTML = `Tunggu ${cooldown}s`;

        if (cooldown <= 0) {
            clearInterval(timer);
            btn.disabled = false;
            btn.innerHTML = `
                <i class="bi bi-arrow-repeat"></i>
                <span>Kirim Ulang Email</span>
            `;
        }
    }, 1000);
});
