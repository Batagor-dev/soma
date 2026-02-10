/**
 * Contact Form Handler for APRI Mancing Community
 * Mengirim email ke farelhasdika@gmail.com
 */

class ContactForm {
    constructor() {
        // Element form
        this.form = document.getElementById("contactForm");
        this.submitButton = document.getElementById("submitButton");
        this.submitText = this.submitButton.querySelector(".submit-text");
        this.spinner = this.submitButton.querySelector(".spinner-border");
        this.successAlert = document.getElementById("contactSuccess");
        this.errorAlert = document.getElementById("contactError");
        this.errorMessage = document.getElementById("errorMessage");

        // Konfigurasi email
        this.RECIPIENT_EMAIL = "farelhasdika@gmail.com";
        this.FORMSPREE_ENDPOINT = "https://formspree.io/f/mjvnvywa"; // Ganti dengan Formspree ID Anda

        this.init();
    }

    /**
     * Inisialisasi form
     */
    init() {
        if (!this.form) {
            console.error("Form kontak tidak ditemukan!");
            return;
        }

        this.form.addEventListener("submit", (e) => this.handleSubmit(e));
        this.initInputValidation();
        this.initFormAnimation();
    }

    /**
     * Inisialisasi validasi input
     */
    initInputValidation() {
        const inputs = this.form.querySelectorAll(".contact-input[required]");

        inputs.forEach((input) => {
            // Validasi saat mengetik
            input.addEventListener("input", () => {
                if (input.classList.contains("is-invalid")) {
                    this.validateField(input);
                }
            });

            // Validasi saat kehilangan fokus
            input.addEventListener("blur", () => {
                this.validateField(input);
            });

            // Hapus error state saat mulai mengetik
            input.addEventListener("focus", () => {
                input.classList.remove("is-invalid");
                this.hideError();
            });
        });
    }

    /**
     * Inisialisasi animasi form
     */
    initFormAnimation() {
        const inputs = document.querySelectorAll(".contact-input");
        inputs.forEach((input) => {
            input.addEventListener("focus", () => {
                input.parentElement.classList.add("focused");
                this.animateInput(input);
            });

            input.addEventListener("blur", () => {
                input.parentElement.classList.remove("focused");
            });
        });
    }

    /**
     * Animasi input saat fokus
     */
    animateInput(input) {
        input.style.transform = "translateY(-2px)";
        setTimeout(() => {
            input.style.transform = "translateY(0)";
        }, 200);
    }

    /**
     * Validasi field individual
     */
    validateField(input) {
        const value = input.value.trim();
        let isValid = true;

        // Validasi field required
        if (input.hasAttribute("required") && !value) {
            isValid = false;
        }

        // Validasi email
        if (input.type === "email" && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
            }
        }

        // Validasi nomor telepon (opsional)
        if (input.id === "contactPhone" && value) {
            const phoneRegex = /^[0-9+\-\s()]{10,}$/;
            if (!phoneRegex.test(value.replace(/\s/g, ""))) {
                isValid = false;
            }
        }

        if (isValid) {
            input.classList.remove("is-invalid");
            input.classList.add("is-valid");
            return true;
        } else {
            input.classList.add("is-invalid");
            input.classList.remove("is-valid");
            return false;
        }
    }

    /**
     * Validasi seluruh form
     */
    validateForm() {
        let isValid = true;
        const inputs = this.form.querySelectorAll(".contact-input[required]");

        // Reset validasi
        inputs.forEach((input) => {
            input.classList.remove("is-valid", "is-invalid");
        });

        // Validasi setiap field
        inputs.forEach((input) => {
            if (!this.validateField(input)) {
                isValid = false;
                // Scroll ke field yang error
                if (isValid === false) {
                    input.scrollIntoView({
                        behavior: "smooth",
                        block: "center",
                    });
                }
            }
        });

        // Validasi tambahan untuk kategori
        const category = document.getElementById("contactCategory");
        if (category && !category.value) {
            category.classList.add("is-invalid");
            isValid = false;
            category.scrollIntoView({ behavior: "smooth", block: "center" });
        }

        return isValid;
    }

    /**
     * Handle submit form
     */
    async handleSubmit(e) {
        e.preventDefault();

        // Validasi form
        if (!this.validateForm()) {
            this.showError(
                "Harap periksa kembali data yang Anda masukkan. Beberapa field wajib diisi dengan benar.",
                5000
            );
            return;
        }

        // Tampilkan loading
        this.showLoading();

        // Kumpulkan data form
        const formData = this.collectFormData();

        try {
            // Pilih metode pengiriman
            const response = await this.sendWithFormspree(formData);

            if (response.ok) {
                this.showSuccess();
                this.resetForm();
                this.trackFormSubmission(formData);
            } else {
                throw new Error(
                    "Gagal mengirim form. Status: " + response.status
                );
            }
        } catch (error) {
            console.error("Error mengirim form:", error);

            // Fallback ke mailto jika Formspree gagal
            try {
                await this.sendWithMailto(formData);
                this.showSuccess();
                this.resetForm();
            } catch (mailtoError) {
                this.showError(
                    "Gagal mengirim pesan. Silakan coba lagi atau hubungi kami langsung di farelhasdika@gmail.com",
                    7000
                );
            }
        } finally {
            this.hideLoading();
        }
    }

    /**
     * Kumpulkan data dari form
     */
    collectFormData() {
        const now = new Date();
        return {
            name: document.getElementById("contactName").value.trim(),
            email: document.getElementById("contactEmail").value.trim(),
            phone:
                document.getElementById("contactPhone").value.trim() ||
                "Tidak diisi",
            category: document.getElementById("contactCategory").value,
            message: document.getElementById("contactMessage").value.trim(),
            timestamp: now.toISOString(),
            date: now.toLocaleDateString("id-ID", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            }),
            page: window.location.href,
            userAgent: navigator.userAgent,
            source: "APRI Mancing Website Contact Form",
        };
    }

    /**
     * Metode 1: Menggunakan Formspree (Recommended)
     */
    async sendWithFormspree(formData) {
        // Ganti YOUR_FORM_ID dengan ID dari Formspree
        const formspreeEndpoint = this.FORMSPREE_ENDPOINT.replace("mjvnvywa"); // Contoh ID

        const formDataObj = new FormData();
        formDataObj.append("name", formData.name);
        formDataObj.append("email", formData.email);
        formDataObj.append("phone", formData.phone);
        formDataObj.append("category", formData.category);
        formDataObj.append("message", formData.message);
        formDataObj.append("timestamp", formData.timestamp);
        formDataObj.append(
            "_subject",
            `Pesan Baru dari ${formData.name} - APRI Mancing`
        );
        formDataObj.append("_replyto", formData.email);
        formDataObj.append("_cc", this.RECIPIENT_EMAIL);

        return await fetch(formspreeEndpoint, {
            method: "POST",
            body: formDataObj,
            headers: {
                Accept: "application/json",
            },
        });
    }

    /**
     * Metode 2: Fallback menggunakan mailto
     */
    async sendWithMailto(formData) {
        const subject = `Pesan dari ${formData.name} - APRI Mancing Website`;
        const body = `
Nama: ${formData.name}
Email: ${formData.email}
Telepon: ${formData.phone}
Kategori: ${formData.category}
Waktu: ${formData.date}

Pesan:
${formData.message}

---
Dikirim dari: ${formData.page}
User Agent: ${formData.userAgent}
        `.trim();

        const mailtoLink = `mailto:${
            this.RECIPIENT_EMAIL
        }?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(
            body
        )}`;

        // Buka mailto link
        window.location.href = mailtoLink;

        return new Promise((resolve, reject) => {
            // Simulasi delay untuk memberi waktu mail client terbuka
            setTimeout(() => {
                resolve({ success: true });
            }, 1000);
        });
    }

    /**
     * Track form submission untuk analytics
     */
    trackFormSubmission(formData) {
        // Google Analytics (jika ada)
        if (typeof gtag !== "undefined") {
            gtag("event", "form_submit", {
                event_category: "Contact",
                event_label: formData.category,
                value: 1,
            });
        }

        // Log ke console untuk debugging
        console.log("Form submitted successfully:", {
            name: formData.name,
            email: formData.email,
            category: formData.category,
            timestamp: formData.timestamp,
        });

        // Simpan ke localStorage sebagai backup
        try {
            const submissions = JSON.parse(
                localStorage.getItem("apri_form_submissions") || "[]"
            );
            submissions.push({
                ...formData,
                submittedAt: new Date().toISOString(),
            });
            localStorage.setItem(
                "apri_form_submissions",
                JSON.stringify(submissions.slice(-10))
            ); // Simpan 10 terakhir
        } catch (e) {
            console.warn("Gagal menyimpan ke localStorage:", e);
        }
    }

    /**
     * Tampilkan loading state
     */
    showLoading() {
        if (this.submitText) this.submitText.classList.add("d-none");
        if (this.spinner) this.spinner.classList.remove("d-none");
        if (this.submitButton) this.submitButton.disabled = true;

        // Tambahkan efek animasi pada tombol
        this.submitButton.style.opacity = "0.8";
        this.submitButton.style.cursor = "not-allowed";
    }

    /**
     * Sembunyikan loading state
     */
    hideLoading() {
        if (this.submitText) this.submitText.classList.remove("d-none");
        if (this.spinner) this.spinner.classList.add("d-none");
        if (this.submitButton) this.submitButton.disabled = false;

        // Kembalikan style tombol
        this.submitButton.style.opacity = "1";
        this.submitButton.style.cursor = "pointer";
    }

    /**
     * Tampilkan pesan sukses
     */
    showSuccess() {
        if (this.successAlert) {
            this.successAlert.classList.remove("d-none");
            this.successAlert.classList.add("show");

            // Tambahkan animasi
            this.successAlert.style.animation = "fadeInUp 0.5s ease";

            // Scroll ke alert
            this.successAlert.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }

        if (this.errorAlert) {
            this.errorAlert.classList.remove("show");
            this.errorAlert.classList.add("d-none");
        }

        // Auto-hide setelah 8 detik
        setTimeout(() => {
            this.hideSuccess();
        }, 8000);
    }

    /**
     * Sembunyikan pesan sukses
     */
    hideSuccess() {
        if (this.successAlert) {
            this.successAlert.classList.remove("show");
            setTimeout(() => {
                this.successAlert.classList.add("d-none");
            }, 300);
        }
    }

    /**
     * Tampilkan pesan error
     */
    showError(message, duration = 5000) {
        if (this.errorMessage) {
            this.errorMessage.textContent = message;
        }

        if (this.errorAlert) {
            this.errorAlert.classList.remove("d-none");
            this.errorAlert.classList.add("show");

            // Tambahkan animasi
            this.errorAlert.style.animation = "shake 0.5s ease";

            // Scroll ke alert
            this.errorAlert.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
        }

        if (this.successAlert) {
            this.successAlert.classList.remove("show");
            this.successAlert.classList.add("d-none");
        }

        // Auto-hide setelah waktu tertentu
        if (duration > 0) {
            setTimeout(() => {
                this.hideError();
            }, duration);
        }
    }

    /**
     * Sembunyikan pesan error
     */
    hideError() {
        if (this.errorAlert) {
            this.errorAlert.classList.remove("show");
            setTimeout(() => {
                this.errorAlert.classList.add("d-none");
            }, 300);
        }
    }

    /**
     * Reset form
     */
    resetForm() {
        this.form.reset();

        // Reset semua validasi state
        const inputs = this.form.querySelectorAll(".contact-input");
        inputs.forEach((input) => {
            input.classList.remove("is-valid", "is-invalid");
        });

        // Reset select ke pilihan pertama
        const select = document.getElementById("contactCategory");
        if (select) {
            select.selectedIndex = 0;
        }

        // Fokus ke input pertama
        const firstInput = document.getElementById("contactName");
        if (firstInput) {
            setTimeout(() => {
                firstInput.focus();
            }, 100);
        }
    }

    /**
     * Export data submissions (untuk debugging)
     */
    exportSubmissions() {
        try {
            const submissions = JSON.parse(
                localStorage.getItem("apri_form_submissions") || "[]"
            );
            const blob = new Blob([JSON.stringify(submissions, null, 2)], {
                type: "application/json",
            });
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `apri_submissions_${
                new Date().toISOString().split("T")[0]
            }.json`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (e) {
            console.error("Gagal export data:", e);
        }
    }
}

/**
 * Tambahkan CSS animations untuk form
 */
function injectFormStyles() {
    const style = document.createElement("style");
    style.textContent = `
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .is-valid {
            border-color: #198754 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%23198754' d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        
        .contact-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25) !important;
        }
        
        .contact-submit-btn:disabled {
            opacity: 0.65;
            cursor: not-allowed !important;
        }
        
        .focused .form-label {
            color: #0d6efd;
            font-weight: 600;
        }
    `;
    document.head.appendChild(style);
}

/**
 * Setup Formspree dengan ID Anda
 * Dapatkan Formspree ID di: https://formspree.io/
 */
function setupFormspree() {
    // Ganti dengan Formspree ID Anda
    const FORMSPREE_ID = "xvoewqwe"; // Contoh: dapatkan dari Formspree dashboard

    const form = document.getElementById("contactForm");
    if (form && FORMSPREE_ID) {
        form.action = `https://formspree.io/f/${FORMSPREE_ID}`;
        form.method = "POST";
    }
}

/**
 * Inisialisasi saat halaman siap
 */
function initializeContactForm() {
    // Inject styles
    injectFormStyles();

    // Setup Formspree
    setupFormspree();

    // Initialize form handler
    document.addEventListener("DOMContentLoaded", () => {
        const contactForm = new ContactForm();

        // Debug mode (hapus di production)
        window.debugContactForm = contactForm;

        console.log("Contact form initialized successfully!");
        console.log("Emails will be sent to: farelhasdika@gmail.com");

        // Tambahkan event listener untuk tombol reset (debug)
        const resetBtn = document.getElementById("debugReset");
        if (resetBtn) {
            resetBtn.addEventListener("click", () => contactForm.resetForm());
        }
    });
}

/**
 * Cek ketersediaan Formspree endpoint
 */
async function checkFormspreeAvailability() {
    try {
        const response = await fetch("https://formspree.io/f/xvoewqwe", {
            method: "HEAD",
        });
        return response.ok;
    } catch (error) {
        return false;
    }
}

// Auto-initialize
initializeContactForm();

// Ekspor untuk penggunaan module (opsional)
if (typeof module !== "undefined" && module.exports) {
    module.exports = { ContactForm, initializeContactForm };
}
