import "./bootstrap";

document.addEventListener("click", function (e) {
    if (e.target.closest(".toggle-password")) {
        const button = e.target.closest(".toggle-password");
        const wrapper = button.closest(".relative");
        const input = wrapper.querySelector("input");
        const icon = button.querySelector("i");

        if (input && input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else if (input) {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
});

// Auto-dismiss flash messages
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(function () {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(function (alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(function () {
                alert.remove();
            }, 500);
        });
    }, 4000);
});

// Add loading state to forms
document.addEventListener("submit", function (e) {
    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');

    // Only apply if button exists and not already loading
    if (submitBtn && !submitBtn.classList.contains("loading")) {
        const originalText = submitBtn.innerHTML;
        submitBtn.classList.add("loading", "opacity-75", "cursor-wait");
        submitBtn.innerHTML =
            '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

        // Disable button to prevent double submit
        submitBtn.disabled = true;

        // Store original text to restore if needed (though usually page reloads)
        submitBtn.dataset.originalText = originalText;
    }
});

// =====================================================
// THEME TOGGLE (Light/Dark Mode)
// =====================================================
function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.toggle("dark");
    localStorage.setItem("theme", isDark ? "dark" : "light");
    updateThemeIcon(isDark);

    // Update Chart.js colors if charts are present
    if (typeof updateChartsForTheme === "function") {
        updateChartsForTheme(isDark);
    }
}

function updateThemeIcon(isDark) {
    const sunIcons = document.querySelectorAll(".theme-icon-sun");
    const moonIcons = document.querySelectorAll(".theme-icon-moon");

    sunIcons.forEach((icon) => {
        icon.classList.toggle("hidden", !isDark);
    });
    moonIcons.forEach((icon) => {
        icon.classList.toggle("hidden", isDark);
    });
}

// Initialize icon state on DOMContentLoaded
document.addEventListener("DOMContentLoaded", function () {
    const isDark = document.documentElement.classList.contains("dark");
    updateThemeIcon(isDark);
});

// Expose globally for onclick handlers
window.toggleTheme = toggleTheme;

// Client-side password validation
document.addEventListener("input", function (e) {
    if (e.target.matches('input[name="password_confirmation"]')) {
        const confirmInput = e.target;
        const form = confirmInput.closest("form");
        const passwordInput = form.querySelector('input[name="password"]');

        if (passwordInput && confirmInput.value) {
            if (passwordInput.value !== confirmInput.value) {
                confirmInput.classList.add(
                    "border-red-500",
                    "focus:border-red-500",
                    "focus:ring-red-500/10",
                );
                confirmInput.classList.remove(
                    "border-green-500",
                    "focus:border-green-500",
                    "focus:ring-green-500/10",
                );
            } else {
                confirmInput.classList.remove(
                    "border-red-500",
                    "focus:border-red-500",
                    "focus:ring-red-500/10",
                );
                confirmInput.classList.add(
                    "border-green-500",
                    "focus:border-green-500",
                    "focus:ring-green-500/10",
                );
            }
        } else {
            confirmInput.classList.remove(
                "border-red-500",
                "focus:border-red-500",
                "focus:ring-red-500/10",
                "border-green-500",
                "focus:border-green-500",
                "focus:ring-green-500/10",
            );
        }
    }
});
