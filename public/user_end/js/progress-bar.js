document.addEventListener('DOMContentLoaded', function() {
    const previousBtn = document.getElementById('previous-btn');
    const nextBtn = document.getElementById('next-btn');
    const steps = document.querySelectorAll('.step');
    let currentStepIndex = 0;

    // Function to update progress on the progress bar
    function updateProgress() {
        steps.forEach((step, index) => {
            if (index <= currentStepIndex) {
                step.classList.add('completed');
            } else {
                step.classList.remove('completed');
            }
        });
    }

    // Function to move to the next step
    function nextStep() {
        if (currentStepIndex < steps.length - 1) {
            currentStepIndex++;
            updateProgress();
            animateButtonTransition('next');
        }
    }

    // Function to move to the previous step
    function previousStep() {
        if (currentStepIndex > 0) {
            currentStepIndex--;
            updateProgress();
            animateButtonTransition('previous');
        }
    }

    // Function to animate button transition
    function animateButtonTransition(direction) {
        const button = direction === 'next' ? nextBtn : previousBtn;

        // Animate button by slightly scaling it when clicked
        button.style.transform = 'scale(1.2)';
        button.style.opacity = '0.7';
        
        setTimeout(() => {
            button.style.transform = 'scale(1)';
            button.style.opacity = '1';
        }, 300);
    }

    // Event listeners for Next and Previous buttons
    nextBtn.addEventListener('click', function(e) {
        e.preventDefault();
        nextStep();
    });

    previousBtn.addEventListener('click', function(e) {
        e.preventDefault();
        previousStep();
    });

    // Update the progress initially based on the current route
    updateProgress();
});
