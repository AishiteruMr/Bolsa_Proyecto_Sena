/**
 * Login Portal Interactions
 */
document.addEventListener('DOMContentLoaded', function() {
    // Password Visibility Toggle
    const passwordInput = document.querySelector('input[name="password"]');
    if (passwordInput) {
        const wrapper = passwordInput.parentElement;
        const toggleBtn = document.createElement('button');
        toggleBtn.type = 'button';
        toggleBtn.className = 'password-toggle';
        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
        toggleBtn.style.cssText = `
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8fa38f; /* Light green text-lighter */
            cursor: pointer;
            padding: 8px;
            font-size: 16px;
            transition: all 0.3s;
            z-index: 10;
        `;
        
        wrapper.style.position = 'relative';
        wrapper.style.display = 'block';
        wrapper.appendChild(toggleBtn);

        toggleBtn.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
            this.style.color = type === 'password' ? '#8fa38f' : 'var(--primary)';
        });
    }

    // Role Card Staggered Animation
    const cards = document.querySelectorAll('.role-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 400 + (index * 100));
    });
});
