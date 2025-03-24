
// Include Toastify CSS dynamically (optional if not included in layout)
if (!document.querySelector("link[href*='toastify-js']")) {
    const link = document.createElement("link");
    link.rel = "stylesheet";
    link.href = "https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css";
    document.head.appendChild(link);
}

// Add Progress Bar Animation CSS
const style = document.createElement("style");
style.innerHTML = `
    @keyframes progressBar {
        from { width: 100%; }
        to { width: 0%; }
    }
    .toast-container {
        position: relative;
        padding-bottom: 6px;
    }
    .progress-bar {
        height: 6px;
        width: 100%;
        background: rgba(255, 255, 255, 0.8);
        position: absolute;
        bottom: 0;
        left: 0;
        border-radius: 0 0 5px 5px;
        animation: progressBar 3s linear forwards;
    }
`;
document.head.appendChild(style);

// Function to show Toastify notification with progress bar
function showToast(message, bgColor, duration = 3000) {
    if (!message) return; // Prevent empty messages

    const toastContent = document.createElement("div");
    toastContent.classList.add("toast-container");
    toastContent.innerText = message;
    toastContent.style.padding = "12px";

    const progressBar = document.createElement("div");
    progressBar.classList.add("progress-bar");
    progressBar.style.animationDuration = duration + "ms";
    
    toastContent.appendChild(progressBar);

    Toastify({
        node: toastContent,
        duration: duration,
        gravity: "top",
        position: "right",
        backgroundColor: bgColor,
        stopOnFocus: true,
        close: true,
    }).showToast();
}

// Auto-show success or error messages if set
document.addEventListener("DOMContentLoaded", function () {
    if (typeof successMessage !== "undefined" && successMessage) {
        showToast(successMessage, "linear-gradient(to right, #28a745, #218838)");
    }
    if (typeof errorMessage !== "undefined" && errorMessage) {
        showToast(errorMessage, "linear-gradient(to right, #dc3545, #c82333)");
    }
});
