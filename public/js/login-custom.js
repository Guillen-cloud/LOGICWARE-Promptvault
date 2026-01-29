/* ==============================
   LOGIN CUSTOM JAVASCRIPT
   ============================== */

document.addEventListener('DOMContentLoaded', function () {
    initializeLoginForm();
    initializePasswordToggle();
    initializeFormValidation();
    initializeAnimations();
});

/**
 * Initialize Password Toggle
 */
function initializePasswordToggle() {
    const toggleButton = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    if (!toggleButton || !passwordInput) return;

    toggleButton.addEventListener('click', function (e) {
        e.preventDefault();

        const isPassword = passwordInput.type === 'password';
        passwordInput.type = isPassword ? 'text' : 'password';
        toggleButton.textContent = isPassword ? '🙈' : '👁';

        // Add visual feedback
        toggleButton.style.transform = 'scale(1.1)';
        setTimeout(() => {
            toggleButton.style.transform = 'scale(1)';
        }, 200);
    });
}

/**
 * Initialize Form Validation
 */
function initializeFormValidation() {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    if (!form) return;

    // Real-time validation
    emailInput?.addEventListener('blur', function () {
        validateEmail(this);
    });

    passwordInput?.addEventListener('input', function () {
        removeErrorState(this);
    });

    // Form submission
    form.addEventListener('submit', function (e) {
        const isValid = validateForm();
        if (!isValid) {
            e.preventDefault();
        } else {
            addLoadingState();
        }
    });
}

/**
 * Validate Email
 */
function validateEmail(input) {
    const email = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email && !emailRegex.test(email)) {
        addErrorState(input, 'Correo electrónico inválido');
        return false;
    } else {
        removeErrorState(input);
        return true;
    }
}

/**
 * Validate Form
 */
function validateForm() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    let isValid = true;

    // Validate email
    if (!emailInput.value.trim()) {
        addErrorState(emailInput, 'El correo es requerido');
        isValid = false;
    } else if (!validateEmail(emailInput)) {
        isValid = false;
    }

    // Validate password
    if (!passwordInput.value) {
        addErrorState(passwordInput, 'La contraseña es requerida');
        isValid = false;
    } else if (passwordInput.value.length < 6) {
        addErrorState(passwordInput, 'La contraseña debe tener al menos 6 caracteres');
        isValid = false;
    }

    return isValid;
}

/**
 * Add Error State
 */
function addErrorState(input, message) {
    input.classList.add('error');

    // Remove existing error message
    const existingError = input.parentElement.querySelector('.form-error');
    if (existingError) {
        existingError.remove();
    }

    // Add new error message
    const errorElement = document.createElement('span');
    errorElement.className = 'form-error';
    errorElement.textContent = message;
    input.parentElement.appendChild(errorElement);
}

/**
 * Remove Error State
 */
function removeErrorState(input) {
    input.classList.remove('error');
    const errorElement = input.parentElement.querySelector('.form-error');
    if (errorElement) {
        errorElement.remove();
    }
}

/**
 * Add Loading State to Button
 */
function addLoadingState() {
    const button = document.querySelector('.btn-primary');
    if (button) {
        button.disabled = true;
        button.classList.add('btn-loading');
        button.textContent = '';
    }
}

/**
 * Initialize Form
 */
function initializeLoginForm() {
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const rememberMe = document.getElementById('remember_me');

    if (!form) return;

    // Restore email from localStorage if available
    const savedEmail = localStorage.getItem('login_email');
    if (savedEmail && emailInput) {
        emailInput.value = savedEmail;
    }

    // Restore remember me state
    const rememberChecked = localStorage.getItem('login_remember');
    if (rememberChecked === 'true' && rememberMe) {
        rememberMe.checked = true;
    }

    // Save email when remember me is checked
    form.addEventListener('submit', function () {
        if (rememberMe?.checked && emailInput) {
            localStorage.setItem('login_email', emailInput.value);
            localStorage.setItem('login_remember', 'true');
        } else {
            localStorage.removeItem('login_email');
            localStorage.removeItem('login_remember');
        }
    });
}

/**
 * Initialize Animations
 */
function initializeAnimations() {
    const formGroups = document.querySelectorAll('.form-group');

    formGroups.forEach((group, index) => {
        group.style.animation = `slideUp ${0.6 + index * 0.1}s ease-out`;
    });

    // Add hover effects to links
    const links = document.querySelectorAll('.link-forgot, .link-register');
    links.forEach(link => {
        link.addEventListener('mouseenter', function () {
            this.style.transform = 'translateX(2px)';
        });

        link.addEventListener('mouseleave', function () {
            this.style.transform = 'translateX(0)';
        });
    });
}

/**
 * Enhanced Password Strength Indicator (opcional)
 */
function getPasswordStrength(password) {
    let strength = 0;

    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[!@#$%^&*]/.test(password)) strength++;

    return strength;
}

/**
 * Prevent Multiple Submissions
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');

    if (form) {
        let submitted = false;

        form.addEventListener('submit', function (e) {
            if (submitted) {
                e.preventDefault();
            }
            submitted = true;
        });
    }
});
